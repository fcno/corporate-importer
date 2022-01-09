<?php

/**
 * @see https://pestphp.com/docs/
 */

use Fcno\CorporateImporter\CorporateImporter as Importer;
use Fcno\CorporateImporter\Facades\CorporateImporter;
use Fcno\CorporateImporter\Models\Cargo;
use Fcno\CorporateImporter\Models\Funcao;
use Fcno\CorporateImporter\Models\Lotacao;
use Fcno\CorporateImporter\Models\Usuario;

test('facade retorna objeto da classe', function () {
    expect(CorporateImporter::from($this->file_system->path($this->file_name)))->toBeInstanceOf(Importer::class);
});

test('importa a estrutura corporativa completa', function () {
    CorporateImporter::from($this->file_system->path($this->file_name))->run();

    expect(Cargo::count())->toBe(3)
    ->and(Funcao::count())->toBe(3)
    ->and(Lotacao::count())->toBe(5)
    ->and(Usuario::count())->toBe(5);
});
