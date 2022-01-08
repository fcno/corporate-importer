<?php

namespace Fcno\CorporateImporter\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @see https://laravel.com/docs/8.x/eloquent
 */
class Funcao extends Model
{
    use HasFactory;

    protected $table = 'funcoes';

    protected $fillable = ['id', 'nome'];

    public $incrementing = false;

    /**
     * Usuários de uma determinada função.
     */
    public function usuarios(): HasMany
    {
        return $this->hasMany(Usuario::class, 'funcao_id', 'id');
    }

    /**
     * Define o escopo padrão de ordenação do modelo.
     */
    public function scopeSort(Builder $query): Builder
    {
        return $query->orderBy('nome', 'asc');
    }
}
