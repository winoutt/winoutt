<?php

use App\Comment;
use App\Post;
use App\Reporting;
use App\User;
use Illuminate\Database\Seeder;

class ReportingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        $posts = Post::all();
        $comments = Comment::all();
        $connections = $users->reverse();
        function reporting(User $user) {
            return factory(Reporting::class)->make(['user_id' => $user->id])
                ->toArray();
        }
        $users->each(function(User $user) use($posts, $comments, $connections) {
            $posts->each(function(Post $post) use($user) {
                if (DatabaseSeeder::probability()) return;
                $post->reportings()->create(reporting($user));
            });
            $comments->each(function(Comment $comment) use($user) {
                if (DatabaseSeeder::probability()) return;
                $comment->reportings()->create(reporting($user));
            });
            $connections->each(function(User $connection) use($user) {
                if (DatabaseSeeder::probability()) return;
                $connection->reportings()->create(reporting($user));
            });
        });
    }
}
