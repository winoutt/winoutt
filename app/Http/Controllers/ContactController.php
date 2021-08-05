<?php

namespace App\Http\Controllers;

use App\Mail\Contact;
use App\Services\MailService;
use App\Services\ReCaptcha;
use App\Services\ResponseService;
use App\Services\ValidatorService;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    protected $recaptcha;

    public function __construct()
    {
        $this->recaptcha = new ReCaptcha();
    }

    public function contact(Request $request)
    {
        ValidatorService::validate($request, [
            'name' => 'required|max:40',
            'email' => 'required|email|max:30',
            'subject' => 'required|max:60',
            'message' => 'required|max:2500',
            'recaptcha' => 'required'
        ]);
        if (ValidatorService::$failed) return ValidatorService::error();
        $contact = (object) $request->all();
        $isValidCaptcha = $this->recaptcha
            ->isValid($request->recaptcha, 'helpContactSend');
        if (!$isValidCaptcha) {
            $message = 'Captcha verification failed';
            return ResponseService::unprocessable($message);
        }
        try {
            MailService::send(env('MAIL_FROM_ADDRESS'), new Contact($contact));
        } catch (\Throwable $th) {
            $message = 'The server was unable to send the message at this time. Please try again later.';
            return ResponseService::serviceUnavailable($message);
        }
        return ResponseService::ok(['isSent' => true]);
    }
}
