<?php

namespace App\Repositories;

use App\Comment;
use App\User;
use Exception;

class CommentVoteRepository
{
    public function attach(User $user, $commentId)
    {
        $comment = Comment::find($commentId);
        if (!$comment) throw new Exception('Comment not found');
        $exists = $user->commentVotes()
            ->where('comments.id', $commentId)
            ->exists();
        if ($exists) throw new Exception('Already upvoted');
        try {
            $user->commentVotes()->attach($comment);
            return $comment;
        } catch (Exception $e) {
            throw new Exception('Unable to upvote');
        }
    }

    public function detach(User $user, $commentId)
    {
        $comment = Comment::find($commentId);
        if (!$comment) throw new Exception('Comment not found');
        $exists = $user->commentVotes()
            ->where('comments.id', $commentId)
            ->exists();
        if (!$exists) throw new Exception('Already unvoted');
        try {
            $user->commentVotes()->detach($comment);
            return $comment;
        } catch (Exception $e) {
            throw new Exception('Unable to unvote');
        }
    }
}