<?php

namespace App\Services;

use App\Services\UsernameService\UsernameGenerate;
use App\User;

class UsernameService
{
    public static function generate($name, $recheck = false)
    {
        $username = new UsernameGenerate($name, $recheck);
        $isExists = User::where('username', $username->value)->exists();
        if ($isExists) return self::generate($username->value, true);
        return $username->value;
    }
}