<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Tweet::class, function (Faker $faker) {
    return [
        'tweet_text' => $faker->paragraph,
        'user_id'   => $faker->numberBetween($min = 1, $max = 10),
        'user_screen_name'=> $faker->name,
    ];
});
