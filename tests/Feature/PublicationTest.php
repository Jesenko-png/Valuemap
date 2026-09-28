<?php

namespace Tests\Feature;

use App\Models\ContentItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicationTest extends TestCase
{
    use RefreshDatabase;

    private function item(array $attributes = []): ContentItem
    {
        return ContentItem::create(array_merge([
            'title' => 'Health data workshop', 'slug' => 'workshop', 'type' => 'event',
            'status' => 'published', 'is_public' => true, 'approval_status' => 'approved',
            'category' => 'Research', 'published_at' => now()->subDay(), 'event_date' => now()->addDays(2),
        ], $attributes));
    }

    public function test_hidden_states_are_excluded_from_all_public_surfaces(): void
    {
        foreach ([['status' => 'draft'], ['approval_status' => 'pending'], ['is_public' => false], ['published_at' => now()->addDays(3)]] as $i => $state) {
            $item = $this->item([...$state, 'slug' => 'private-'.$i, 'title' => 'Private publication '.$i]);
            $this->get('/library/'.$item->slug)->assertNotFound();
            foreach (['/', '/news-media', '/sitemap.xml'] as $url) {
                $this->get($url)->assertDontSee($item->title)->assertDontSee('/library/'.$item->slug);
            }
        }
    }

    public function test_filters_combine_and_upcoming_events_use_chronological_order(): void
    {
        $this->item();
        $this->item(['slug' => 'later', 'title' => 'Health later workshop', 'event_date' => now()->addDays(5)]);
        $this->item(['slug' => 'past', 'title' => 'Past workshop', 'event_date' => now()->subDay()]);
        $this->item(['slug' => 'other', 'title' => 'Unrelated category', 'category' => 'Policy']);
        $this->item(['slug' => 'news', 'title' => 'News workshop', 'type' => 'news']);
        $response = $this->get('/news-media?type=event&category=Research&period=upcoming&q=Health');
        $response->assertOk()->assertSeeInOrder(['Health data workshop', 'Health later workshop'])
            ->assertDontSee('Past workshop')->assertDontSee('Unrelated category')->assertDontSee('News workshop')
            ->assertSee('name="type" value="event"', false);
        $this->get('/news-media?type=event&period=past')->assertSee('Past workshop')->assertDontSee('Health data workshop');
    }

    public function test_main_admin_publishes_and_admin_changes_require_reapproval_without_changing_url(): void
    {
        $main = User::factory()->create(['role' => User::ROLE_MAIN_ADMIN, 'is_approved' => true]);
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN, 'is_approved' => true]);
        $payload = ['type' => 'news', 'title' => 'Original title', 'status' => 'published', 'is_public' => 1];
        $this->actingAs($main)->post('/admin/content', $payload)->assertRedirect('/admin');
        $item = ContentItem::firstOrFail();
        $this->get('/library/original-title')->assertOk();
        $this->actingAs($admin)->put('/admin/content/'.$item->id, [...$payload, 'title' => 'Revised title', 'approval_status' => 'approved'])
            ->assertRedirect('/admin');
        $this->assertSame('original-title', $item->fresh()->slug);
        $this->assertSame('pending', $item->fresh()->approval_status);
        $this->get('/library/original-title')->assertNotFound();
        $this->actingAs($main)->get('/admin?review=pending')->assertOk()->assertSee('Revised title');
        $this->patch('/admin/content/'.$item->id.'/return')->assertRedirect();
        $this->assertSame('draft', $item->fresh()->status);
    }

    public function test_scheduled_content_becomes_visible_on_publication_date(): void
    {
        $item = $this->item(['published_at' => now()->addDays(2)]);
        $this->assertSame('Scheduled', $item->visibility_label);
        $this->get('/library/'.$item->slug)->assertNotFound();
        $this->travel(3)->days();
        $this->get('/library/'.$item->slug)->assertOk();
    }

    public function test_result_and_newsletter_filters_do_not_mix_content_types(): void
    {
        $this->item(['type' => 'deliverable', 'slug' => 'report', 'title' => 'Approved report']);
        $this->item(['type' => 'newsletter', 'slug' => 'issue', 'title' => 'Newsletter issue']);
        $this->get('/results?type=deliverable')->assertSee('Approved report')->assertDontSee('Newsletter issue');
        $this->get('/news-media?type=newsletter')->assertSee('Newsletter issue')->assertDontSee('Approved report');
    }
}
