<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Area;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $area1 = [
            'nome' => 'Orçamento',
        ];

        $area2 = [
            'nome' => 'Renda Industrial',
        ];

        Area::create($area1);
        Area::create($area2);

        Area::factory(10)->create();
    }
}
