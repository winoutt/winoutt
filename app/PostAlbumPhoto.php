<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostAlbumPhoto extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'photo',
        'photo_original',
        'filename'
    ];
}
