<?php

/**
 * @see https://pestphp.com/docs/
 */

use Fcno\CorporateImporter\Exceptions\FileNotReadableException;
use Fcno\CorporateImporter\Importer\FuncaoImporter;

test('lança exceção ao executar a importação com arquivo inválido', function ($file_name) {
    expect(
        fn () => FuncaoImporter::make()
                                ->from($file_name)
                                ->execute()
    )->toThrow(FileNotReadableException::class);
})->with([
    'inexistente.xml', // inexistente
    '',                // falso boleano
]);
