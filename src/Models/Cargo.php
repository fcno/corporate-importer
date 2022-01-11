<?php

namespace Fcno\CorporateImporter\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @see https://laravel.com/docs/8.x/eloquent
 */
class Cargo extends Model
{
    use HasFactory;

    protected $table = 'cargos';

    protected $fillable = ['id', 'nome'];

    public $incrementing = false;

    /**
     * Usuários de um determinado cargo.
     */
    public function usuarios(): HasMany
    {
        return $this->hasMany(Usuario::class, 'cargo_id', 'id');
    }

    /**
     * Define o escopo padrão de ordenação do modelo.
     */
    public function scopeSort(Builder $query): Builder
    {
        return $query->orderBy('nome', 'asc');
    }
}
