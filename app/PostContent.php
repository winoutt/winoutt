<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostContent extends Model
{
    use SoftDeletes;

    public static $types = [
        'image',
        'video',
        'audio',
        'document',
        'article',
        'album'
    ];
    protected $fillable = [
        'type',
        'body',
        'photo_original',
        'filename',
        'cover',
        'cover_original'
    ];
}
