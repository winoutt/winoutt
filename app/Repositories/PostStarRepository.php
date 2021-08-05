<?php

namespace App\Repositories;

use App\Post;
use App\User;
use Exception;

class PostStarRepository
{
    private function markAuthorViewed (User $user, Post $post)
    {
        $isViewed = $user->authorStarView()->where('posts.id', $post->id)->exists();
        if (!$isViewed) $user->authorStarView()->attach($post);
        return $isViewed;
    }

    public function paginate (User $user, $postId)
    {
        $post = Post::find($postId);
        if (!$post) throw new Exception('Unable to find the post');
        $isUserPost = $user->posts()->where('id', $postId)->exists();
        if (!$isUserPost) {
            $message = 'You don\'t have permission to view the stars';
            throw new Exception($message);
        }
        $isAuthorStarViewed = $this->markAuthorViewed($user, $post);
        $paginate = $post->stars()->orderByDesc('id')->paginate(20);
        return [
            'is_author_star_viewed' => $isAuthorStarViewed,
            'stars' => $paginate
        ];
    }
}