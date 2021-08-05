<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;

class MailService
{   
    public static function send($user, $mail)
    {
        return Mail::to($user)->send($mail);
    }
}