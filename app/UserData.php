<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserData extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'show_email', 'date_of_birth', 'country', 'gender'
    ];

    /**
     * The model's default values for attributes.
     *
     */
    protected $attributes = [
        'show_email' => false,
        'date_of_birth' => '1900-01-01',
        'country' => '',
        'gender' => '',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
