<?php

use App\Post;
use App\User;
use Illuminate\Database\Seeder;

class StarsTableSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();
        $posts = Post::all();
        $users->each(function($user) use($posts) {
            $posts->each(function($post) use($user) {
                if (DatabaseSeeder::probability()) return;
                $isUserPost = $user->id === $post->user_id;
                if ($isUserPost) return;
                $post->stars()->attach($user);
            });
        });
    }
}
