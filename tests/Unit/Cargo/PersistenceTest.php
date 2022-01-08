<?php

use Fcno\CorporateImporter\Models\Cargo;
use Illuminate\Support\Str;

test('cadastra múltiplos cargos', function () {
    $amount = 30;

    Cargo::factory()
            ->count($amount)
            ->create();

    expect(Cargo::count())->toBe($amount);
});

test('nome do cargo em seu tamanho máximo é aceito', function () {
    Cargo::factory()
            ->create(['nome' => Str::random(255)]);

    expect(Cargo::count())->toBe(1);
});
