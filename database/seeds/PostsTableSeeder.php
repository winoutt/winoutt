<?php

use App\Post;
use App\Team;
use App\User;
use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();
        $teams = Team::all();
        $users->each(function ($user) use($teams) {
            $teams->each(function ($team) use ($user) {
                if (DatabaseSeeder::probability()) return;
                $posts = factory(Post::class, rand(2, 5))
                    ->make(['team_id' => $team->id])
                    ->makeHidden(['is_user', 'is_favourited', 'is_starred'])
                    ->toArray();
                $user->posts()->createMany($posts);
            });
        });
    }
}
