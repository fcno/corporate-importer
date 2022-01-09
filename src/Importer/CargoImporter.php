<?php

namespace Fcno\CorporateImporter\Importer;

use Fcno\CorporateImporter\Models\Cargo;
use Illuminate\Support\Collection;

final class CargoImporter extends BaseImporter
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
    protected $node = 'cargo';

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
            'id' => $node->getAttribute('id') ?: null,
            'nome' => $node->getAttribute('nome') ?: null,
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function save(Collection $validated): void
    {
        Cargo::upsert(
            $validated->toArray(),
            $this->unique,
            $this->fields_to_update
        );
    }
}
