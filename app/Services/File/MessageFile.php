<?php

namespace App\Services\File;

use App\User;
use App\Services\File;

class MessageFile extends File
{
    function __construct(User $user, $uri, $extension)
    {
        $this->uri = $uri;
        $this->extension = $extension;
        $this->directory = 'messages/' . $user->id;
    }
}