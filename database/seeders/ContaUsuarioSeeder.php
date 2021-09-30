<?php

namespace Database\Seeders;
use App\Models\ContaUsuario;
use App\Models\Conta;
use App\Models\User;

use Illuminate\Database\Seeder;

class ContaUsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $contausuario1 = [
            'id_usuario' => User::inRandomOrder()->first()->id,
            'id_conta'   => Conta::inRandomOrder()->first()->id,
            'user_id'    => User::inRandomOrder()->first()->id,
        ];
        $contausuario2 = [
            'id_usuario' => User::inRandomOrder()->first()->id,
            'id_conta'   => Conta::inRandomOrder()->first()->id,
            'user_id'    => User::inRandomOrder()->first()->id,
        ];

        ContaUsuario::create($contausuario1);
        ContaUsuario::create($contausuario2);

        ContaUsuario::factory(10)->create();
    }
}
