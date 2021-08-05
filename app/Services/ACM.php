<?php

namespace App\Services;

use App\Post;
use App\User;
use Exception;
use GuzzleHttp\Client;

class ACM
{
    protected static function send ($payload)
    {
        try {
            $endpoint = config('acm.endpoint');
            if (!$endpoint) return;
            $http = new Client();
            $http->request('POST', config('acm.endpoint'), ['json' => $payload]);
        } catch (Exception $e) {
            logger('ACM send failed', [$e->getMessage()]);
        }
    }

    public static function user(User $user, $oldAvatar)
    {
        $isAvatarChanged = $user->avatar !== $oldAvatar;
        if (!$isAvatarChanged) return;
        $payload = ['type' => 'user', 'id' => $user->id];
        self::send($payload);
    }

    public static function post (Post $post)
    {
        $isImage = $post->content && $post->content->type === 'image';
        $isVideo = $post->content && $post->content->type === 'video';
        $isAlbum = $post->album;
        $isApplicable = $isImage || $isVideo || $isAlbum;
        if (!$isApplicable) return;
        $payload = ['type' => 'post', 'id' => $post->id];
        self::send($payload);
    }
}