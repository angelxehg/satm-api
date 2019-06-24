<?php

use Faker\Generator as Faker;
use App\Task;

$factory->define(Task::class, function (Faker $faker) {
    return [
        'title' => $faker->company,
        'description' => $faker->catchPhrase,
        'priority' => $faker->numberBetween($min = 0, $max = 3),
        'dueDate' => $faker->date(),
        'isComplete' => $faker->boolean(),
        'component_id' => $faker->numberBetween($min = 0, $max = 1000),
        'user_id' => $faker->numberBetween($min = 0, $max = 50)
    ];
});
