<?php

use App\Comment;
use App\Hashtag;
use Illuminate\Database\Seeder;

class CommentHashtagTableSeeder extends Seeder
{
    public function run()
    {
        $hashtags = Hashtag::all();
        $comments = Comment::all();
        $hashtags->each(function($hashtag) use($comments) {
            $comments->each(function($comment) use($hashtag) {
                if (DatabaseSeeder::probability()) return;
                $comment->hashtags()->attach($hashtag);
            });
        });
    }
}
