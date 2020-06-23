<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use App\TipoConta;

$factory->define(TipoConta::class, function (Faker $faker) {
    $boleanos = ['1','0'];	
    return [
        'descricao'          => $faker->name,
        'cpfo'               => $boleanos[array_rand($boleanos)], 
        'relatoriobalancete' => $boleanos[array_rand($boleanos)],
    ];
});
