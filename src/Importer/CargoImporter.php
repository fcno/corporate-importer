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
     *
     * @see https://drib.tech/programming/parse-large-xml-files-php
     */
    protected function process(): void
    {
        $validated = collect();
        $xml = new \XMLReader();
        $xml->open($this->file_path);

        // finding first primary element to work with
        while ($xml->read() && $xml->name != $this->node) {
        }

        // looping through elements
        while ($xml->name == $this->node) {
            $valid = $this->validateAndLogError([
                'id' => $xml->getAttribute('id'),
                'nome' => $xml->getAttribute('nome'),
            ]);

            if ($valid) {
                $validated->push($valid);
            }

            // salva a quantidade determinada de registros por vez
            if ($validated->count() >= $this->max_upsert) {
                $this->save($validated);
                $validated = collect();
            }

            // moving pointer
            $xml->next($this->node);
        }

        $xml->close();

        // salva o saldo dos registros
        if ($validated->isNotEmpty()) {
            $this->save($validated);
        }
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
