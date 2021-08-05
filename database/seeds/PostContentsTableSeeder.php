<?php

use App\Post;
use App\PostContent;
use Illuminate\Database\Seeder;

class PostContentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = Post::all();
        $posts->each(function($post) {
            if ($post->poll && $post->album) return;
            $postContent = factory(PostContent::class)->make()->toArray();
            $post->content()->create($postContent);
        });
    }
}
