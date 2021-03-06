<?php

use App\Entity\Currency;
use Faker\Generator as Faker;

$factory->define(Currency::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->word,
        'rate' => $faker->randomFloat(2, 0,999999),
    ];
});
