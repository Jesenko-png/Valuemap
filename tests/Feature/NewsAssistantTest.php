<?php

namespace Tests\Feature;

use App\Models\ContentItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class NewsAssistantTest extends TestCase
{
    use RefreshDatabase;

    public function test_approved_administrator_can_generate_a_structured_news_draft_without_publishing_it(): void
    {
        config()->set('services.gemini.api_key', 'test-secret');
        config()->set('services.gemini.news_model', 'gemini-3.5-flash-lite');
        $admin = User::factory()->create([
            'role' => User::ROLE_ADMIN,
            'is_approved' => true,
        ]);
        $draft = [
            'title' => 'VALUEMAP partners meet in Budapest',
            'excerpt' => 'Partners met to coordinate the next phase of the project.',
            'body' => 'The VALUEMAP consortium met in Budapest to review its planned activities.',
            'category' => 'Project update',
        ];

        Http::fake([
            'generativelanguage.googleapis.com/*' => Http::response([
                'candidates' => [[
                    'content' => [
                        'parts' => [[
                            'text' => json_encode($draft, JSON_THROW_ON_ERROR),
                        ]],
                    ],
                ]],
            ]),
        ]);

        $this->actingAs($admin)
            ->postJson(route('admin.news-assistant.generate'), [
                'facts' => 'The VALUEMAP consortium met in Budapest on 2 October to coordinate planned activities.',
                'tone' => 'professional',
            ])
            ->assertOk()
            ->assertJson(['draft' => $draft]);

        $this->assertSame(0, ContentItem::count());
        Http::assertSent(fn ($request) => $request->url() === 'https://generativelanguage.googleapis.com/v1beta/models/gemini-3.5-flash-lite:generateContent'
            && $request->hasHeader('x-goog-api-key', 'test-secret')
            && data_get($request->data(), 'generationConfig.responseMimeType') === 'application/json'
            && data_get($request->data(), 'generationConfig.responseSchema.type') === 'OBJECT');
    }

    public function test_news_assistant_requires_configuration_and_valid_source_notes(): void
    {
        config()->set('services.gemini.api_key');
        $admin = User::factory()->create([
            'role' => User::ROLE_ADMIN,
            'is_approved' => true,
        ]);

        $this->actingAs($admin)
            ->postJson(route('admin.news-assistant.generate'), ['facts' => 'too short'])
            ->assertUnprocessable();

        $this->postJson(route('admin.news-assistant.generate'), [
            'facts' => 'These are verified source notes long enough for a draft.',
        ])->assertStatus(503)->assertJsonFragment(['message' => 'The AI assistant is not configured. Add GEMINI_API_KEY to the server environment.']);
    }

    public function test_reader_cannot_use_news_assistant(): void
    {
        config()->set('services.gemini.api_key', 'test-secret');
        $reader = User::factory()->create([
            'role' => User::ROLE_READER,
            'is_approved' => true,
        ]);

        $this->actingAs($reader)
            ->postJson(route('admin.news-assistant.generate'), [
                'facts' => 'These are verified source notes long enough for a draft.',
            ])
            ->assertRedirect(route('login'));

        Http::assertNothingSent();
    }

    public function test_invalid_gemini_key_returns_a_precise_safe_message(): void
    {
        config()->set('services.gemini.api_key', 'invalid-test-key');
        $admin = User::factory()->create([
            'role' => User::ROLE_ADMIN,
            'is_approved' => true,
        ]);
        Http::fake([
            'generativelanguage.googleapis.com/*' => Http::response([
                'error' => ['message' => 'Sensitive provider error'],
            ], 401),
        ]);

        $this->actingAs($admin)
            ->postJson(route('admin.news-assistant.generate'), [
                'facts' => 'These are verified source notes long enough for a draft.',
            ])
            ->assertStatus(502)
            ->assertJsonFragment([
                'message' => 'Gemini rejected the API key. Create a valid Gemini API key in Google AI Studio and update GEMINI_API_KEY.',
            ])
            ->assertJsonMissing(['message' => 'Sensitive provider error']);
    }
}
