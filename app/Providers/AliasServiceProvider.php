<?php

namespace App\Providers;

use Illuminate\Foundation\AliasLoader;
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
        $loader->alias('IDDateFormat', \App\Helpers\IDDateFormat::class);
        $loader->alias('IDRCurrency', \App\Helpers\IDRCurrency::class);
        $loader->alias('NumberFormat', \App\Helpers\NumberFormat::class);
        $loader->alias('BerkasHelper', \App\Helpers\BerkasHelper::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
