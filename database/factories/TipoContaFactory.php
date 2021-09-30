<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\TipoConta;
use App\Models\User;

class TipoContaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TipoConta::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        //$boleanos = [TRUE,FALSE];	
        return [
            'descricao'          => $this->faker->name,
            'cpfo'               => $this->faker->boolean,
            'relatoriobalancete' => $this->faker->boolean,
            'user_id'            => User::inRandomOrder()->first()->id,
        ];
    }
}
