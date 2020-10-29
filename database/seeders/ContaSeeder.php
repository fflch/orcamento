<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Conta;

use App\Models\Movimento;
use App\Models\TipoConta;
use App\Models\Area;
use App\Models\User;


class ContaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $conta1 = [
            'id'           => 1001,
            'nome'         => 'Orçamento',
            'email'        => 'teste1@usp.br',
            'numero'       => 1,
            'ativo'        => 1,
            'movimento_id' => Movimento::create()->id,
            'tipoconta_id' => TipoConta::create()->id,
            'area_id'      => Area::create()->id,
            'user_id'      => User::create()->id,
        ];

        /*$conta2 = [
            'id'           => 1001,
            'nome'         => 'Renda Industrial',
            'email'        => 'teste2@usp.br',
            'numero'       => 2,
            'ativo'        => 0,
            'movimento_id' => Movimento::factory()->create()->id,
            'tipoconta_id' => TipoConta::factory()->create()->id,
            'area_id'      => Area::factory()->create()->id,
            'user_id'      => User::factory()->create()->id,
        ];*/

        Conta::create($conta1);
        //Conta::create($conta2);

        conta::factory(10)->create();
    }
}
