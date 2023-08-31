<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Movimento;
use App\Models\User;

class MovimentoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Movimento::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $ano = Movimento::select('ano')->latest()->get();

        return [
            'ano'       => $ano()->first() - 1, //$this->faker->numberBetween($min = 2030, $max = 2099),
            'ativo'     => $this->faker->boolean,
            'user_id'   => User::inRandomOrder()->first()->id,
        ];
    }
}
