<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()?->canManageContent()) {
            return redirect()->route('login')->with('error', 'Administrator access is required.');
        }

        return $next($request);
    }
}
