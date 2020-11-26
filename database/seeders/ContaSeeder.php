<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Conta;
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
            'email'        => 'aaa@usp.br',
            'numero'       => 1,
            'ativo'        => TRUE,
            'tipoconta_id' => TipoConta::factory()->create()->id,
            'area_id'      => Area::factory()->create()->id,
            'user_id'      => User::factory()->create()->id,
        ];

        $conta2 = [
            'id'           => 1002,
            'nome'         => 'Renda Industrial',
            'email'        => 'bbb@usp.br',
            'numero'       => 2,
            'ativo'        => FALSE,
            'tipoconta_id' => TipoConta::factory()->create()->id,
            'area_id'      => Area::factory()->create()->id,
            'user_id'      => User::factory()->create()->id,
        ];

        Conta::create($conta1);
        Conta::create($conta2);

        Conta::factory(5)->create();
    }
}
