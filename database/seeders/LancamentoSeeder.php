<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Lancamento;
use App\Models\FicOrcamentaria;
use App\Models\Conta;
use App\Models\Movimento;
use App\Models\User;

class LancamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lancamento1 = [
            'grupo'              => '080',
            'receita'            => TRUE,
            'data'               => '2020-01-01',
            'empenho'            => 1234567,
            'descricao'          => 'Suplementação de cursos',
            'debito'             => '100.01',
            'credito'            => '0.00',
            'saldo'              => '0.00',
            'observacao'         => 'Ref. Mar/2020',
            'movimento_id'       => Movimento::factory()->create()->id,
            'conta_id'           => Conta::factory()->create()->id,
            'ficorcamentaria_id' => FicOrcamentaria::factory()->create()->id,
            'user_id'            => User::factory()->create()->id,
        ];

        $lancamento2 = [
            'grupo'              => '857',
            'receita'            => FALSE,
            'data'               => '2020-12-01',
            'empenho'            => 7654321,
            'descricao'          => 'Despesas com Almoxarifado',
            'debito'             => '0.00',
            'credito'            => '100.01',
            'saldo'              => '0.00',
            'observacao'         => 'Ref. Abr/2020',
            'movimento_id'       => Movimento::factory()->create()->id,
            'conta_id'           => Conta::factory()->create()->id,
            'ficorcamentaria_id' => FicOrcamentaria::factory()->create()->id,
            'user_id'            => User::factory()->create()->id,
        ];

        Lancamento::create($lancamento1);
        Lancamento::create($lancamento2);

        Lancamento::factory(3)->create();
    }
}
