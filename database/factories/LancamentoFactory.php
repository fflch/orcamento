<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Lancamento;
use App\Models\Movimento;
use App\Models\Conta;
use App\Models\FicOrcamentaria;
use App\Models\Nota;
use App\Models\User;

class LancamentoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *use Illuminate\Database\Eloquent\Factories\Factory;

     * @var string
     */
    protected $model = Lancamento::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        //$valores = [0.00, 999.99];
        return [
                'grupo'              => '0' . $this->faker->numberBetween($min = 80, $max = 89),
                'receita'            => $this->faker->boolean,
                'data'               => date('d/m/Y', strtotime('+' . rand(0,7) . 'day')),
                'empenho'            => $this->faker->numberBetween($min = 1111111, $max = 9999999),
                'descricao'          => Nota::inRandomOrder()->first()->texto,
                'debito'             => $this->faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 1000),
                'credito'            => $this->faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 1000),
                'saldo'              => '0.00',
                'observacao'         => Nota::inRandomOrder()->first()->texto,
                'movimento_id'       => Movimento::inRandomOrder()->first()->id,
                'ficorcamentaria_id' => FicOrcamentaria::inRandomOrder()->first()->id,
                'user_id'            => User::inRandomOrder()->first()->id,
            ];
    }
}
