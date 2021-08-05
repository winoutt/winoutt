<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommentMention extends Model
{
    use SoftDeletes;

    protected $table = 'comment_mention';
    protected $with = ['comment'];

    public function comment()
    {
        return $this->belongsTo('App\Comment');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function notifications()
    {
        return $this->morphMany('App\Notification', 'notifiable');
    }
}
