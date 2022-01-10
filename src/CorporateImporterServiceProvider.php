<?php

namespace Fcno\CorporateImporter;

use Illuminate\Support\ServiceProvider;

/**
 * @see https://laravel.com/docs/8.x/packages
 * @see https://laravel.com/docs/8.x/packages#service-providers
 * @see https://laravel.com/docs/8.x/providers
 */
class CorporateImporterServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'corporateimporter');

        $this->app->bind('corporate-importer', function ($app) {
            return new CorporateImporter();
        });
    }

    public function boot(): void
    {
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang/', 'corporateimporter');

        $this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/corporateimporter')
        ], 'lang');

        $this->publishes([
            __DIR__.'/../config/config.php' => config_path('corporateimporter.php')
        ], 'config');

        $this->publishes([
            __DIR__.'/../database/migrations/' => database_path('migrations')
        ], 'migrations');
    }
}
