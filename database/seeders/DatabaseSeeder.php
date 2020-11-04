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
            NotaSeeder::class,
            AreaSeeder::class,
            TipoContaSeeder::class,
            DotOrcamentariaSeeder::class,
            ContaSeeder::class,
            LancamentoSeeder::class,
	    ]);
    }
}
