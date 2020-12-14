<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Unidade;
use App\Models\User;

class UnidadeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $unidade = [
            'id'           => 1001,
            'numero'       => '08',
            'nome'         => 'Faculdade de Filosofia, Letras e Ciências Humanas',
            'departamento' => 'Serviço de Contabilidade',
            'user_id'      => User::factory()->create()->id,
        ];
        Unidade::create($unidade);
    }
}
