<?php

namespace App\Services;

use ReCaptcha\ReCaptcha as GoogleReCaptcha;

class ReCaptcha
{
    protected $recaptcha;

    public function __construct()
    {
        $this->recaptcha = new GoogleReCaptcha(env('RECAPTCHA_SECRET_KEY'));
    }

    public function isValid($token, $action)
    {
        $response = $this->recaptcha->setExpectedAction($action)
            ->verify($token);
        return $response->isSuccess();
    }
}