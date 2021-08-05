<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommentHashtag extends Model
{
    use SoftDeletes;

    protected $table = 'comment_hashtag';
}
