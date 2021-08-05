<?php

use App\Comment;
use App\User;
use Illuminate\Database\Seeder;

class CommentMentionTableSeeder extends Seeder
{

    public function run()
    {
        $users = User::all();
        $comments = Comment::all();
        $users->each(function($user) use($comments) {
            $comments->each(function($comment) use($user) {
                if (DatabaseSeeder::probability()) return;
                $isUserComment = $user->id === $comment->id;
                if ($isUserComment) return;
                $comment->mentions()->attach($user);
            });
        });
    }
}
