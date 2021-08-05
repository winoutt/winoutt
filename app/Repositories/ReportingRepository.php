<?php

namespace App\Repositories;

use App\Comment;
use App\Post;
use App\User;
use Exception;

class ReportingRepository
{
    public function create(User $user, $data)
    {
        if ($data->type === 'post') {
            $reportable = Post::findOrFail($data->id);
        } else if ($data->type === 'comment') {
            $reportable = Comment::findOrFail($data->id);
        } else if ($data->type === 'user') {
            $isSameUser = $user->id === $data->id;
            if ($isSameUser) throw new Exception('You can\'t report yourself');
            $reportable = User::findOrFail($data->id);
        }
        return $reportable->reportings()->create([
            'user_id' => $user->id,
            'category' => $data->category,
            'message' => $data->message
        ]);
    }
}