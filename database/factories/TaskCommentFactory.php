<?php

use App\Models\TaskComment;
use Faker\Generator as Faker;
use Illuminate\Support\Carbon;

$factory->define(TaskComment::class, function (Faker $faker) {

    return [
        'comment' => $faker->text(100),
        'date' => Carbon::now(),
    ];
});
