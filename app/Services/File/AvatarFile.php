<?php

namespace App\Services\File;

use App\Services\File;
use App\User;

class AvatarFile extends File
{
    function __construct(User $user, $avatar)
    {
        $this->uri = $avatar['uri'];
        $this->extension = $avatar['extension'];
        $this->directory = 'avatars/' . $user->id;
    }
}