<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\UserRole;
use Faker\Generator as Faker;

$factory->define(UserRole::class, function (Faker $faker) {
    return [
        'user' => true,
        'admin' => false
    ];
});

$factory->state(UserRole::class, 'admin', function (Faker $faker) {
    return [
        'admin' => true
    ];
});

$factory->state(UserRole::class, 'bot', function (Faker $faker) {
    return [
        'user' => false,
        'admin' => false
    ];
});
  
