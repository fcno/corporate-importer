<?php

namespace Fcno\CorporateImporter\Importer;

use Fcno\CorporateImporter\Models\Funcao;
use Illuminate\Support\Collection;

final class FuncaoImporter extends BaseImporter
{
    /**
     * {@inheritdoc}
     */
    protected $rules = [
        'id' => ['required', 'integer', 'gte:1'],
        'nome' => ['required', 'string',  'max:255'],
    ];

    /**
     * {@inheritdoc}
     */
    protected $node = 'funcao';

    /**
     * {@inheritdoc}
     */
    protected $unique = ['id'];

    /**
     * {@inheritdoc}
     */
    protected $fields_to_update = ['nome'];

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
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function save(Collection $validated): void
    {
        Funcao::upsert(
            $validated->toArray(),
            $this->unique,
            $this->fields_to_update
        );
    }
}
