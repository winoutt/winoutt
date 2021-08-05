<?php

namespace App\Repositories;

use App\Post;
use App\Star;
use App\User;
use Exception;

class StarRepository
{
    public function create(User $user, $postId)
    {
        $post = Post::find($postId);
        if (!$post) throw new Exception('The post not found');
        $isUsers = $user->id === $post->user_id;
        if ($isUsers) throw new Exception('You can\'t star your post');
        $isStared = $user->stars()->wherePostId($post->id)->exists();
        if ($isStared) throw new Exception('Already stared');
        $user->stars()->attach($post);
        return Star::whereUserId($user->id)->wherePostId($post->id)
            ->firstOrFail();
    }

    public function delete(User $user, $postId)
    {
        $post = Post::find($postId);
        if (!$post) throw new Exception('Unable to unstar');
        $isExists = $user->stars()->wherePostId($post->id)->exists();
        if (!$isExists) throw new Exception('Already unstared');
        return $user->stars()->detach($post);
    }
}