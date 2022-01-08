<?php

use Fcno\CorporateImporter\Models\Funcao;
use Illuminate\Support\Str;

test('cadastra múltiplas funções', function () {
    $amount = 30;

    Funcao::factory()
            ->count($amount)
            ->create();

    expect(Funcao::count())->toBe($amount);
});

test('nome da função em seu tamanho máximo é aceito', function () {
    Funcao::factory()
            ->create(['nome' => Str::random(255)]);

    expect(Funcao::count())->toBe(1);
});
