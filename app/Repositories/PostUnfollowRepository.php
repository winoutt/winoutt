<?php

namespace App\Repositories;

use App\Post;
use App\User;
use Exception;

class PostUnfollowRepository
{
    public function attach(User $user, $postId)
    {
        $post = Post::find($postId);
        if (!$post) throw new Exception('Unable to find the post');
        $isUnfollowed = $user->postUnfollows()
            ->where('posts.id', $postId)
            ->exists();
        if ($isUnfollowed) throw new Exception('Already unfollowed');
        $user->postUnfollows()->attach($postId);
        return $post;
    }

    public function detach(User $user, $postId)
    {
        $post = Post::find($postId);
        if (!$post) throw new Exception('Unable to find the post');
        $isFollowed = !$user->postUnfollows()
            ->where('posts.id', $postId)
            ->exists();
        if ($isFollowed) throw new Exception('Already followed');
        $user->postUnfollows()->detach($postId);
        return $post;
    }
}