<?php

namespace App\Http\Controllers;

use App\Mail\VerifyEmail;
use Illuminate\Http\Request;
use App\Services\ResponseService;
use App\Services\ValidatorService;
use App\Repositories\VerificationRepository;
use App\Services\MailService;
use App\Services\TokenService;
use Throwable;

class VerificationController extends Controller
{
    private $verificationRepository;

    function __construct()
    {
        $this->verificationRepository = new VerificationRepository;
    }

    public function resend(Request $request)
    {
        ValidatorService::validate($request, [
            'email' => 'required|email|exists:users,email'
        ]);
        if (ValidatorService::$failed) return ValidatorService::error();
        try {
            $user = $this->verificationRepository->getUser($request->email);
        } catch (Throwable $e) {
            return ResponseService::badRequest($e->getMessage());
        }
        try {
            MailService::send($user, new VerifyEmail($user));
        } catch (Throwable $e) {
            $message = 'Unable to send verification email';
            return ResponseService::serviceUnavailable($message);
        }
        return ResponseService::ok(['isResent' => true]);
    }

    public function verify(Request $request)
    {
        ValidatorService::validate($request, [
            'token' => 'required|string'
        ]);
        if (ValidatorService::$failed) return ValidatorService::error();
        try {
            TokenService::verify($request->token, 'email_verify');
        } catch (Throwable $e) {
            return ResponseService::badRequest('Invalid request');
        }
        try {
            $this->verificationRepository->verify(TokenService::$data->iss);
        } catch (Throwable $e) {
            return ResponseService::badRequest($e->getMessage());
        }
        return ResponseService::ok(['isVerified' => true]);
    }
}
