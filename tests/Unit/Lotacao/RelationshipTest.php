<?php

/**
 * @see https://pestphp.com/docs/
 */

use Fcno\CorporateImporter\Models\Lotacao;
use Fcno\CorporateImporter\Models\Usuario;
use Illuminate\Database\QueryException;

test('lança exceção ao tentar definir relacionamento com lotação pai inexistente', function () {
    expect(
        fn () => Lotacao::factory()
                        ->create(['lotacao_pai' => 10])
    )->toThrow(QueryException::class, 'Cannot add or update a child row');
});

test('lotação pai é opcional', function () {
    Lotacao::factory()
            ->create(['lotacao_pai' => null]);

    expect(Lotacao::count())->toBe(1);
});

test('lotação pai tem várias filhas e a filha tem apenas um pai', function () {
    $amount_child = 3;
    $id_parent = 1;

    Lotacao::factory()
            ->create(['id' => $id_parent]);

    Lotacao::factory()
            ->count($amount_child)
            ->create(['lotacao_pai' => $id_parent]);

    $pai = Lotacao::with(['lotacoesFilha', 'lotacaoPai'])
                    ->find($id_parent);
    $filha = Lotacao::with(['lotacoesFilha', 'lotacaoPai'])
                    ->where('lotacao_pai', '=', $id_parent)
                    ->get()
                    ->random();

    expect($pai->lotacoesFilha)->toHaveCount($amount_child)
    ->and($pai->lotacaoPai)->toBeNull()
    ->and($filha->lotacaoPai->id)->toBe($pai->id)
    ->and($filha->lotacoesFilha)->toHaveCount(0);
});

test('uma lotação possui vários usuários', function () {
    $amount = 3;

    Lotacao::factory()
            ->has(Usuario::factory()->count($amount), 'usuarios')
            ->create();

    $lotacao = Lotacao::with(['usuarios'])->first();

    expect($lotacao->usuarios->random())->toBeInstanceOf(Usuario::class)
    ->and($lotacao->usuarios)->toHaveCount($amount);
});
