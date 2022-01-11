<?php

namespace Fcno\CorporateImporter\Importer;

use Fcno\CorporateImporter\Models\Lotacao;
use Illuminate\Support\Collection;

/**
 * Faz o cadastramento do auto relacionamento da lotação.
 *
 * Deve-se primeiro cadastrar a lotação para depois acionar essa classe para a
 * criar o autorelacionamento.
 * O relacionamento é criado após o cadastro principal da lotação para evitar
 * falhas ao tentar criar de maneira concomitante.
 * Exemplos de falhas que são evitadas ao se fazer o relacionamento após, e não
 * junto, do cadastro da lotação:
 * - lotação pai inexistente, pois o id informado para o pai não existe e não
 * existirá nunca (talvez uma lotação que foi desativada, mas ainda está sendo
 * gerada no arquivo corporativo);
 * - lotação pai inexistente, pois na sequência da leitura do arquivo XML, a
 * lotação pai encontra-se após a lotação que está sendo cadastrada;
 * - lotação pai inexistente, devido a falha em algum atributo que a impediu de
 * ser persistida.
 */
final class LotacaoRelationshipImporter extends BaseImporter
{
    /**
     * {@inheritdoc}
     */
    protected $rules = [
        'id' => ['required', 'integer', 'gte:1'],
        'nome' => ['required', 'string',  'max:255'],
        'sigla' => ['required', 'string',  'max:50'],
        'lotacao_pai' => ['nullable', 'integer', 'exists:lotacoes,id'],
    ];

    /**
     * {@inheritdoc}
     */
    protected $node = 'lotacao';

    /**
     * {@inheritdoc}
     */
    protected $unique = ['id'];

    /**
     * {@inheritdoc}
     */
    protected $fields_to_update = ['lotacao_pai'];

    /**
     * Create new class instance.
     */
    public static function make(): static
    {
        return new static();
    }

    /**
     * {@inheritdoc}
     */
    protected function extractFieldsFromNode(\XMLReader $node): array
    {
        return [
            'id' => $node->getAttribute('id') ?: null,
            'nome' => $node->getAttribute('nome') ?: null,
            'sigla' => $node->getAttribute('sigla') ?: null,
            'lotacao_pai' => $node->getAttribute('idPai') ?: null,
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function save(Collection $validated): void
    {
        Lotacao::upsert(
            $validated->toArray(),
            $this->unique,
            $this->fields_to_update
        );
    }
}
