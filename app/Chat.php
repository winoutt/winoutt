<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Chat extends Model
{
    use SoftDeletes;

    protected $appends = ['unreads_count', 'last_message', 'is_archived'];

    public function getUnreadsCountAttribute()
    {
        if (Auth::check()) {
            return $this->messages()
                ->where('user_id', '!=', Auth::id())
                ->whereIn('status', ['delivered', 'sent'])
                ->count();
        }
    }

    public function getLastMessageAttribute()
    {
        return $this->lastMessage()->first();
    }

    public function getIsArchivedAttribute()
    {
        if (Auth::check()) {
            return Auth::user()
                ->chatArchives()
                ->where('chats.id', $this->id)
                ->exists();
        }
    }

    public function sentUser()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function receivedUser()
    {
        return $this->belongsTo('App\User', 'connection_id');
    }

    public function messages()
    {
        return $this->hasMany('App\Message');
    }

    public function lastMessage()
    {
        return $this->belongsToMany(
            'App\Message',
            'last_messages',
            'chat_id',
            'message_id'
        )->withTimestamps();
    }
}
