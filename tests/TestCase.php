<?php

namespace Fcno\CorporateImporter\Tests;

use Fcno\CorporateImporter\CorporateImporterServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Schema;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    /**
     * Additional setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Fcno\\CorporateImporter\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            CorporateImporterServiceProvider::class,
        ];
    }

    /**
     * Perform environment setup.
     */
    protected function getEnvironmentSetUp($app)
    {
        Schema::dropAllTables();

        include_once __DIR__.'/../database/migrations/create_cargos_table.php.stub';
        include_once __DIR__.'/../database/migrations/create_funcoes_table.php.stub';
        include_once __DIR__.'/../database/migrations/create_lotacoes_table.php.stub';
        include_once __DIR__.'/../database/migrations/create_usuarios_table.php.stub';

        (new \CreateCargosTable())->up();
        (new \CreateFuncoesTable())->up();
        (new \CreateLotacoesTable())->up();
        (new \CreateUsuariosTable())->up();
    }
}
