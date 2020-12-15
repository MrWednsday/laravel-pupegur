<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('comments')->group(function () {
    Route::put('', 'CommentController@store')
        ->middleware('auth:api')
        ->name('api.comment.store');

    Route::post('', 'CommentController@edit')
        ->middleware('auth:api')
        ->name('api.comment.edit');

    Route::delete('{comment_id}', 'CommentController@delete')
        ->middleware('auth:api')
        ->name('api.comment.delete');

    Route::get('{post_id}', 'CommentController@apiIndex')
        ->name('api.comment.get');
});

Route::prefix('post')->group(function () {
    Route::put('', 'PostController@apiStore')
        ->middleware('auth:api')
        ->name('api.post.store');

    Route::delete('{comment_id}', 'PostController@apiDelete')
        ->middleware('auth:api')
        ->name('api.post.delete');

    Route::post('', 'PostController@apiUpdate')
        ->middleware('auth:api')
        ->name('api.post.update');
});

Route::prefix('userData')->group(function () {
    Route::post('', 'UserDataController@apiUpdate')
        ->middleware('auth:api')
        ->name('api.userData.update');

    Route::delete('{comment_id}', 'PostController@apiDelete')
        ->middleware('auth:api')
        ->name('api.post.delete');
});

Route::prefix('image')->group(function () {
    Route::post('', 'ImageController@apiPostImage')
        ->middleware('auth:api')
        ->name('api.post.image');
});


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


