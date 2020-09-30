<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Movimento;

class MovimentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $movimento1 = [
            'id'        => 1001,
            'ano'       => '2020',
            'concluido' => '1', 
            'ativo'     => '1',
        ];

        $movimento2 = [
            'id'        => 1002,
            'ano'       => '2021',
            'concluido' => '1', 
            'ativo'     => '1',
        ];

        Movimento::create($movimento1);
        Movimento::create($movimento2);

        Movimento::factory(10)->create();
    }
}
