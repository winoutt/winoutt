<?php

namespace App\Repositories;

use App\Post;
use App\User;
use Exception;
use Throwable;

class FavouriteRepository {
    public function create(User $user, $id)
    {
        $post = Post::find($id);
        if (!$post) throw new Exception('Unable to favourite');
        $isFavourited = $user->favourites()->find($post->id);
        if ($isFavourited) throw new Exception('Already favourited');
        $user->favourites()->attach($post);
    }

    public function paginate(User $user)
    {
        return $user->favourites()->orderByDesc('id')->paginate(20);
    }

    public function delete (User $user, $id)
    {
        try {
            $user->favourites()->detach($id);
        } catch (Throwable $e) {
            throw new Exception('Unable to remove post from favorite');
        }
    }
}