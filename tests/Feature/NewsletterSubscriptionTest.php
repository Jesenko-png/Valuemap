<?php

namespace Tests\Feature;

use App\Models\NewsletterSubscriber;
use App\Notifications\ConfirmNewsletterSubscription;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class NewsletterSubscriptionTest extends TestCase
{
    use RefreshDatabase;

    public function test_subscription_requires_email_confirmation(): void
    {
        Notification::fake();

        $this->post('/newsletter/subscribe', ['email' => 'Reader@Example.org', 'consent' => '1'])
            ->assertSessionHas('newsletter_success', 'Check your email and confirm your subscription within 48 hours.');

        $subscriber = NewsletterSubscriber::firstOrFail();
        $this->assertSame('reader@example.org', $subscriber->email);
        $this->assertNull($subscriber->confirmed_at);
        $this->assertNull($subscriber->unsubscribed_at);
        Notification::assertSentTo($subscriber, ConfirmNewsletterSubscription::class);

        $confirmUrl = URL::temporarySignedRoute('newsletter.confirm', now()->addHours(48), ['subscriber' => $subscriber]);
        $this->get($confirmUrl)->assertOk()->assertSee('Subscription confirmed');
        $this->assertNotNull($subscriber->fresh()->confirmed_at);
        $this->assertDatabaseCount('newsletter_subscribers', 1);
    }

    public function test_unsubscribe_requires_confirmation_and_is_idempotent(): void
    {
        $subscriber = NewsletterSubscriber::create([
            'email' => 'reader@example.org', 'consent_at' => now(), 'confirmed_at' => now(),
        ]);
        $url = URL::signedRoute('newsletter.unsubscribe', ['subscriber' => $subscriber]);
        $postUrl = URL::signedRoute('newsletter.unsubscribe.store', ['subscriber' => $subscriber]);

        $this->get($url)->assertOk()->assertSee('Confirm unsubscribe');
        $this->assertNull($subscriber->fresh()->unsubscribed_at);
        $this->post($postUrl)->assertOk()->assertSee('You are unsubscribed');
        $firstTimestamp = $subscriber->fresh()->unsubscribed_at;
        $this->post($postUrl)->assertOk();
        $this->assertTrue($firstTimestamp->equalTo($subscriber->fresh()->unsubscribed_at));
        $this->assertDatabaseCount(NewsletterSubscriber::active()->getModel()->getTable(), 1);
        $this->assertSame(0, NewsletterSubscriber::active()->count());
    }

    public function test_invalid_expired_or_changed_signed_links_are_rejected(): void
    {
        $subscriber = NewsletterSubscriber::create(['email' => 'reader@example.org', 'consent_at' => now()]);
        $valid = URL::temporarySignedRoute('newsletter.confirm', now()->addHour(), ['subscriber' => $subscriber]);
        $this->get($valid.'&changed=1')->assertForbidden();
        $expired = URL::temporarySignedRoute('newsletter.confirm', now()->subMinute(), ['subscriber' => $subscriber]);
        $this->get($expired)->assertForbidden();
        $this->get('/newsletter/unsubscribe/'.$subscriber->id)->assertForbidden();
    }

    public function test_active_duplicate_is_not_resent_and_unsubscribed_address_can_request_again(): void
    {
        Notification::fake();
        $subscriber = NewsletterSubscriber::create([
            'email' => 'reader@example.org', 'consent_at' => now()->subDay(), 'confirmed_at' => now()->subDay(),
        ]);
        $this->post('/newsletter/subscribe', ['email' => $subscriber->email, 'consent' => '1'])
            ->assertSessionHas('newsletter_success', 'This email address is already subscribed.');
        Notification::assertNothingSent();

        $subscriber->update(['unsubscribed_at' => now()]);
        $this->post('/newsletter/subscribe', ['email' => $subscriber->email, 'consent' => '1'])
            ->assertSessionHas('newsletter_success');
        $subscriber->refresh();
        $this->assertNull($subscriber->confirmed_at);
        $this->assertNull($subscriber->unsubscribed_at);
        Notification::assertSentTo($subscriber, ConfirmNewsletterSubscription::class);
    }

    public function test_cancelled_pending_request_cannot_be_reactivated_by_old_confirmation_link(): void
    {
        $subscriber = NewsletterSubscriber::create(['email' => 'reader@example.org', 'consent_at' => now()]);
        $confirmUrl = URL::temporarySignedRoute('newsletter.confirm', now()->addHour(), ['subscriber' => $subscriber]);
        $unsubscribeUrl = URL::signedRoute('newsletter.unsubscribe.store', ['subscriber' => $subscriber]);
        $this->post($unsubscribeUrl)->assertOk();
        $this->get($confirmUrl)->assertOk()->assertSee('Subscription inactive');
        $this->assertNull($subscriber->fresh()->confirmed_at);
    }
}
