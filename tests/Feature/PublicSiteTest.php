<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use App\Models\ContentItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicSiteTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_pages_are_available(): void
    {
        foreach (['/', '/about', '/structure', '/consortium', '/ecosystem', '/results', '/news-media', '/contact'] as $uri) {
            $this->get($uri)->assertOk();
        }
    }

    public function test_only_public_content_is_listed(): void
    {
        ContentItem::create(['type' => 'news', 'title' => 'Visible update', 'slug' => 'visible-update', 'status' => 'published', 'is_public' => true, 'published_at' => now()]);
        ContentItem::create(['type' => 'news', 'title' => 'Hidden update', 'slug' => 'hidden-update', 'status' => 'draft', 'is_public' => false]);

        $this->get('/news-media')->assertSee('Visible update')->assertDontSee('Hidden update');
    }

    public function test_contact_form_stores_a_valid_message(): void
    {
        $this->post('/contact', ['name' => 'Project visitor', 'email' => 'visitor@example.com', 'organisation' => 'Example', 'subject' => 'Collaboration', 'message' => 'I would like to learn more about ValueMap.'])
            ->assertSessionHas('success');

        $this->assertDatabaseCount(ContactMessage::class, 1);
    }

    public function test_admin_area_is_protected(): void
    {
        $this->get('/admin')->assertRedirect('/admin/login');
    }

    public function test_administrator_can_create_public_content(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $this->actingAs($admin)->post('/admin/content', [
            'type' => 'deliverable',
            'title' => 'Public ecosystem report',
            'reference_code' => 'D2.1',
            'excerpt' => 'A concise public report.',
            'body' => 'Report content.',
            'status' => 'published',
            'published_at' => now()->format('Y-m-d'),
            'is_public' => '1',
        ])->assertRedirect('/admin');

        $this->assertDatabaseHas(ContentItem::class, ['slug' => 'public-ecosystem-report', 'is_public' => true]);
        $this->get('/library/public-ecosystem-report')->assertOk()->assertSee('Public ecosystem report');
    }
}
