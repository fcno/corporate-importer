<?php

/**
 * @see https://pestphp.com/docs/
 */

use Fcno\CorporateImporter\Models\Cargo;

test('retorna os cargos usando o escopo ascendente por nome', function () {
    $first = 'Cargo A';
    $second = 'Cargo B';
    $third = 'Cargo C';

    Cargo::factory()
            ->create(['nome' => $third]);

    Cargo::factory()
            ->create(['nome' => $first]);

    Cargo::factory()
            ->create(['nome' => $second]);

    $cargos = Cargo::sort()
                    ->get();

    expect($cargos->get(0)->nome)->toBe($first)
    ->and($cargos->get(1)->nome)->toBe($second)
    ->and($cargos->get(2)->nome)->toBe($third);
});
