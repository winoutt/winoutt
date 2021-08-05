<?php

namespace App\Repositories;

use App\Hashtag;
use App\Post;
use App\Services\HashtagService;

class PostHashtagRepository
{
    public function create(Post $post)
    {
        $hashtagNames = HashtagService::parseHashtags($post->caption);
        $postHashtags = collect([]);
        $hashtagNames->each(function($hashtagName) use($post, $postHashtags) {
            $hashtag = Hashtag::where('name', $hashtagName)->first();
            if (!$hashtag) $hashtag = Hashtag::create(['name' => $hashtagName]);
            $isCreated = $post->hashtags()->where('hashtags.id', $hashtag->id)
                ->exists();
            if ($isCreated) return;
            $post->hashtags()->attach($hashtag);
            $postHashtag = $post->postHashtags()->whereHashtagId($hashtag->id)
                ->first();
            $postHashtags->push($postHashtag);
        });
        return $postHashtags;
    }
}