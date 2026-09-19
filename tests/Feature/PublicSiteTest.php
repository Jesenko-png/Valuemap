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
        $this->get('/admin')->assertRedirect('/login');
    }

    public function test_administrator_can_create_public_content(): void
    {
        $admin = User::factory()->create(['is_admin' => false, 'role' => User::ROLE_ADMIN, 'is_approved' => true]);

        foreach (['news', 'event', 'deliverable', 'newsletter'] as $type) {
            $title = 'Published '.ucfirst($type);

            $this->actingAs($admin)->post('/admin/content', [
                'type' => $type,
                'title' => $title,
                'reference_code' => $type === 'deliverable' ? 'D2.1' : null,
                'excerpt' => 'A concise public item.',
                'body' => 'Public content.',
                'status' => 'published',
                'published_at' => now()->format('Y-m-d'),
                'is_public' => '1',
            ])->assertRedirect('/admin');

            $this->assertDatabaseHas(ContentItem::class, [
                'type' => $type,
                'title' => $title,
                'is_public' => true,
            ]);
        }
        foreach (['news', 'event', 'deliverable', 'newsletter'] as $type) {
            $this->get('/library/published-'.$type)->assertOk()->assertSee('Published '.ucfirst($type));
        }
    }

    public function test_registration_waits_for_main_administrator_approval(): void
    {
        $this->post('/register', [
            'name' => 'Project partner',
            'email' => 'partner@example.com',
            'requested_role' => 'admin',
            'password' => 'Projectpass1',
            'password_confirmation' => 'Projectpass1',
        ])->assertRedirect('/login');

        $this->assertDatabaseHas('users', [
            'email' => 'partner@example.com',
            'role' => User::ROLE_READER,
            'requested_role' => User::ROLE_ADMIN,
            'is_approved' => false,
        ]);

        $this->post('/login', ['email' => 'partner@example.com', 'password' => 'Projectpass1'])
            ->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_main_administrator_can_approve_role_requests(): void
    {
        $mainAdmin = User::factory()->create(['is_admin' => true, 'role' => User::ROLE_MAIN_ADMIN, 'is_approved' => true]);
        $pending = User::factory()->create(['role' => User::ROLE_READER, 'requested_role' => User::ROLE_ADMIN, 'is_approved' => false]);

        $this->actingAs($mainAdmin)->patch('/admin/users/'.$pending->id, [
            'role' => User::ROLE_ADMIN,
            'is_approved' => '1',
        ])->assertRedirect();

        $this->assertDatabaseHas('users', [
            'id' => $pending->id,
            'role' => User::ROLE_ADMIN,
            'is_approved' => true,
            'is_admin' => true,
        ]);
    }

    public function test_reader_cannot_access_content_management(): void
    {
        $reader = User::factory()->create(['role' => User::ROLE_READER, 'is_approved' => true, 'is_admin' => false]);

        $this->actingAs($reader)->get('/account')->assertOk();
        $this->actingAs($reader)->get('/admin')->assertRedirect('/login');
    }

    public function test_administrator_cannot_manage_user_roles(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN, 'is_approved' => true, 'is_admin' => true]);

        $this->actingAs($admin)->get('/admin/users')->assertForbidden();
    }
}
