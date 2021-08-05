<?php

namespace App\Services\UsernameService;

use App\User;
use Illuminate\Support\Str;

class UsernameGenerate
{
    public $value;

    function __construct($name, $isRecheck = false)
    {
        $this->value = $name;
        if ($isRecheck) return $this->getSafeUsername();
        $this->toLowerCase();
        $this->removeSpace();
    }

    private function getSafeUsername()
    {
        $this->value .= User::count();
    }

    private function toLowerCase()
    {
        $this->value = Str::of($this->value)->lower();
    }

    private function removeSpace()
    {
        $this->value = Str::of($this->value)->replace(' ', '');
    }
}