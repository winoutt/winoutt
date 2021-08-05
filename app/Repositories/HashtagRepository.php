<?php

namespace App\Repositories;

use App\Hashtag;

class HashtagRepository
{
    public function trending()
    {
        return Hashtag::all()->sortByDesc(function($hashtag) {
                return $hashtag->posts()->count();
            })
            ->values()
            ->slice(0, 5);
    }

    public function posts($hashtag)
    {
        $hashtag = Hashtag::where('name', $hashtag)->firstOrFail();
        return $hashtag->posts()->orderByDesc('id')->paginate(25);
    }
}