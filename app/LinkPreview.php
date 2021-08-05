<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LinkPreview extends Model
{
    use SoftDeletes;

    protected $fillable = ['title', 'description', 'url', 'image'];

    public function previewable()
    {
        return $this->morphTo();
    }
}
