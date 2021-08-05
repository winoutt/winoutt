<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use SoftDeletes;

    protected $fillabe = [
        'name',
        'slug',
        'photo',
        'goal',
        'placeholder'
    ];

    public function posts()
    {
        return $this->hasMany('App\Post');
    }
}
