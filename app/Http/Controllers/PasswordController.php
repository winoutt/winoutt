<?php

namespace App\Http\Controllers;

use App\Mail\PasswordUpdated;
use App\Mail\ResetPassword;
use App\Repositories\PasswordRepository;
use App\Repositories\UserRepository;
use App\Services\MailService;
use Illuminate\Http\Request;
use App\Services\ResponseService;
use App\Services\TokenService;
use App\Services\ValidatorService;
use Exception;
use Illuminate\Support\Facades\Hash;
use Throwable;

class PasswordController extends Controller
{
    private $passwordRepository;
    private $userRepository;

    function __construct()
    {
        $this->passwordRepository = new PasswordRepository;
        $this->userRepository = new UserRepository;
    }

    public function reset(Request $request)
    {
        ValidatorService::validate($request, [
            'email' => 'required|email|exists:users,email'
        ]);
        if (ValidatorService::$failed) return ValidatorService::error();
        try {
            $user = $this->passwordRepository->getUser($request->email);
        } catch (Throwable $e) {
            return ResponseService::badRequest('Unable to reset password');
        }
        try {
            MailService::send($user, new ResetPassword($user));
        } catch (Throwable $e) {
            $message = 'Unable to send password reset email';
            return ResponseService::serviceUnavailable($message);
        }
        return ResponseService::ok(['isSent' => true]);
    }

    public function update(Request $request)
    {
        $customMessages = [
            'same' => 'The entered passwords don\'t match.'
        ];
        ValidatorService::validate($request, [
            'password' => 'required|min:8',
            'confirmPassword' => 'same:password',
            'token' => 'required|string'
        ], $customMessages);
        if (ValidatorService::$failed) return ValidatorService::error();
        try {
            TokenService::verify($request->token, 'password_reset');
        } catch (Throwable $e) {
            return ResponseService::badRequest('Invalid request');
        }
        try {
            $this->passwordRepository->update(
                TokenService::$data->iss,
                $request->password
            );
        } catch (Throwable $e) {
            return ResponseService::badRequest('Unable to update password');
        }
        try {
            $user = $this->userRepository->getFromId(TokenService::$data->iss);
            MailService::send($user, new PasswordUpdated($user));
        } catch (Throwable $e) {
            $message = 'Unable to send password updated email';
            return ResponseService::serviceUnavailable($message);
        }
        return ResponseService::ok(['isUpdated' => true]);
    }

    public function change(Request $request)
    {
        ValidatorService::validate($request, [
            'currentPassword' => 'required|min:8',
            'newPassword' => 'required|min:8'
        ]);
        if (ValidatorService::$failed) return ValidatorService::error();
        try {
            $this->passwordRepository
                ->change($request->user, ValidatorService::$data);
        } catch (Throwable $e) {
            return ResponseService::badRequest($e->getMessage());
        }
        try {
            $user = $request->user;
            MailService::send($user, new PasswordUpdated($user));
        } catch (Throwable $e) {
            $message = 'Unable to send password change email';
            return ResponseService::serviceUnavailable($message);
        }
        return ResponseService::ok(['isUpdated' => true]);
    }
}
