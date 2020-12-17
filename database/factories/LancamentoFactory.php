<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Lancamento;
use App\Models\Movimento;
use App\Models\Conta;
use App\Models\FicOrcamentaria;
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
        $valores = [0.00, 999.99];
        return [
                'grupo'              => '0' . $this->faker->numberBetween($min = 80, $max = 89),
                'receita'            => $this->faker->boolean,
                'data'               => $this->faker->date,
                'empenho'            => $this->faker->numberBetween($min = 1111111, $max = 9999999),
                'descricao'          => $this->faker->sentence,
                'debito'             => $valores[array_rand($valores)],
                'credito'            => $valores[array_rand($valores)],
                'saldo'              => '0.00',
                'observacao'         => $this->faker->sentence,
                'movimento_id'       => Movimento::factory()->create()->id,
                'conta_id'           => Conta::factory()->create()->id,
                'ficorcamentaria_id' => FicOrcamentaria::factory()->create()->id,
                'user_id'            => User::factory()->create()->id,
        ];
    }
}
