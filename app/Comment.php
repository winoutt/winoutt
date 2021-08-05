<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Comment extends Model
{
    use SoftDeletes;

    protected $fillable = ['post_id', 'content'];
    protected $with = ['user', 'post'];
    protected $withCount = ['votes'];
    protected $appends = ['is_user', 'is_voted', 'is_author'];

    public function getIsAuthorAttribute () {
        $postUser = $this->post->user->id;
        $commentUser = $this->user->id;
        return $postUser === $commentUser;
    }

    public function getIsVotedAttribute() {
        if (Auth::check()) {
            return Auth::user()
                ->commentVotes()
                ->where('comments.id', $this->id)
                ->exists();
        }
    }

    public function getIsUserAttribute() {
        if (Auth::check()) {
            return Auth::user()
                ->comments()
                ->where('comments.id', $this->id)
                ->exists();
        }
    }

    public function commentHashtags()
    {
        return $this->hasMany('App\CommentHashtag');
    }

    public function commentMentions()
    {
        return $this->hasMany('App\CommentMention');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function post()
    {
        return $this->belongsTo('App\Post');
    }

    public function mentions()
    {
        return $this->belongsToMany(
            'App\User',
            'comment_mention',
            'comment_id',
            'user_id'
        )->withTimestamps();
    }

    public function hashtags()
    {
        return $this->belongsToMany(
            'App\Hashtag',
            'comment_hashtag',
            'comment_id',
            'hashtag_id'
        )->withTimestamps();
    }

    public function reportings()
    {
        return $this->morphMany('App\Reporting', 'reportable');
    }

    public function votes ()
    {
        return $this->belongsToMany(
            'App\User',
            'comment_votes',
            'comment_id',
            'user_id'
        )->withTimestamps();
    }

    public function votesPivot()
    {
        return $this->hasMany('App\CommentVote');
    }

    public function notifications()
    {
        return $this->morphMany('App\Notification', 'notifiable');
    }
}
