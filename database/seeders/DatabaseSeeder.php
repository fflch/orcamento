<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
	    $this->call([
            UserSeeder::class,
            MovimentoSeeder::class,
            AreaSeeder::class,
            TipoContaSeeder::class,
            DotOrcamentariaSeeder::class,
            ContaSeeder::class,
            NotaSeeder::class,
            FicOrcamentariaSeeder::class,
            LancamentoSeeder::class,
            ContaUsuarioSeeder::class,
            UnidadeSeeder::class,
	    ]);
    }
}
