<?php

use Faker\Generator as Faker;
use App\Machine;

$factory->define(Machine::class, function (Faker $faker) {
    return [
        'brand' => $faker->company,
        'model' => $faker->postcode,
        'description' => $faker->catchPhrase,
        'ubication' => $faker->streetName
    ];
});
