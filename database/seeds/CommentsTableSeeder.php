<?php

use App\Comment;
use App\Post;
use App\User;
use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();
        $posts = Post::all();
        $users->each(function($user) use($posts) {
            $posts->each(function($post) use($user) {
                if (DatabaseSeeder::probability()) return;
                $comments = factory(Comment::class, 2)
                    ->make(['user_id' => $user->id])
                    ->makeHidden(['is_user', 'is_voted', 'is_author'])
                    ->toArray();
                $post->comments()->createMany($comments);
            });
        });
    }
}
