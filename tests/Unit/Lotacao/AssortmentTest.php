<?php

/**
 * @see https://pestphp.com/docs/
 */

use Fcno\CorporateImporter\Models\Lotacao;

test('retorna as lotações usando o escopo ascendente por nome', function () {
    $first = 'Lotação A';
    $second = 'Lotação B';
    $third = 'Lotação C';

    Lotacao::factory()
            ->create(['nome' => $third]);

    Lotacao::factory()
            ->create(['nome' => $first]);

    Lotacao::factory()
            ->create(['nome' => $second]);

    $lotacoes = Lotacao::sort()
                        ->get();

    expect($lotacoes->get(0)->nome)->toBe($first)
    ->and($lotacoes->get(1)->nome)->toBe($second)
    ->and($lotacoes->get(2)->nome)->toBe($third);
});
