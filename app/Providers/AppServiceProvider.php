<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Gate::define('comment-edit', function ($user, $comment) {
            return $user->id === $comment->user_id;
        });
    
        Gate::define('comment-delete', function ($user, $comment) {
            return $user->id === $comment->user_id || $user->userRole->admin;
        });

        Gate::define('post-delete', function ($user, $post) {
            return $user->id === $post->user_id || $user->userRole->admin;
        });
        Gate::define('user-detail-update', function ($user, $userData) {
            return $user->id === $userData->user_id;
        });
        Gate::define('post-update', function ($user, $post) {
            return $user->id === $post->user_id;
        });
        Gate::define('profile-image-update', function ($user, $image) {
            return $user->id === $image->imageable_id;
        });
    }
}
