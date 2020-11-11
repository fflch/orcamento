<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipoConta;
use App\Models\User;

class TipoContaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tipoconta1 = [
            'descricao'          => 'Orçamento',
            'cpfo'               => '1', 
            'relatoriobalancete' => '0',
            'user_id'            => User::factory()->create()->id,
        ];

        $tipoconta2 = [
            'descricao'          => 'Renda Industrial',
            'cpfo'               => '0', 
            'relatoriobalancete' => '1',
            'user_id'            => User::factory()->create()->id,
        ];

        TipoConta::create($tipoconta1);
        TipoConta::create($tipoconta2);

        TipoConta::factory(5)->create();
    }
}