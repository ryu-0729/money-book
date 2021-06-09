<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\BuyItem;
use Faker\Generator as Faker;

$factory->define(BuyItem::class, function (Faker $faker) {
    return [
        'user_id' => factory(App\Models\User::class),
        'name' => $faker->name,
        'quantity' => $faker->numberBetween($min = 1, $max = 1000),
        'price' => $faker->numberBetween($min = 100, $max = 1000),
        'month' => $faker->numberBetween($min = 1, $max = 12),
    ];
});
