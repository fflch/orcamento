<?php

namespace Database\Factories;

use App\Models\Lancamento;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Movimento;
use App\Models\Conta;
use App\Models\User;


class LancamentoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
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
        $boleanos = ['1','0'];
        $valores = [1.00, 999.99];

        return [
                'id'           => $this->faker->numberBetween($min = 1010, $max = 9000),
                'grupo'        => '0' . $this->faker->numberBetween($min = 80, $max = 89),
                'receita'      => $boleanos[array_rand($boleanos)],
                'data'         => $this->faker->date,
                'empenho'      => $this->faker->numberBetween($min = 1111111, $max = 9999999),
                'descricao'    => $this->faker->sentence,
                //'debito'       => $valores[array_rand($valores)],
                //'credito'      => $valores[array_rand($valores)],
                'debito'       => $this->faker->numberBetween($min = 1.00, $max = 999.99),
                'credito'      => $this->faker->numberBetween($min = 1.00, $max = 999.99),
                'observacao'   => $this->faker->sentence,
                'movimento_id' => Movimento::factory()->create()->id,
                'conta_id'     => Conta::factory()->create()->id,
                'user_id'      => User::factory()->create()->id,
        ];
    }
}
