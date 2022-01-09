<?php

use Fcno\CorporateImporter\Models\Usuario;
use Illuminate\Support\Str;

test('cadastra múltiplos usuários', function () {
    $amount = 30;

    Usuario::factory()
        ->count($amount)
        ->create();

    expect(Usuario::count())->toBe($amount);
});

test('campo do usuário em seu tamanho máximo é aceito', function ($field, $length) {
    Usuario::factory()
        ->create([$field => Str::random($length)]);

    expect(Usuario::count())->toBe(1);
})->with([
    ['nome', 255],
    ['sigla', 20],
]);

test('nome é opcional', function () {
    Usuario::factory()
        ->create(['nome' => null]);

    expect(Usuario::count())->toBe(1);
});
