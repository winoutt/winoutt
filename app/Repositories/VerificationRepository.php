<?php

namespace App\Repositories;

use App\User;
use Carbon\Carbon;
use Exception;

class VerificationRepository
{
    public function getUser($email)
    {
        $user = User::where('email', $email)->first();
        if (!$user) throw new Exception('Unable to resend verification');
        if ($user->email_verified_at) throw new Exception('Already verified');
        return $user;
    }

    public function verify($id)
    {
        $user = User::find($id);
        if (!$user) throw new Exception('Unable to verify your email');
        if ($user->email_verified_at) return;
        $user->email_verified_at = Carbon::now();
        $user->save();
    }
}