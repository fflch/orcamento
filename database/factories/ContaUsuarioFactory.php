<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ContaUsuario;
use App\Models\Conta;
use App\Models\User;

class ContaUsuarioFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ContaUsuario::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id_conta'   => Conta::factory()->create()->id,
            'id_usuario' => User::factory()->create()->id,
            'user_id'    => User::factory()->create()->id,
        ];
    }
}
