<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\FicOrcamentaria;
use App\Models\Movimento;
use App\Models\DotOrcamentaria;
use App\Models\User;

class FicOrcamentariaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FicOrcamentaria::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $valores = [0.00, 999.99];
        return [
            'data'         => $this->faker->date,
            'empenho'      => $this->faker->numberBetween($min = 1111111, $max = 9999999),
            'descricao'    => $this->faker->sentence,
            'debito'       => $this->faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 1000), 
            'credito'      => $this->faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 1000), 
            'saldo'        => '0.00',
            'observacao'   => $this->faker->sentence,
            'movimento_id' => Movimento::inRandomOrder()->first()->id,
            'dotacao_id'   => DotOrcamentaria::inRandomOrder()->first()->id,
            'user_id'      => User::inRandomOrder()->first()->id,
        ];
    }
}
