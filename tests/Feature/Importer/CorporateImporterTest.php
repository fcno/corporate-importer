<?php

/**
 * @see https://pestphp.com/docs/
 */

use Fcno\CorporateImporter\CorporateImporter as Importer;
use Fcno\CorporateImporter\Exceptions\FileNotReadableException;
use Fcno\CorporateImporter\Facades\CorporateImporter;
use Fcno\CorporateImporter\Models\Cargo;
use Fcno\CorporateImporter\Models\Funcao;
use Fcno\CorporateImporter\Models\Lotacao;
use Fcno\CorporateImporter\Models\Usuario;
use Illuminate\Support\Facades\Log;

test('facade retorna objeto da classe', function () {
    expect(CorporateImporter::from($this->file_path))->toBeInstanceOf(Importer::class);
});

test('lança exceção ao executar a importação com arquivo inválido', function ($file_name) {
    expect(
        fn () => CorporateImporter::from($file_name)->run()
    )->toThrow(FileNotReadableException::class);
})->with([
    'inexistente.xml', // inexistente
    '',                // falso boleano
]);

test('cria apenas os logs de validação se o package for configurado para não logar', function () {
    config(['corporateimporter.logging' => false]);

    $infos
        = 0  // início da importação
        + 0; // fim da importação
    $warnings
        = 6   // cargos inválidos
        + 6   // funções inválidas
        + 18  // lotações inválidas
        + 13; // fim da importação

    Log::shouldReceive('log')
        ->times($infos)
        ->withArgs(
            function ($level) {
                return $level === 'info';
            }
        );

    Log::shouldReceive('log')
        ->times($warnings)
        ->withArgs(
            function ($level) {
                return $level === 'warning';
            }
        );

    CorporateImporter::from($this->file_path)->run();

    expect(Cargo::count())->toBe(3)
    ->and(Funcao::count())->toBe(3)
    ->and(Lotacao::count())->toBe(5)
    ->and(Usuario::count())->toBe(5);
});

test('importa a estrutura corporativa completa e cria todos os logs', function () {
    $infos
        = 1  // início da importação
        + 1; // fim da importação
    $warnings
        = 6   // cargos inválidos
        + 6   // funções inválidas
        + 18  // lotações inválidas
        + 13; // fim da importação

    Log::shouldReceive('log')
        ->times($infos)
        ->withArgs(
            function ($level) {
                return $level === 'info';
            }
        );

    Log::shouldReceive('log')
        ->times($warnings)
        ->withArgs(
            function ($level) {
                return $level === 'warning';
            }
        );

    CorporateImporter::from($this->file_path)->run();

    expect(Cargo::count())->toBe(3)
    ->and(Funcao::count())->toBe(3)
    ->and(Lotacao::count())->toBe(5)
    ->and(Usuario::count())->toBe(5);
});
