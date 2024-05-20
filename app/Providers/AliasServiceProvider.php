<?php

namespace App\Providers;

use App\Helpers\Helpers;
use Illuminate\Foundation\AliasLoader;
use Milon\Barcode\Facades\DNS1DFacade;
use Milon\Barcode\Facades\DNS2DFacade;
use Illuminate\Support\ServiceProvider;

class AliasServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Get the AliasLoader instance
        $loader = AliasLoader::getInstance();

        // Add your aliases
        $loader->alias('Helpers', Helpers::class);
        $loader->alias('DNS1D', DNS1DFacade::class,);
        $loader->alias('DNS2D', DNS2DFacade::class,);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
