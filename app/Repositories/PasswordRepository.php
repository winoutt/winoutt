<?php

namespace App\Repositories;

use App\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Throwable;

class PasswordRepository
{
    public function getUser($email)
    {
        $user = User::where('email', $email)->first();
        if (!$user) throw new Exception('Unable to find the user');
        return $user;
    }

    public function update($id, $password)
    {
        $user = User::find($id);
        if (!$user) throw new Exception('Unable to find user');
        $user->password = Hash::make($password);
        $user->save();
        return $user;
    }

    public function change(User $user, $data)
    {
        $isSamePassword = $data->currentPassword === $data->newPassword;
        if ($isSamePassword) {
            $message = 'New password can\'t be same as the current password.';
            throw new Exception($message);
        }
        $isValid = Hash::check($data->currentPassword, $user->password);
        if (!$isValid) throw new Exception('Invalid current password');
        try {
            return $this->update($user->id, $data->newPassword);
        } catch (Throwable $e) {
            throw new Exception('Unable to update password');
        }
    }
}