<?php

namespace App\Repositories;

use App\User;
use Carbon\Carbon;

class SessionRepository
{
    public function update(User $user)
    {
        $user->session_at = Carbon::now();
        $user->save();
    }
}