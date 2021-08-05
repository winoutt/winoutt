<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    use SoftDeletes;

    protected $fillable = ['team_id', 'caption'];
    protected $with = [
        'user',
        'team',
        'content',
        'poll',
        'poll.choices',
        'linkPreview',
        'album'
    ];
    protected $withCount = ['stars', 'comments', 'pollVotes'];
    protected $appends = ['is_user', 'is_favourited', 'is_starred'];

    public function getIsUserAttribute() {
        if (Auth::check()) {
            return Auth::user()->posts()->where('posts.id', $this->id)->exists();
        }
    }

    public function getIsFavouritedAttribute() {
        if (Auth::check()) {
            return Auth::user()->favourites()->where('posts.id', $this->id)
                ->exists();
        }
    }

    public function getIsStarredAttribute() {
        if (Auth::check()) {
            return Auth::user()->stars()->where('posts.id', $this->id)
                ->exists();
        }
    }

    public function postFavourites()
    {
        return $this->hasMany('App\Favourite');
    }

    public function postMentions()
    {
        return $this->hasMany('App\PostMention');
    }

    public function postHashtags()
    {
        return $this->hasMany('App\PostHashtag');
    }

    public function postStars()
    {
        return $this->hasMany('App\Star');
    }

    public function team ()
    {
        return $this->belongsTo('App\Team');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function hashtags()
    {
        return $this->belongsToMany(
            'App\Hashtag',
            'post_hashtag',
            'post_id',
            'hashtag_id'
        )->withTimestamps();
    }

    public function stars()
    {
        return $this->belongsToMany(
            'App\User',
            'stars',
            'post_id',
            'user_id'
        )->withTimestamps();
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function mentions()
    {
        return $this->belongsToMany(
            'App\User',
            'post_mention',
            'post_id',
            'user_id'
        )->withTimestamps();
    }

    public function favourites()
    {
        return $this->belongsToMany(
            'App\User',
            'App\Favourite',
            'post_id',
            'user_id'
        )->withTimestamps();
    }

    public function reportings()
    {
        return $this->morphMany('App\Reporting', 'reportable');
    }

    public function content()
    {
        return $this->hasOne('App\PostContent');
    }

    public function poll()
    {
        return $this->hasOne('App\Poll');
    }

    public function pollVotes () {
        return $this->hasManyThrough('App\PollVote', 'App\Poll');
    }

    public function linkPreview ()
    {
        return $this->morphOne('App\LinkPreview', 'previewable');
    }

    public function notifications()
    {
        return $this->morphMany('App\Notification', 'notifiable');
    }

    public function album ()
    {
        return $this->hasMany('App\PostAlbumPhoto');
    }
}
