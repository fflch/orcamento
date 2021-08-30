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
            'id_usuario' => User::factory()->create()->id,
            'id_conta'   => Conta::factory()->create()->id,
            'user_id'    => User::factory()->create()->id,
        ];
        $contausuario2 = [
            'id_usuario' => User::factory()->create()->id,
            'id_conta'   => Conta::factory()->create()->id,
            'user_id'    => User::factory()->create()->id,
        ];

        ContaUsuario::create($contausuario1);
        ContaUsuario::create($contausuario2);

        ContaUsuario::factory(3)->create();
    }
}
