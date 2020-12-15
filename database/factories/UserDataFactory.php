<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\UserData;
use Faker\Generator as Faker;

$factory->define(UserData::class, function (Faker $faker) {
    return [
        'show_email' => $faker->boolean($chanceOfGettingTrue = 25),
        'date_of_birth' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'country' => $faker->country,
        'gender' => $faker->randomElement(['Male', 'Female']),
    ];
});
