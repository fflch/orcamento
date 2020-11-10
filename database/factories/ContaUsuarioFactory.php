<?php

namespace Database\Factories;
use App\Models\Conta;
use App\Models\User;

use App\Models\ContaUsuario;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            'id'         => $this->faker->numberBetween($min = 1010, $max = 9000),
            'id_conta'   => Conta::factory()->create()->id,
            'id_usuario' => User::factory()->create()->id,
            'user_id'    => User::factory()->create()->id,
        ];
    }
}
