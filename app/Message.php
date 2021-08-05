<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Message extends Model
{
    use SoftDeletes;

    public static $types = [
        'text',
        'image',
        'video',
        'audio',
        'document'
    ];
    public static $validStatus = ['sent', 'delivered', 'read'];
    protected $fillable = [
        'chat_id',
        'type',
        'content',
        'photo_original',
        'filename',
        'status'
    ];
    protected $appends = ['is_sent'];
    protected $with = ['linkPreview'];

    public function getIsSentAttribute()
    {
        if (Auth::check()) {
            return Auth::user()->messages()->where('id', $this->id)->exists();
        }
    }

    public function chat()
    {
        return $this->belongsTo('App\Chat');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function linkPreview ()
    {
        return $this->morphOne('App\LinkPreview', 'previewable');
    }
}
