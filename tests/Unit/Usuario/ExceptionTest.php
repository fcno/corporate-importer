<?php

/**
 * @see https://pestphp.com/docs/
 */

use Fcno\CorporateImporter\Models\Usuario;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;

test('lança exceção ao tentar cadastrar usuários em duplicidade, isto é, com siglas iguais', function () {
    expect(
        fn () => Usuario::factory()
                        ->count(2)
                        ->create(['sigla' => 'aduser'])
    )->toThrow(QueryException::class, 'Duplicate entry');
});

test('lança exceção ao tentar cadastrar usuário com campo inválido', function ($field, $value, $msg) {
    expect(
        fn () => Usuario::factory()
                        ->create([$field => $value])
    )->toThrow(QueryException::class, $msg);
})->with([
    ['nome',  Str::random(256), 'Data too long for column'], //campo aceita no máximo 255 caracteres
    ['sigla', Str::random(21),  'Data too long for column'], //campo aceita no máximo 20 caracteres
    ['sigla', null,             'cannot be null'],           //campo obrigatório
]);
