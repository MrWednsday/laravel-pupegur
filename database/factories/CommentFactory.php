<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use App\User;
use App\Comment;

use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    $noOfUsers = count(User::get());
    $noOfPosts = count(Post::get());

    return [
        'user_id' => $faker->numberBetween(1, $noOfUsers),
        'post_id' => $faker->numberBetween(1, $noOfPosts),
        'text' => $faker->realText($this->faker->numberBetween(40, 200)),     
        'created_at' => now(),
        'updated_at' => null,
    ];
});
