<?php

/**
 * @see https://pestphp.com/docs/
 */

use Fcno\CorporateImporter\Models\Cargo;
use Fcno\CorporateImporter\Models\Usuario;

test('um cargo possui vários usuários', function () {
    $amount = 3;

    Cargo::factory()
            ->has(Usuario::factory()->count($amount), 'usuarios')
            ->create();

    $cargo = Cargo::with('usuarios')->first();

    expect($cargo->usuarios->random())->toBeInstanceOf(Usuario::class)
    ->and($cargo->usuarios)->toHaveCount($amount);
});
