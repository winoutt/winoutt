<?php

use App\Poll;
use App\Post;
use Illuminate\Database\Seeder;

class PollsTableSeeder extends Seeder
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
            if ($post->album) return;
            if (DatabaseSeeder::probability()) return;
            $poll = factory(Poll::class)
                ->make()
                ->makeHidden(['is_voted'])
                ->toArray();
            $post->poll()->create($poll);
        });
    }
}
