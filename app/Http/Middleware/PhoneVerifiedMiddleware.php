<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PhoneVerifiedMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->user()->phone_verified_at === null) {
            // logout the user
            auth()->logout();
            return redirect()->route('login')->with('error', 'Please verify your phone number first.');
        }

        return $next($request);
    }
}
