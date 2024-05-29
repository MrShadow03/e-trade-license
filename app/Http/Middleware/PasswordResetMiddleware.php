<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PasswordResetMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user()->hasPurePassword()) {
            return redirect()->route('user.profile.edit')->with('pass-error', 'পাসওয়ার্ড রিসেট করে নিন।');
        }
        return $next($request);
    }
}
