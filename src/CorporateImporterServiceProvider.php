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

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../resources/lang' => resource_path('lang/vendor/corporateimporter'),
            ], 'lang');

            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('corporateimporter.php'),
            ], 'config');

            $this->publishes([
                __DIR__ . '/../database/migrations/create_cargos_table.php.stub' => database_path('migrations/2020_01_01_000000_create_cargos_table.php'),
                __DIR__ . '/../database/migrations/create_funcoes_table.php.stub' => database_path('migrations/2020_01_01_000000_create_funcoes_table.php'),
                __DIR__ . '/../database/migrations/create_lotacoes_table.php.stub' => database_path('migrations/2020_01_01_000000_create_lotacoes_table.php'),
                __DIR__ . '/../database/migrations/create_usuarios_table.php.stub' => database_path('migrations/2020_01_01_000000_create_usuarios_table.php'),
            ], 'migrations');
        }
    }
}
