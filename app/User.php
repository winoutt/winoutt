<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use App\Repositories\ConnectionRepository;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    public static $genders = ['male', 'female', 'unspecified'];
    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'email',
        'title',
        'bio',
        'date_of_birth',
        'gender',
        'city',
        'country',
        'avatar',
        'avatar_original',
        'password',
        'session_at',
        'email_verified_at',
        'is_online'
    ];
    protected $hidden = [
        'password',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    protected $with = ['settings', 'website'];
    protected $appends = [
        'full_name',
        'is_connected',
        'is_requested',
        'is_received',
        'connections_count',
        'stars_count',
        'mutual_connections_count',
        'posts_count',
        'is_user',
        'is_unfollowed'
    ];

    public function getIsUnfollowedAttribute ()
    {
        if (Auth::check()) {
            return Auth::user()->unfollows()
                ->where('users.id', $this->id)
                ->exists();
        }
    }

    public function getConnectionsCountAttribute() {
        return $this->acceptedConnections()->count();
    }

    public function getStarsCountAttribute () {
        return $this->postStars()->count();
    }

    public function getMutualConnectionsCountAttribute () {
        if (Auth::check()) {
            $connectionRepository = new ConnectionRepository;
            return $connectionRepository
                ->mutuals(Auth::user(), $this->id)
                ->count();
        }
    }

    public function getPostsCountAttribute() {
        return $this->posts()->count();
    }

    public function getIsConnectedAttribute()
    {
        $userId = Auth::id();
        $requested = $this->requestedAcceptedConnections()
            ->where('users.id', $userId)
            ->exists();
        $received = $this->receivedAcceptedConnections()
            ->where('users.id', $userId)
            ->exists();
        return $requested || $received;
    }

    public function getIsRequestedAttribute()
    {
        return $this->receivedPendingConnections()
            ->where('users.id', Auth::id())
            ->exists();
    }

    public function getIsReceivedAttribute()
    {
        return $this->requestedPendingConnections()
            ->where('users.id', Auth::id())
            ->exists();
    }

    public function getIsUserAttribute() {
        if (Auth::check()) {
            return $this->id === Auth::id();
        }
    }

    public function _pollVotes()
    {
        return $this->hasMany('App\PollVote');
    }

    public function _userUnfollows()
    {
        return $this->hasMany('App\Unfollow');
    }

    public function _connectionUnfollows()
    {
        return $this->hasMany('App\Unfollow', 'connection_id');
    }

    public function _postMentions()
    {
        return $this->hasMany('App\PostMention');
    }

    public function _userChats()
    {
        return $this->hasMany('App\Chat');
    }

    public function _connectionChats()
    {
        return $this->hasMany('App\Chat', 'connection_id');
    }

    public function _reportings()
    {
        return $this->hasMany('App\Reporting');
    }

    public function _reportableReportings()
    {
        return $this->hasMany('App\Reporting', 'reportable_id');
    }

    public function _commentMentions()
    {
        return $this->hasMany('App\CommentMention');
    }

    public function _chatArchives()
    {
        return $this->hasMany('App\ChatArchive');
    }

    public function _connections()
    {
        return $this->hasMany('App\Connection');
    }

    public function _connectionConnections()
    {
        return $this->hasMany('App\Connection', 'connection_id');
    }

    public function _favourites()
    {
        return $this->hasMany('App\Favourite');
    }

    public function _connectionNotifications()
    {
        return $this->hasMany('App\Notification', 'connection_id');
    }

    public function _stars()
    {
        return $this->hasMany('App\Star');
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function posts()
    {
        return $this->hasMany('App\Post');
    }

    public function notifications()
    {
        return $this->morphMany('App\Notification', 'notifiable');
    }

    public function userNotifications ()
    {
        return $this->hasMany('App\Notification');
    }

    public function postStars()
    {
        return $this->hasManyThrough('App\Star', 'App\Post');
    }

    public function postComments()
    {
        return $this->hasManyThrough('App\Comment', 'App\Post');
    }

    public function postPostMentions()
    {
        return $this->hasManyThrough('App\PostMention', 'App\Post');
    }

    public function postMentions()
    {
        return $this->hasMany('App\PostMention');
    }

    public function settings()
    {
        return $this->hasOne('App\Settings');
    }

    public function sentChats()
    {
        return $this->belongsToMany(
            'App\User',
            'chats',
            'user_id',
            'connection_id'
        )
        ->withPivot('id')
        ->withTimestamps();
    }

    public function receivedChats()
    {
        return $this->belongsToMany(
            'App\User',
            'chats',
            'connection_id',
            'user_id'
        )
        ->withPivot('id')
        ->withTimestamps();
    }

    public function chats()
    {
        $sent = $this->sentChats()->pluck('users.id');
        $received = $this->receivedChats()->pluck('users.id');
        $chats = $sent->merge($received);
        return User::whereIn('id', $chats);
    }

    public function notes()
    {
        return $this->hasMany('App\Note');
    }

    public function requestedConnections()
    {
        return $this->belongsToMany(
            'App\User',
            'connections',
            'user_id',
            'connection_id'
        )
        ->withTimestamps()
        ->withPivot(['message', 'accepted_at']);
    }

    public function receivedConnections()
    {
        return $this->belongsToMany(
            'App\User',
            'connections',
            'connection_id',
            'user_id'
        )
        ->withTimestamps()
        ->withPivot(['message', 'accepted_at']);
    }

    public function connections()
    {
        $requested = $this->requestedConnections()->pluck('users.id');
        $received = $this->receivedConnections()->pluck('users.id');
        $connections = $requested->merge($received);
        return User::whereIn('id', $connections);
    }

    public function acceptedConnections()
    {
        $requested = $this->requestedAcceptedConnections()->pluck('users.id');
        $received = $this->receivedAcceptedConnections()->pluck('users.id');
        $connections = $requested->merge($received);
        return User::whereIn('id', $connections);
    }

    public function requestedAcceptedConnections()
    {
        return $this->requestedConnections()
            ->wherePivot('accepted_at', '!=', null);
    }

    public function receivedAcceptedConnections()
    {
        return $this->receivedConnections()
            ->wherePivot('accepted_at', '!=', null);
    }

    public function requestedPendingConnections()
    {
        return $this->requestedConnections()
            ->wherePivot('accepted_at', null);
    }

    public function receivedPendingConnections()
    {
        return $this->receivedConnections()
            ->wherePivot('accepted_at', null);
    }

    public function mentionedComments()
    {
        return $this->belongsToMany(
            'App\Comment',
            'comment_mention',
            'user_id',
            'comment_id'
        )->withTimestamps();
    }

    public function unfollows()
    {
        return $this->belongsToMany(
            'App\User',
            'unfollows',
            'user_id',
            'connection_id'
        )->withTimestamps();
    }

    public function favourites()
    {
        return $this->belongsToMany(
            'App\Post',
            'favourites',
            'user_id',
            'post_id'
        )->withTimestamps();
    }
    
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function stars()
    {
        return $this->belongsToMany('App\Post', 'App\Star')->withTimestamps();
    }

    public function messages()
    {
        return $this->hasMany('App\Message');
    }

    public function website()
    {
        return $this->hasOne('App\Website');
    }

    public function chatArchives()
    {
        return $this->belongsToMany(
            'App\Chat',
            'chat_archives',
            'user_id',
            'chat_id'
        )->withTimestamps();
    }

    public function reportings()
    {
        return $this->morphMany('App\Reporting', 'reportable');
    }

    public function commentVotes ()
    {
        return $this->belongsToMany(
            'App\Comment',
            'comment_votes',
            'user_id',
            'comment_id'
        )->withTimestamps();
    }

    public function commentVotesPivot()
    {
        return $this->hasMany('App\CommentVote');
    }

    public function postUnfollows()
    {
        return $this->belongsToMany(
            'App\Post',
            'post_unfollows',
            'user_id',
            'post_id'
        )->withTimestamps();
    }

    public function authorStarView ()
    {
        return $this->belongsToMany(
            'App\Post',
            'author_star_views',
            'user_id',
            'post_id'
        );
    }
}
