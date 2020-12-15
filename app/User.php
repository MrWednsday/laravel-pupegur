<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the users posts.
     */
    public function posts()
    {
        return $this->hasMany('App\Post');
    }

    /**
     * Get the users comments.
     */
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    /**
     * Get the users image.
     */
    public function image()
    {
        return $this->morphOne('App\Image', 'imageable');
    }

    /**
     * Get the users user data.
     * If data is not present defult will be used and saved
     */
    public function userData()
    {
        return $this->hasOne('App\UserData')->withDefault(function ($userData, $user) {
            $user->userData()->save($userData);
        });
    }

    /**
     * Get the users role.
     * If data is not present defult will be used and saved
     * Defult:
     *      user -> true
     *      admin -> faslse
     */
    public function userRole()
    {
        return $this->hasOne('App\UserRole')->withDefault(function ($userRole, $user) {
            $user->userRole()->save($userRole);
        });
    }
}
