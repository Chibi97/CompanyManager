<?php

use App\Models\Task;
use Faker\Generator as Faker;
use Illuminate\Support\Carbon;

$factory->define(Task::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence,
        'description' => $faker->text(100),
        'start_date' => $faker->dateTimeThisDecade('now',null),
        'end_date' => $faker->dateTimeThisYear('now',null),
        'count' => $faker->numberBetween(1,5)
    ];
});
