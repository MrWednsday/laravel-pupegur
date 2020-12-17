<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user', 'admin', 'user_id'
    ];

    /**
     * The model's default values for attributes.
     *
     */
    protected $attributes = [
        'user' => true,
        'admin' => false,
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
