<?php

namespace App\Repositories;

use App\Hashtag;
use App\Post;
use App\User;

class SearchRepository
{
    public function all($term, User $user = null)
    {
        if (!$term) return ['hashtags' => [], 'people' => [], 'posts' => []];
        $hashtags = Hashtag::where('name', 'like', '%'.$term.'%')->limit(5)
            ->get();
        $people = User::where(function($query) use ($term) {
                $query->where('first_name', 'like', '%'.$term.'%');
                $query->orWhere('last_name', 'like', '%'.$term.'%');
                $query->orWhere('username', 'like', '%'.$term.'%');
            })
            ->limit(6)
            ->get();
        if ($user) {
            $people = $people->reject(function($people) use ($user) {
                return $people->id === $user->id;
            });
        }
        $posts = Post::where('caption', 'like', '%'.$term.'%')->limit(5)
            ->get();
        return [
            'hashtags' => $hashtags,
            'people' => $people,
            'posts' => $posts
        ];
    }
}