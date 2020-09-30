<?php

namespace Database\Factories;

use App\Models\Movimento;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Model;
use Faker\Generator as Faker;

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
        $boleanos = ['1','0'];	
        return [
            'id'        => $this->faker->numberBetween($min = 1010, $max = 9000),
            'ano'       => $this->faker->numberBetween($min = 2030, $max = 2999),
            'concluido' => $boleanos[array_rand($boleanos)], 
            'ativo'     => $boleanos[array_rand($boleanos)],
        ];
    }
}