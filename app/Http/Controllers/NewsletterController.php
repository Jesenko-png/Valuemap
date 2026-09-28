<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscriber;
use App\Notifications\ConfirmNewsletterSubscription;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\View\View;

class NewsletterController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        if ($request->filled('website')) {
            return back()->with('newsletter_success', 'Thank you. Your subscription has been received.');
        }

        $key = 'newsletter:'.$request->ip();
        if (RateLimiter::tooManyAttempts($key, 4)) {
            return back()->withErrors(['email' => 'Too many attempts. Please try again later.'], 'newsletter');
        }

        $data = $request->validateWithBag('newsletter', [
            'email' => ['required', 'email', 'max:180'],
            'consent' => ['accepted'],
        ]);

        $subscriber = NewsletterSubscriber::firstOrNew(['email' => strtolower($data['email'])]);
        if ($subscriber->exists && $subscriber->confirmed_at && ! $subscriber->unsubscribed_at) {
            return back()->with('newsletter_success', 'This email address is already subscribed.');
        }

        $subscriber->fill(['consent_at' => now(), 'confirmed_at' => null, 'unsubscribed_at' => null])->save();
        $subscriber->notify(new ConfirmNewsletterSubscription);
        RateLimiter::hit($key, 3600);

        return back()->with('newsletter_success', 'Check your email and confirm your subscription within 48 hours.');
    }

    public function confirm(NewsletterSubscriber $subscriber): View
    {
        if ($subscriber->unsubscribed_at) {
            return view('newsletter.status', ['title' => 'Subscription inactive', 'message' => 'This subscription request was cancelled. Submit the newsletter form again if you want to subscribe.', 'subscriber' => null]);
        }

        if (! $subscriber->confirmed_at) {
            $subscriber->update(['confirmed_at' => now()]);
        }

        return view('newsletter.status', ['title' => 'Subscription confirmed', 'message' => 'You will now receive VALUEMAP project updates.', 'subscriber' => $subscriber]);
    }

    public function unsubscribeForm(NewsletterSubscriber $subscriber): View
    {
        return view('newsletter.unsubscribe', compact('subscriber'));
    }

    public function unsubscribe(NewsletterSubscriber $subscriber): View
    {
        if (! $subscriber->unsubscribed_at) {
            $subscriber->update(['unsubscribed_at' => now()]);
        }

        return view('newsletter.status', ['title' => 'You are unsubscribed', 'message' => 'This email address will no longer receive VALUEMAP newsletter messages.', 'subscriber' => null]);
    }
}
