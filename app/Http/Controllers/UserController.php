<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use App\Services\ACM;
use App\Services\File\AvatarFile;
use App\Services\ImageResize;
use App\Services\ResponseService;
use App\Services\ValidatorService;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Throwable;

class UserController extends Controller
{
    private $userRepository;

    function __construct()
    {
        $this->userRepository = new UserRepository;
    }

    public function read($username)
    {
        try {
            $user = $this->userRepository->read($username);
        } catch (Throwable $e) {
            return ResponseService::notFound('Unable to read user');
        }
        return ResponseService::ok($user);
    }

    public function edit(Request $request)
    {
        $customMessages = [
            'url' => 'Please add a valid :attribute.'
        ];
        ValidatorService::validate($request, [
            'first_name' => 'required|max:20',
            'last_name' => 'required|max:20',
            'username' => [
                'required',
                'alpha_dash',
                'unique:users,username,' . $request->user->id,
                'min:4',
                'max:20'
            ],
            'email' => [
                'required',
                'email',
                'unique:users,email,' . $request->user->id,
                'max:30'
            ],
            'bio' => ['required', 'max:2500'],
            'website.company' => 'nullable|url|max:120',
            'website.personal' => 'nullable|url|max:120',
            'date_of_birth' => 'required|date|before:now|date_format:Y-m-d',
            'gender' => 'required|in:' . implode(',', User::$genders),
            'city' => 'required|max:20',
            'country' => 'required|max:20',
            'define_yourself' => 'required|string|max:97',
            'avatar.uri' => 'sometimes|base64file|base64mimes:jpeg, jpg, png|base64max:3072',
            'avatar.extension' => 'required_with:avatar.uri|in:jpeg,jpg,png'
        ], $customMessages);
        if (ValidatorService::$failed) return ValidatorService::error();
        try {
            $data = ValidatorService::$data;
            if (is_array($request->avatar)) {
                $imageResize = new ImageResize($data->avatar->uri);
                $avatarFile = new AvatarFile($request->user, [
                    'uri' => $imageResize->avatar(),
                    'extension' => $data->avatar->extension
                ]);
                $avatarOriginalFile = new AvatarFile($request->user, [
                    'uri' => $imageResize->compress(),
                    'extension' => $data->avatar->extension
                ]);
                $data->avatar = $avatarFile->store();
                $data->avatar_original = $avatarOriginalFile->store();
            }
            $oldAvatar = $request->user->avatar;
            $user = $this->userRepository->edit($request->user, $data);
            ACM::user($user, $oldAvatar);
            return ResponseService::ok($user);
        } catch (Throwable $e) {
            return ResponseService::badRequest('Unable to update profile');
        }
    }

    public function delete(Request $request)
    {
        ValidatorService::validate($request, [
            'username' => 'required|alpha_dash|exists:users,username'
        ]);
        if (ValidatorService::$failed) return ValidatorService::error();
        $isValidUsername = ($request->user->username === $request->username);
        if (!$isValidUsername) {
            return ResponseService::badRequest('Invalid username');
        }
        try {
            $user = $this->userRepository->delete($request->user);
        } catch (Throwable $e) {
            return ResponseService::badRequest('Unable to delete the user');
        }
        return ResponseService::ok(['isDeleted' => true]);
    }

    public function posts($username)
    {
        try {
            $posts = $this->userRepository->posts($username);
            return ResponseService::ok($posts);
        } catch (Throwable $e) {
            return ResponseService::notFound('Unable to collect posts');
        }
    }
}
