<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscriber;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

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

        NewsletterSubscriber::updateOrCreate(
            ['email' => strtolower($data['email'])],
            ['consent_at' => now()],
        );
        RateLimiter::hit($key, 3600);

        return back()->with('newsletter_success', 'Thank you. You are now subscribed to VALUEMAP updates.');
    }
}
