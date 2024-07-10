<?php

use App\Http\Middleware\CanAny;
use App\Http\Middleware\MultiAuth;
use App\Http\Middleware\PasswordResetMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Application;
use App\Http\Middleware\PhoneVerifiedMiddleware;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Auth\Middleware\RedirectIfAuthenticated;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // redirect user depending on the guard
        RedirectIfAuthenticated::redirectUsing(function ($request) {
            if(Auth::guard('admin')->check()) {
                return route('admin.dashboard');
            }

            return route('user.dashboard');
        });

        // phone verification middleware
        $middleware->alias([
            'phone_verified' => PhoneVerifiedMiddleware::class,
            'can_any' => CanAny::class,
            'has_pure_password' => PasswordResetMiddleware::class,
            'auth_any' => MultiAuth::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
