<?php

use Faker\Generator as Faker;
use App\Component;

$factory->define(Component::class, function (Faker $faker) {
    return [
        'brand' => $faker->company,
        'model' => $faker->postcode,
        'description' => $faker->catchPhrase,
        'machine_id' => $faker->numberBetween($min = 1, $max = 100)
    ];
});
