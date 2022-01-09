<?php

/**
 * @see https://pestphp.com/docs/
 */

use Fcno\CorporateImporter\Importer\CargoImporter;
use Fcno\CorporateImporter\Importer\FuncaoImporter;
use Fcno\CorporateImporter\Importer\LotacaoImporter;
use Fcno\CorporateImporter\Importer\UsuarioImporter;
use Fcno\CorporateImporter\Models\Usuario;
use Illuminate\Support\Facades\Log;

test('make retorna o objeto da classe', function () {
    expect(UsuarioImporter::make())->toBeInstanceOf(UsuarioImporter::class);
});

test('consegue importar os usuários do arquivo corporativo', function () {
    // forçar a execução de duas queries em pontos distintos e testá-las
    config(['corporateimporter.maxupsert' => 2]);

    CargoImporter::make()
                    ->from($this->file_path)
                    ->execute();
    FuncaoImporter::make()
                    ->from($this->file_path)
                    ->execute();
    LotacaoImporter::make()
                    ->from($this->file_path)
                    ->execute();
    UsuarioImporter::make()
                    ->from($this->file_path)
                    ->execute();
    $usuarios = Usuario::get();

    expect($usuarios)->toHaveCount(5)
    ->and($usuarios->pluck('nome'))->toMatchArray(['Pessoa 1', 'Pessoa 2', 'Pessoa 3', 'Pessoa 4', 'Pessoa 5']);
});

test('cria os logs para os usuários inválidos', function () {
    CargoImporter::make()
        ->from($this->file_path)
        ->execute();
    FuncaoImporter::make()
        ->from($this->file_path)
        ->execute();
    LotacaoImporter::make()
        ->from($this->file_path)
        ->execute();

    Log::shouldReceive('log')
        ->times(13)
        ->withArgs(
            function ($level) {
                return $level === 'warning';
            }
        );

    UsuarioImporter::make()
        ->from($this->file_path)
        ->execute();

    expect(Usuario::count())->toBe(5);
});
