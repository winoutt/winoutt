<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommentVote extends Model
{
    use SoftDeletes;

    public function notifications()
    {
        return $this->morphMany('App\Notification', 'notifiable');
    }
}
