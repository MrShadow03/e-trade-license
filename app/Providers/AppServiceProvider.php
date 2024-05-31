<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use App\Models\TradeLicenseApplication;
use Illuminate\Support\ServiceProvider;
use App\Policies\TradeLicenseApplicationPolicy;
use App\Services\TradeLicenseApplicationService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::before(function ($user, $ability) {
            if (auth()->guard('admin')->check() && in_array($user->phone, ['01766555213'])) {
                return true;
            }
        
            return null;
        });
    }
}
