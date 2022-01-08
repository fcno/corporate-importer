<?php

/**
 * @see https://pestphp.com/docs/
 */

use Fcno\CorporateImporter\Importer\FuncaoImporter;
use Fcno\CorporateImporter\Models\Funcao;

test('make retorna o objeto da classe', function () {
    expect(FuncaoImporter::make())->toBeInstanceOf(FuncaoImporter::class);
});

test('importa as funções corretamente', function () {
    // forçar a execução de duas queries em pontos distintos e testá-las
    config(['corporateimporter.maxupsert' => 2]);

    FuncaoImporter::make()
                    ->from($this->file_system->path($this->file_name))
                    ->execute();
    $funcoes = Funcao::get();

    expect($funcoes)->toHaveCount(3)
    ->and($funcoes->pluck('nome'))->toMatchArray(['Função 1', 'Função 2', 'Função 3']);
})->only();
