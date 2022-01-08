<?php

namespace Fcno\CorporateImporter\Database\Factories;

use Fcno\CorporateImporter\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @see https://laravel.com/docs/8.x/database-testing
 * @see https://fakerphp.github.io/
 */
class UsuarioFactory extends Factory
{
    protected $model = Usuario::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'lotacao_id' => null,
            'cargo_id' => null,
            'funcao_id' => null,

            'nome' => random_int(0, 1)
                        ? $this->faker->name()
                        : null,

            'sigla' => $this->faker->unique()->word(),
        ];
    }
}
