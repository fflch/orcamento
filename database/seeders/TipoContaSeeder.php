<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipoConta;

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
            'relatoriobalancete' => '1',
        ];

        $tipoconta2 = [
            'descricao'          => 'Renda Industrial',
            'cpfo'               => '1', 
            'relatoriobalancete' => '1',
        ];

        TipoConta::create($tipoconta1);
        TipoConta::create($tipoconta2);

        TipoConta::factory(10)->create();
    }
}