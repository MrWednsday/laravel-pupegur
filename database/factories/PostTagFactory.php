<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\PostTag;
use App\Post;
use App\Tag;
use Faker\Generator as Faker;

$factory->define(PostTag::class, function (Faker $faker) {

    $noOfPost = count(Post::get());
    $noOfTag = count(Tag::get());

    return [
        'post_id' => $faker->numberBetween(1, $noOfPost),
        'tag_id' => $faker->numberBetween(2, $noOfTag),
    ];
});
