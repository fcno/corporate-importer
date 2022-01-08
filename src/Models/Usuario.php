<?php

namespace Fcno\CorporateImporter\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @see https://laravel.com/docs/8.x/eloquent
 */
class Usuario extends Model
{
    use HasFactory;

    protected $table = 'usuarios';

    protected $fillable = ['sigla', 'nome', 'lotacao_id', 'cargo_id', 'funcao_id'];

    /**
     * Lotação de um determinado usuário.
     */
    public function lotacao(): BelongsTo
    {
        return $this->belongsTo(Lotacao::class, 'lotacao_id', 'id');
    }

    /**
     * Cargo de um determinado usuário.
     */
    public function cargo(): BelongsTo
    {
        return $this->belongsTo(Cargo::class, 'cargo_id', 'id');
    }

    /**
     * Função de um determinado usuário.
     */
    public function funcao(): BelongsTo
    {
        return $this->belongsTo(Funcao::class, 'funcao_id', 'id');
    }

    /**
     * Define o escopo padrão de ordenação do modelo.
     */
    public function scopeSort(Builder $query): Builder
    {
        return $query->orderBy('nome', 'asc');
    }
}
