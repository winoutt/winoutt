<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hashtag extends Model
{
    use SoftDeletes;

    protected $fillable = ['name'];

    public function posts()
    {
        return $this->belongsToMany(
            'App\Post',
            'post_hashtag',
            'hashtag_id',
            'post_id'
        )->withTimestamps();
    }
}
