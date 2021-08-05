<?php

use App\Hashtag;
use App\Post;
use Illuminate\Database\Seeder;

class PostHashtagTableSeeder extends Seeder
{
    public function run()
    {
        $hashtags = Hashtag::all();
        $posts = Post::all();
        $hashtags->each(function($hashtag) use($posts) {
            $posts->each(function($post) use($hashtag) {
                if (DatabaseSeeder::probability()) return;
                $post->hashtags()->attach($hashtag);
            });
        });
    }
}
