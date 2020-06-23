<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use App\DotOrcamentaria;

$factory->define(DotOrcamentaria::class, function (Faker $faker) {
    $boleanos = ['1','0'];	
    return [
        'dotacao' => $faker->numberBetween($min = 1000, $max = 9000),
        'grupo'=> $faker->numberBetween($min = 1000, $max = 9000),
        'descricaogrupo'=> $faker->sentence,
        'item'=> $faker->numberBetween($min = 1000, $max = 9000),
        'descricaoitem'=> $faker->sentence,
        'receita' => $boleanos[array_rand($boleanos)],
    ];
});
