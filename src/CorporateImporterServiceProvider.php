<?php

namespace Fcno\CorporateImporter;

use Illuminate\Support\ServiceProvider;

/**
 * @see https://laravel.com/docs/8.x/packages#service-providers
 * @see https://laravel.com/docs/8.x/providers
 */
class CorporateImporterServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'corporateimporter');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang/', 'corporateimporter');
    }

    public function boot(): void
    {
    }
}
