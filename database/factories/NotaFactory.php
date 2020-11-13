<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Nota;
use App\Models\TipoConta;
use App\Models\User;

class NotaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Nota::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $tipos = Nota::lista_tipos();	
        return [
            'texto'        => $this->faker->name,
            'tipo'         => $tipos[array_rand($tipos)],
            'tipoconta_id' => TipoConta::factory()->create()->id,
            'user_id'      => User::factory()->create()->id,
        ];
    }
}
