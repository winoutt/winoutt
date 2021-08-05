<?php

namespace App\Repositories;

use App\User;
use Throwable;
use Exception;

class UserStatusRepository
{
    public function update(User $user, $isOnline)
    {
        try {
            $user->update(['is_online' => $isOnline]);
            return $user;
        } catch (Throwable $e) {
            throw new Exception('Unable to update online status');
        }
    }
}