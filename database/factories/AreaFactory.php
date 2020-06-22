<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use App\Area;

$factory->define(Area::class, function (Faker $faker) {
    return [
        'nome' => $faker->name,
    ];
});
