<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class PollChoice extends Model
{
    use SoftDeletes;

    protected $fillable = ['value'];
    protected $appends = ['is_voted'];
    protected $withCount = ['votes'];

    public function getIsVotedAttribute()
    {
        if (Auth::check()) {
            return Auth::user()->_pollVotes()->where('choice_id', $this->id)
                ->exists();
        }
    }

    public function votes ()
    {
        return $this->hasMany('App\PollVote', 'choice_id');
    }
}
