<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PollVote extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id', 'poll_id', 'choice_id'];
}
