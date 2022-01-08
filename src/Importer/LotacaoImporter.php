<?php

namespace Fcno\CorporateImporter\Importer;

use Fcno\CorporateImporter\Models\Lotacao;
use Illuminate\Support\Collection;

final class LotacaoImporter extends BaseImporter
{
    /**
     * {@inheritdoc}
     */
    protected $rules = [
        'id' => ['required', 'integer', 'gte:1'],
        'nome' => ['required', 'string',  'max:255'],
        'sigla' => ['required', 'string',  'max:50'],
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
    protected $fields_to_update = ['nome', 'sigla'];

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
            'id' => $node->getAttribute('id'),
            'nome' => $node->getAttribute('nome'),
            'sigla' => $node->getAttribute('sigla'),
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
