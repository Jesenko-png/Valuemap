<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use App\Models\NewsletterSubscriber;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminInboxTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_approved_admin_roles_can_read_inbox_and_subscribers(): void
    {
        $message = ContactMessage::create(['name' => 'Visitor', 'email' => 'visitor@example.org', 'subject' => 'Question', 'message' => 'Private message']);
        $urls = ['/admin/messages', '/admin/messages/'.$message->id, '/admin/subscribers'];
        foreach ($urls as $url) {
            $this->get($url)->assertRedirect('/login');
        }
        foreach ([[User::ROLE_READER, true], [User::ROLE_ADMIN, false]] as [$role, $approved]) {
            $this->actingAs(User::factory()->create(['role' => $role, 'is_approved' => $approved]));
            foreach ($urls as $url) {
                $this->get($url)->assertRedirect('/login');
            }
        }
        foreach ([User::ROLE_ADMIN, User::ROLE_MAIN_ADMIN] as $role) {
            $this->actingAs(User::factory()->create(['role' => $role, 'is_approved' => true]));
            foreach ($urls as $url) {
                $this->get($url)->assertOk();
            }
        }
    }

    public function test_message_search_and_detail_escape_submitted_html(): void
    {
        $this->actingAs(User::factory()->create(['role' => User::ROLE_ADMIN, 'is_approved' => true]));
        $message = ContactMessage::create(['name' => 'Visitor', 'email' => 'visitor@example.org', 'organisation' => 'Research group', 'subject' => 'Collaboration', 'message' => '<script>alert(1)</script>']);
        ContactMessage::create(['name' => 'Other', 'email' => 'other@example.org', 'subject' => 'Unrelated question', 'message' => 'Other message']);
        $this->get('/admin/messages?q=Research')->assertSee('Collaboration')->assertDontSee('Unrelated question');
        $this->get('/admin/messages/'.$message->id)->assertSee('visitor@example.org')->assertSee('&lt;script&gt;', false)->assertDontSee('<script>alert(1)</script>', false);
        $this->get('/admin/messages/999999')->assertNotFound();
    }

    public function test_subscriber_search_pagination_and_empty_state(): void
    {
        $this->actingAs(User::factory()->create(['role' => User::ROLE_MAIN_ADMIN, 'is_approved' => true]));
        for ($i = 0; $i < 22; $i++) {
            NewsletterSubscriber::create(['email' => 'member'.$i.'@example.org', 'consent_at' => now()]);
        }
        $this->get('/admin/subscribers?q=member')->assertOk()->assertSee('member21@example.org')->assertDontSee('member0@example.org')->assertSee('q=member', false);
        $this->get('/admin/subscribers?q=member&page=2')->assertSee('member0@example.org')->assertDontSee('member21@example.org');
        $this->get('/admin/subscribers?q=missing')->assertSee('No registrations match your filters.');
    }

    public function test_subscriber_status_filters(): void
    {
        $this->actingAs(User::factory()->create(['role' => User::ROLE_ADMIN, 'is_approved' => true]));
        NewsletterSubscriber::create(['email' => 'active@example.org', 'consent_at' => now(), 'confirmed_at' => now()]);
        NewsletterSubscriber::create(['email' => 'pending@example.org', 'consent_at' => now()]);
        NewsletterSubscriber::create(['email' => 'stopped@example.org', 'consent_at' => now(), 'confirmed_at' => now(), 'unsubscribed_at' => now()]);

        $this->get('/admin/subscribers?status=active')->assertSee('active@example.org')->assertDontSee('pending@example.org')->assertDontSee('stopped@example.org');
        $this->get('/admin/subscribers?status=pending')->assertSee('pending@example.org')->assertDontSee('active@example.org');
        $this->get('/admin/subscribers?status=unsubscribed')->assertSee('stopped@example.org')->assertDontSee('active@example.org');
    }
}
