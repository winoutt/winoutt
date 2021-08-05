<?php

namespace App;

use App\Services\NotificationService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Notification extends Model
{
    use SoftDeletes;
    public static $types = [
        'connection_request',
        'connection_accept',
        'star',
        'comment',
        'post_mention',
        'comment_mention',
        'post_create',
        'comment_starred_post',
        'comment_commented_post',
        'comment_vote'
    ];
    protected $fillable = ['user_id', 'connection_id', 'type', 'is_read'];
    protected $with = ['connection', 'notifiable'];
    protected $appends = ['is_unfollowed', 'is_post_unfollowed'];
    protected $casts = ['meta' => 'json', 'is_read' => 'boolean'];

    public function getIsPostUnfollowedAttribute()
    {
        if (Auth::check()) {
            $postId = NotificationService::getPostId($this);
            return Auth::user()->postUnfollows()
                ->where('post_id', $postId)
                ->exists();
        }
    }

    public function getIsUnfollowedAttribute()
    {
        if (Auth::check()) {
            return Auth::user()->unfollows()
                ->where('connection_id', $this->connection_id)
                ->exists();
        }
    }

    public function connection()
    {
        return $this->belongsTo('App\User', 'connection_id');
    }

    public function user ()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function notifiable ()
    {
        return $this->morphTo();
    }
}
