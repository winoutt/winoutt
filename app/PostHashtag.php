<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostHashtag extends Model
{
    use SoftDeletes;

    protected $table = 'post_hashtag';
}
