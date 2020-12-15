<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{

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
