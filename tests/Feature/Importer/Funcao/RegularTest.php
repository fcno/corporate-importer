<?php

/**
 * @see https://pestphp.com/docs/
 */

use Fcno\CorporateImporter\Importer\FuncaoImporter;
use Fcno\CorporateImporter\Models\Funcao;
use Illuminate\Support\Facades\Log;

test('make retorna o objeto da classe', function () {
    expect(FuncaoImporter::make())->toBeInstanceOf(FuncaoImporter::class);
});

test('consegue importar as funções do arquivo corporativo', function () {
    // forçar a execução de duas queries em pontos distintos e testá-las
    config(['corporateimporter.maxupsert' => 2]);

    FuncaoImporter::make()
                    ->from($this->file_path)
                    ->execute();
    $funcoes = Funcao::get();

    expect($funcoes)->toHaveCount(3)
    ->and($funcoes->pluck('nome'))->toMatchArray(['Função 1', 'Função 2', 'Função 3']);
});

test('cria os logs para as funções inválidas', function () {
    Log::shouldReceive('log')
        ->times(6)
        ->withArgs(
            function ($level) {
                return $level === 'warning';
            }
        );

    FuncaoImporter::make()
                    ->from($this->file_path)
                    ->execute();

    expect(Funcao::count())->toBe(3);
});
