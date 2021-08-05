<?php

use App\Post;
use App\User;
use Illuminate\Database\Seeder;

class FavouritesTableSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();
        $posts = Post::all();
        $users->each(function($user) use($posts) {
            $posts->each(function($post) use($user) {
                if (DatabaseSeeder::probability()) return;
                $isUserPost = $user === $post->user_id;
                if ($isUserPost) return;
                $post->favourites()->attach($user);
            });
        });
    }
}
