<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\DotOrcamentaria;
use App\Models\User;

class DotOrcamentariaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DotOrcamentaria::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'dotacao'        => $this->faker->numberBetween($min = 1000, $max = 9000),
            'grupo'          => $this->faker->numberBetween($min = 1000, $max = 9000),
            'descricaogrupo' => $this->faker->sentence,
            'item'           => $this->faker->numberBetween($min = 1000, $max = 9000),
            'descricaoitem'  => $this->faker->sentence,
            'receita'        => $this->faker->boolean,
            'ativo'          => $this->faker->boolean,
            'user_id'        => User::inRandomOrder()->first()->id,
        ];
    }
}
