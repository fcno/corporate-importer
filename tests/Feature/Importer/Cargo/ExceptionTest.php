<?php

/**
 * @see https://pestphp.com/docs/
 */

use Fcno\CorporateImporter\Exceptions\FileNotReadableException;
use Fcno\CorporateImporter\Importer\CargoImporter;

test('lança exceção ao executar a importação com arquivo inválido', function ($file_name) {
    expect(
        fn () => CargoImporter::make()
                    ->from($file_name)
                    ->run()
    )->toThrow(FileNotReadableException::class);
})->with([
    'inexistente.xml', // inexistente
    '',                // falso boleano
]);
