<?php

/**
 * @see https://pestphp.com/docs/
 */

use Fcno\CorporateImporter\Models\Funcao;
use Fcno\CorporateImporter\Models\Usuario;

test('uma função possui vários usuários', function () {
    $amount = 3;

    Funcao::factory()
        ->has(Usuario::factory()->count($amount), 'usuarios')
        ->create();

    $funcao = Funcao::with('usuarios')->first();

    expect($funcao->usuarios->random())->toBeInstanceOf(Usuario::class)
    ->and($funcao->usuarios)->toHaveCount($amount);
});
