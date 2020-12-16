<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use App\User;
use App\Image;

use Illuminate\Support\Facades\Storage;

use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    {
        $noOfUsers = count(User::get());

        return [
            'user_id' => $faker->numberBetween($min = 2, $max = $noOfUsers),
            'title' => $faker->realText($maxNbChars = 128), 
            'created_at' => now(),
            'updated_at' => null,
        ];
    }
});
