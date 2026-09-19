<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function create(): View
    {
        return view('admin.login');
    }

    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate(['email' => ['required', 'email'], 'password' => ['required', 'string']]);
        $key = 'admin-login:'.strtolower($credentials['email']).'|'.$request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            return back()->withErrors(['email' => 'Too many attempts. Try again in '.RateLimiter::availableIn($key).' seconds.'])->onlyInput('email');
        }

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            RateLimiter::hit($key, 60);

            return back()->withErrors(['email' => 'The provided credentials are not valid.'])->onlyInput('email');
        }

        RateLimiter::clear($key);
        $request->session()->regenerate();

        if (! $request->user()->canSignIn()) {
            Auth::logout();

            return back()->withErrors(['email' => 'Your account is waiting for approval by the main administrator.'])->onlyInput('email');
        }

        return redirect()->intended($request->user()->canManageContent() ? route('admin.index') : route('account.index'));
    }

    public function register(Request $request): RedirectResponse
    {
        $key = 'registration:'.$request->ip();
        if (RateLimiter::tooManyAttempts($key, 4)) {
            return back()->withErrors(['email' => 'Too many registration attempts. Try again later.'], 'register')->withInput();
        }

        $data = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'requested_role' => ['required', 'in:reader,admin'],
            'password' => ['required', 'confirmed', Password::min(10)->letters()->numbers()],
        ])->validateWithBag('register');

        User::create([
            'name' => $data['name'],
            'email' => strtolower($data['email']),
            'password' => $data['password'],
            'role' => User::ROLE_READER,
            'requested_role' => $data['requested_role'],
            'is_approved' => false,
            'is_admin' => false,
        ]);
        RateLimiter::hit($key, 3600);

        return redirect()->route('login')->with('registration_success', 'Registration received. The main administrator must approve your account before you can sign in.');
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'You have been signed out.');
    }
}
