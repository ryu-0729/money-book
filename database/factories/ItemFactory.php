<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Item;
use Faker\Generator as Faker;

$factory->define(Item::class, function (Faker $faker) {
    return [
        'user_id' => factory(App\Models\User::class),
        'name' => $faker->name,
        'price' => $faker->numberBetween($min = 100, $max = 300),
    ];
});
