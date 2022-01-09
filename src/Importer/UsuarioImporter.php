<?php

namespace Fcno\CorporateImporter\Importer;

use Fcno\CorporateImporter\Models\Usuario;
use Illuminate\Support\Collection;

final class UsuarioImporter extends BaseImporter
{
    /**
     * {@inheritdoc}
     */
    protected $rules = [
        'sigla' => ['required', 'string', 'max:20'],
        'nome' => ['required', 'string', 'max:255'],
        'lotacao_id' => ['required', 'integer', 'exists:lotacoes,id'],
        'cargo_id' => ['required', 'integer', 'exists:cargos,id'],
        'funcao_id' => ['nullable', 'integer', 'exists:funcoes,id'],
    ];

    /**
     * {@inheritdoc}
     */
    protected $node = 'pessoa';

    /**
     * {@inheritdoc}
     */
    protected $unique = ['sigla'];

    /**
     * {@inheritdoc}
     */
    protected $fields_to_update = ['nome', 'lotacao_id', 'cargo_id', 'funcao_id'];

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
            'sigla' => $node->getAttribute('sigla'),
            'nome' => $node->getAttribute('nome') ?: null,
            'lotacao_id' => $node->getAttribute('lotacao'),
            'cargo_id' => $node->getAttribute('cargo'),
            'funcao_id' => $node->getAttribute('funcaoConfianca') ?: null,
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function save(Collection $validated): void
    {
        Usuario::upsert(
            $validated->toArray(),
            $this->unique,
            $this->fields_to_update
        );
    }
}
