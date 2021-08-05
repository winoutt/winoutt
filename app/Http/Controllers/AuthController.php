<?php

namespace App\Http\Controllers;

use App\Mail\VerifyEmail;
use App\Rules\FullName;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\UserRepository;
use App\Services\MailService;
use App\Services\ResponseService;
use App\Services\TokenService;
use App\Services\ValidatorService;
use Throwable;

class AuthController extends Controller
{
    private $userRepository;

    function __construct() {
        $this->userRepository = new UserRepository;
    }

    public function register(Request $request)
    {
        ValidatorService::validate($request, [
            'full_name' => ['required', 'string', new FullName],
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8'
        ]);
        if (ValidatorService::$failed) return ValidatorService::error();
        try {
            $data = ValidatorService::$data;
            $user = $this->userRepository->register($data);
        } catch (Throwable $e) {
            return ResponseService::serviceUnavailable('Unable to register');
        }
        try {
            MailService::send($user, new VerifyEmail($user));
        } catch(Throwable $e) {
            $message = 'Unable to send verification email';
            return ResponseService::serviceUnavailable($message);
        }
        return ResponseService::created(['isRegistered' => true]);
    }

    public function login(Request $request)
    {
        $customMessage = [
            'required_without' => 'Email or username is required',
        ];
        ValidatorService::validate($request, [
            'email' => 'required_without:username|email',
            'username' => 'required_without:email|alpha_dash',
            'password' => 'required|min:8',
        ], $customMessage);
        if (ValidatorService::$failed) return ValidatorService::error();
        $identity = $request->email
            ? ['email' => $request->email]
            : ['username' => $request->username];
        $credentials = array_merge($identity, $request->only('password'));
        $auth = Auth::attempt($credentials);
        if (!$auth) {
            $credentialType = $request->email ? 'email' : 'username';
            $message = 'Incorrect ' . $credentialType . ' or password.';
            return ResponseService::badRequest($message);
        }
        $user = Auth::user();
        if (!$user->email_verified_at) {
            return ResponseService::ok([
                'isNotVerified' => true,
                'email' => $user->email
            ]);
        }
        $token = TokenService::create('auth', $user->id);
        $response = [
            'isLoggedIn' => true,
            'token' => $token
        ];
        return ResponseService::ok($response);
    }

    public function user(Request $request)
    {
        return ResponseService::ok($request->user);
    }

    public function logout()
    {
        Auth::logout();
        return ResponseService::ok(['isLogout' => true]);
    }
}
