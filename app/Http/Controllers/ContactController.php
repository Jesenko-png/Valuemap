<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function create(): View { return view('contact'); }

    public function store(Request $request): RedirectResponse
    {
        if ($request->filled('website')) {
            return back()->with('success', 'Thank you. Your message has been received.');
        }

        $key = 'contact:'.$request->ip();
        if (RateLimiter::tooManyAttempts($key, 3)) {
            return back()->withErrors(['message' => 'Too many messages. Please try again later.'])->withInput();
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'], 'email' => ['required', 'email', 'max:180'],
            'organisation' => ['nullable', 'string', 'max:180'], 'subject' => ['required', 'string', 'max:180'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        ContactMessage::create($data);
        RateLimiter::hit($key, 3600);

        return back()->with('success', 'Thank you. Your message has been received.');
    }
}
