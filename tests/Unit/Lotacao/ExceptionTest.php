<?php

/**
 * @see https://pestphp.com/docs/
 */

use Fcno\CorporateImporter\Models\Lotacao;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;

test('lança exceção ao tentar cadastrar lotações em duplicidade, isto é, com ids iguais', function () {
    expect(
        fn () => Lotacao::factory()
                        ->count(2)
                        ->create(['id' => 10])
    )->toThrow(QueryException::class, 'Duplicate entry');
});

test('lança exceção ao tentar cadastrar lotação com campo inválido', function ($field, $value, $msg) {
    expect(
        fn () => Lotacao::factory()
                        ->create([$field => $value])
    )->toThrow(QueryException::class, $msg);
})->with([
    ['id',    'texto',          'Incorrect integer value'],  //valor não conversível em inteiro
    ['id',    null,             'cannot be null'],           //campo obrigatório
    ['nome',  Str::random(256), 'Data too long for column'], //campo aceita no máximo 255 caracteres
    ['nome',  null,             'cannot be null'],           //campo obrigatório
    ['sigla', Str::random(51),  'Data too long for column'], //campo aceita no máximo 50 caracteres
    ['sigla', null,             'cannot be null'],           //campo obrigatório
]);
