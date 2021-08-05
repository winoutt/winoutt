<?php

namespace App\Services\File;

use App\User;
use App\Services\File;

class PostFile extends File
{
    function __construct(User $user, $uri, $extension)
    {
        $this->uri = $uri;
        $this->extension = $extension;
        $this->directory = 'posts/' . $user->id;
    }
}