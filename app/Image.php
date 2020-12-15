<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'path',
        'imageable_type',
        'imageable_id',
    ];

    /**
     * The model's default values for attributes.
     *
    */
    protected $attributes = [
        'path' => 'profile/default_profile.png',
        'imageable_type' => 'User',
    ];

    /**
     * Get the owning imageable model.
    */
    public function imageable()
    {
        return $this->morphTo();
    }
}
