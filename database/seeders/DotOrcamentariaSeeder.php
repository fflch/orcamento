<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DotOrcamentaria;
use App\Models\User;

class DotOrcamentariaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dotorcamentaria1 = [
            'dotacao'        => 12345,
            'grupo'          => '080',
            'descricaogrupo' => 'Teste 123 456 ...',
            'item'           => '0333012',
            'descricaoitem'  => 'Teste 123 456 ...',
            'receita'        => '1',
            'user_id'        => User::factory()->create()->id,
        ];

        $dotorcamentaria2 = [
            'dotacao'        => 54321,
            'grupo'          => '081',
            'descricaogrupo' => 'Teste 654 321 ...',
            'item'           => '0333012',
            'descricaoitem'  => 'Teste 654 321 ...',
            'receita'        => '0',
            'user_id'        => User::factory()->create()->id,
        ];

        DotOrcamentaria::create($dotorcamentaria1);
        DotOrcamentaria::create($dotorcamentaria2);

        DotOrcamentaria::factory(5)->create();
    }
}
