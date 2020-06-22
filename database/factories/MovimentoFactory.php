<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use App\Movimento;

$factory->define(Movimento::class, function (Faker $faker) {
    $boleanos = ['1','0'];	
    return [
        'id'        => $faker->numberBetween($min = 1010, $max = 9000),
        'ano'       => $faker->numberBetween($min = 2030, $max = 2999),
        'concluido' => $boleanos[array_rand($boleanos)], 
        'ativo'     => $boleanos[array_rand($boleanos)],
    ];
});
