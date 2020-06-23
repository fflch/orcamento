<?php

use Illuminate\Database\Seeder;
use App\TipoConta;

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

        factory(TipoConta::class, 10)->create();
    }
}