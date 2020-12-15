<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Image;
use App\Post;
use Faker\Generator as Faker;

$factory->define(Image::class, function (Faker $faker) {

    $files = Storage::files('public/images/');
    $filePath = $files[rand(0 , count($files) - 1)];

    $filePathParts = explode("/", $filePath);
    $fileName = end($filePathParts);

    $noOfUsers = Post::get()->count();

    return [
        'path' => $fileName,
    ];
});

$factory->state(Image::class, 'profile_image', function (\Faker\Generator $faker) {
    return [
        'path' => 'profile/default_profile.png',
    ];
});
  