<?php

use Faker\Generator as Faker;
use App\Material;

$factory->define(Material::class, function (Faker $faker) {
    return [
        'brand' => $faker->company,
        'model' => $faker->postcode,
        'description' => $faker->catchPhrase,
        'quantity' => $faker->numberBetween($min = 1, $max = 20)
    ];
});
