<?php

namespace App\Repositories;

use App\Comment;
use App\Post;
use App\User;

class CommentRepository
{
    public function paginate($postId)
    {
        $post = Post::findOrFail($postId);
        return $post->comments()->orderByDesc('id')->paginate(15);
    }

    public function create(User $user, $data)
    {
        $post = Post::findOrFail($data->postId);
        $comment = $user->comments()->create([
            'post_id' => $post->id,
            'content' => $data->content
        ]);
        $comment = Comment::find($comment->id);
        return $comment;
    }

    public function delete(User $user, $id)
    {
        $user->comments()->findOrFail($id)->forceDelete();
    }
}