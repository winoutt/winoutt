<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Poll extends Model
{
    use SoftDeletes;

    protected $fillable = ['question', 'end_at'];
    protected $appends = ['is_voted'];

    public function getIsVotedAttribute() {
        if (Auth::check()) {
            return Auth::user()->_pollVotes()->where('poll_id', $this->id)
                ->exists();
        }
    }

    public function post()
    {
        return $this->belongsTo('App\Post');
    }

    public function votes()
    {
        return $this->hasMany('App\PollVote');
    }

    public function choices()
    {
        return $this->hasMany('App\PollChoice');
    }
}
