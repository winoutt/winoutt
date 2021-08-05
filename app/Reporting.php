<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reporting extends Model
{
    use SoftDeletes;

    public static $categories = [
        'mimic',
        'fake',
        'rude',
        'explicit',
        'harassment',
        'violent',
        'other'
    ];
    public static $types = ['comment', 'post', 'user'];
    protected $fillable = ['user_id', 'category', 'message'];

    public function reportable()
    {
        return $this->morphTo();
    }
}
