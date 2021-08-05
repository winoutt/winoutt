<?php

namespace App\Repositories;

use App\Comment;
use App\Hashtag;
use App\Services\HashtagService;

class CommentHashtagRepository
{
    public function create(Comment $comment)
    {
        $hashtagNames = HashtagService::parseHashtags($comment->content);
        $commentHashtags = collect([]);
        $hashtagNames->each(function($hashtagName) use($comment, $commentHashtags) {
            $hashtag = Hashtag::where('name', $hashtagName)->first();
            if (!$hashtag) $hashtag = Hashtag::create(['name' => $hashtagName]);
            $isCreated = $comment->hashtags()->where('hashtags.id', $hashtag->id)
                ->exists();
            if ($isCreated) return;
            $comment->hashtags()->attach($hashtag);
            $commentHashtag = $comment->commentHashtags()->whereHashtagId($hashtag->id)
                ->first();
            $commentHashtags->push($commentHashtag);
        });
        return $commentHashtags;
    }
}