<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user1 = [
            'id'     => 1001,
            'codpes' => '1111111',
            'name'   => 'Ciclano da Silva',
            'email'  => 'abc@usp.br',
            'perfil' => 'Administrador',
        ];

        $user2 = [
            'id'     => 1002,
            'codpes' => '2222222',
            'name'   => 'José da Silva',
            'email'  => 'def@usp.br',
            'perfil' => 'Usuário',
        ];
        User::create($user1);
        User::create($user2);

        User::factory(3)->create();
    }
}
