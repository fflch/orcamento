<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Movimento;
use App\Models\User;

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
            'ano'       => '2020',
            'concluido' => '1', 
            'ativo'     => '1',
            'user_id'   => User::factory()->create()->id,
        ];

        $movimento2 = [
            'ano'       => '2021',
            'concluido' => '1', 
            'ativo'     => '1',
            'user_id'   => User::factory()->create()->id,
        ];

        Movimento::create($movimento1);
        Movimento::create($movimento2);

        Movimento::factory(5)->create();
    }
}
