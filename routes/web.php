<?php

use Illuminate\Support\Facades\Route;
use App\User;
use App\Post;
use App\DailyDogPicture;

app()->singleton('DailyDogPicture', function ($app){
    return new DailyDogPicture('https://api.thedogapi.com/v1/images/search', '21cb0715-fbab-4a0f-b799-84a787e02603');
});

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('p')->group(function () {
    Route::get('create','PostController@create')
        ->name('post.create');


    Route::get('{id}', 'PostController@show')
        ->name('post.show')
        ->where('id', '[0-9]+');
});


Route::get('', 'PostController@index')
    ->name('post.index');


Route::get('u/{id}', 'UserController@show')
    ->name('user.show')
    ->where('u', '[0-9]+');

Route::post('comments', 'CommentController@store')
    ->name('comment.post');

Route::get('dailyDog', function () {
    $dailyDogPicture = app()->make('DailyDogPicture');
    return $dailyDogPicture->getDailyDogPicture();
});

Auth::routes();

