<?php

namespace App\Repositories;

use App\Services\UsernameService;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Exception;

class UserRepository
{
    private $connectionRepository;

    function __construct()
    {
        $this->connectionRepository = new ConnectionRepository;
    }

    public function getFromId($id) {
        $user = User::find($id);
        if (!$user) throw new Exception('Unable to find the user');
        return $user;
    }

    public function getFromEmail($email)
    {
        $user = User::where('email', $email)->first();
        if (!$user) throw new Exception('Unable to find the user');
        return $user;
    }

    public function updatePassword(User $user, $password)
    {
        $user->password = Hash::make($password);
        $user->save();
        return $user;
    }

    public function isUserPost($user, $post)
    {
        $isUserPost = ($user->id === $post->user_id);
        return $isUserPost;
    }

    public function isUserComment(User $user, $comment)
    {
        $isUserComment = ($user->id === $comment->user_id);
        return $isUserComment;
    }

    public function isSameUser($firstUser, $secondUser)
    {
        return ($firstUser->id === $secondUser->id);
    }

    public function markAsVerified(User $user)
    {
        $user->email_verified_at = Carbon::now();
        $user->save();
        return $user;
    }

    public function getAuthUser(User $user)
    {
        $user = User::with(['settings', 'website'])->find($user->id);
        $requested = $user->requestedAcceptedConnections()->count();
        $received = $user->receivedAcceptedConnections()->count();
        $user->connections_count = $requested + $received;
        $user->posts_count = $user->posts()->count();
        return $user;
    }

    public function register($data)
    {
        $fullname = $data->full_name;
        $names = Str::of($fullname)->explode(' ');
        $username = UsernameService::generate($fullname);
        $user = [
            'first_name' => $names[0],
            'last_name' => $names[1],
            'username' => $username,
            'email' => $data->email,
            'password' => Hash::make($data->password),
            'avatar' => 'https://oceanpace-prod.s3.us-east-2.amazonaws.com/assets/default-avatar.png',
            'avatar_original' => 'https://oceanpace-prod.s3.us-east-2.amazonaws.com/assets/default-avatar.png',
        ];
        $user = User::create($user);
        $user->settings()->create();
        $user->website()->create();
        return $user;
    }

    public function read($username)
    {
        return User::where('username', $username)->firstOrFail();
    }

    public function delete(User $user)
    {
        return $user->forceDelete();
    }

    public function edit(User $user, $data)
    {
        $user->first_name = $data->first_name;
        $user->last_name = $data->last_name;
        $user->username = $data->username;
        $user->email = $data->email;
        $user->bio = $data->bio;
        $user->date_of_birth = $data->date_of_birth;
        $user->gender = $data->gender;
        $user->city = $data->city;
        $user->country = $data->country;
        $user->title = $data->define_yourself;
        $user->avatar = $data->avatar;
        $user->avatar_original = $data->avatar_original;
        $user->save();
        $user->website->company = $data->website->company;
        $user->website->personal = $data->website->personal;
        $user->website->save();
        return $user;
    }

    public function posts($username) {
        $user = User::where('username', $username)->firstOrFail();
        return $user->posts()->orderByDesc('id')->paginate(20);
    }
}
