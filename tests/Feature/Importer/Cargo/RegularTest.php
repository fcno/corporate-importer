<?php

/**
 * @see https://pestphp.com/docs/
 */

use Fcno\CorporateImporter\Importer\CargoImporter;
use Fcno\CorporateImporter\Models\Cargo;
use Illuminate\Support\Facades\Log;

test('make retorna o objeto da classe', function () {
    expect(CargoImporter::make())->toBeInstanceOf(CargoImporter::class);
});

test('consegue importar os cargos do arquivo corporativo', function () {
    // forçar a execução de duas queries em pontos distintos e testá-las
    config(['corporateimporter.maxupsert' => 2]);

    CargoImporter::make()
                    ->from($this->file_system->path($this->file_name))
                    ->execute();
    $cargos = Cargo::get();

    expect($cargos)->toHaveCount(3)
    ->and($cargos->pluck('nome'))->toMatchArray(['Cargo 1', 'Cargo 2', 'Cargo 3']);
});

test('cria os logs para os cargos inválidos', function () {
    Log::shouldReceive('log')
        ->times(6)
        ->withArgs(function($level) {
            return $level === 'warning';
        }
    );

    CargoImporter::make()
                    ->from($this->file_system->path($this->file_name))
                    ->execute();

    expect(Cargo::count())->toBe(3);
});
