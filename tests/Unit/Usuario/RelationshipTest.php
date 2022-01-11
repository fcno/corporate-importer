<?php

/**
 * @see https://pestphp.com/docs/
 */

use Fcno\CorporateImporter\Models\Cargo;
use Fcno\CorporateImporter\Models\Funcao;
use Fcno\CorporateImporter\Models\Lotacao;
use Fcno\CorporateImporter\Models\Usuario;
use Illuminate\Database\QueryException;

test('cargo, função e lotação são opcionais', function ($field) {
    Usuario::factory()
        ->create([$field => null]);

    expect(Usuario::count())->toBe(1);
})->with([
    'cargo_id',
    'funcao_id',
    'lotacao_id',
]);

test('um usuário possui um cargo, uma função e/ou uma lotação', function () {
    $cargo = Cargo::factory()->create();
    $funcao = Funcao::factory()->create();
    $lotacao = Lotacao::factory()->create();

    $usuario = Usuario::factory()
                ->for($cargo, 'cargo')
                ->for($funcao, 'funcao')
                ->for($lotacao, 'lotacao')
                ->create();

    $usuario->load(['cargo', 'funcao', 'lotacao']);

    expect($usuario->cargo)->toBeInstanceOf(Cargo::class)
    ->and($usuario->funcao)->toBeInstanceOf(Funcao::class)
    ->and($usuario->lotacao)->toBeInstanceOf(Lotacao::class);
});

test('lança exceção ao tentar definir relacionamento inválido', function ($field, $value, $msg) {
    expect(
        fn () => Usuario::factory()
                    ->create([$field => $value])
    )->toThrow(QueryException::class, $msg);
})->with([
    ['cargo_id',   10, 'Cannot add or update a child row'], //inexistente
    ['funcao_id',  10, 'Cannot add or update a child row'], //inexistente
    ['lotacao_id', 10, 'Cannot add or update a child row'], //inexistente
]);
