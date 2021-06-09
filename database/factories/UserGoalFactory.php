<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\UserGoal;
use Faker\Generator as Faker;

$factory->define(UserGoal::class, function (Faker $faker) {
    return [
        'user_id' => factory(App\Models\User::class),
        'title' => $faker->title,
        'price' => $faker->numberBetween($min = 10000, $max = 100000),
    ];
});
