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

        for($x = 0; $x < 4; $x++) {
            Movimento::create(
                [
                    'ano'       => date("Y") - $x,
                    'concluido' => (date("Y") - $x) < date("Y") ? FALSE : TRUE,
                    'ativo'     => (date("Y") - $x) < date("Y") ? FALSE : TRUE,
                    'user_id'   => User::inRandomOrder()->first()->id,
                ]);
        }

    }
}
