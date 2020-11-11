<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Nota;
use App\Models\TipoConta;
use App\Models\User;

class NotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $nota1 = [
            'texto'        => 'Suplementação de Cursos',
            'tipo'         => 'Descrição',
            'tipoconta_id' => TipoConta::factory()->create()->id,
            'user_id'      => User::factory()->create()->id,
        ];
        $nota2 = [
            'texto'        => 'Referente JAN/',
            'tipo'         => 'Observação',
            'tipoconta_id' => TipoConta::factory()->create()->id,
            'user_id'      => User::factory()->create()->id,
        ];

        Nota::create($nota1);
        Nota::create($nota2);

        Nota::factory(5)->create();
    }
}
