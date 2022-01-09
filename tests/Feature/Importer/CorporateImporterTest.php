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

test('importa a estrutura corporativa completa', function () {
    CorporateImporter::from($this->file_path)->run();

    expect(Cargo::count())->toBe(3)
    ->and(Funcao::count())->toBe(3)
    ->and(Lotacao::count())->toBe(5)
    ->and(Usuario::count())->toBe(5);
});
