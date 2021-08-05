<?php

namespace App\Repositories;

use App\User;
use Exception;

class UnfollowRepository
{
    public function unfollow(User $user, $connectionId)
    {
        $isUnfollowed = $user->unfollows()
            ->where('users.id', $connectionId)
            ->exists();
        if ($isUnfollowed) throw new Exception('Already unfollowed');
        $user->unfollows()->attach($connectionId);
    }

    public function follow (User $user, $connectionId) {
        $isFollowed = !$user->unfollows()
            ->where('users.id', $connectionId)
            ->exists();
        if ($isFollowed) throw new Exception('Already followed');
        $user->unfollows()->detach($connectionId);
    }
}