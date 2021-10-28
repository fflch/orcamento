<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FicOrcamentaria;
use App\Models\Movimento;
use App\Models\User;
use App\Models\DotOrcamentaria;

class FicOrcamentariaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ficorcamentaria1 = [
            'data'         => '2020-01-01',
            //'data'         => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'empenho'      => 1234567,
            'descricao'    => 'Adiantamento 323435 - ',
            'debito'       => '100.01',
            'credito'      => '0.00',
            'saldo'        => '0.00',
            'observacao'   => 'Processo no. ',
            'movimento_id' => Movimento::inRandomOrder()->first()->id,
            'dotacao_id'   => DotOrcamentaria::inRandomOrder()->first()->id,
            'user_id'      => User::inRandomOrder()->first()->id,
        ];

        $ficorcamentaria2 = [
            'data'         => '2020-11-01',
            'empenho'      => 7654321,
            'descricao'    => 'Adiantamento 123456 - ',
            'debito'       => '0.00',
            'credito'      => '100.01',
            'saldo'        => '0.00',
            'observacao'   => 'Processo no. ',
            'movimento_id' => Movimento::inRandomOrder()->first()->id,
            'dotacao_id'   => DotOrcamentaria::inRandomOrder()->first()->id,
            'user_id'      => User::inRandomOrder()->first()->id,
        ];

        FicOrcamentaria::create($ficorcamentaria1);
        FicOrcamentaria::create($ficorcamentaria2);

        FicOrcamentaria::factory(10)->create();
    }
}
