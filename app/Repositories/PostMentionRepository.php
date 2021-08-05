<?php

namespace App\Repositories;

use App\Post;
use App\Services\MentionService;
use App\User;
use Exception;
use Illuminate\Database\Eloquent\Builder;

class PostMentionRepository
{
    public function create(Post $post)
    {
        $usernames = MentionService::parseUsernames($post->caption);
        $postMentions = collect([]);
        $usernames->each(function($username) use($post, $postMentions) {
            $user = User::where('username', $username)->first();
            if (!$user) return;
            $isCreated = $post->mentions()->where('users.id', $user->id)
                ->exists();
            if ($isCreated) return;
            $post->mentions()->attach($user);
            $postMention = $post->postMentions()->whereUserId($user->id)
                ->first();
            $postMentions->push($postMention);
        });
        return $postMentions;
    }

    public function suggestions (User $user)
    {
        try {
            $connectedUsers = $user->acceptedConnections()
                ->orderBy('id', 'desc')
                ->limit(20)
                ->get();
            return $connectedUsers;
        } catch (Exception $e) {
            throw new Exception('Unable to suggest users');
        }
    }

    public function searchSuggestions(User $user, $term)
    {
        try {
            if (!$term) return [];
            return $user->acceptedConnections()
            ->where(function(Builder $query) use($term) {
                return $query->where('first_name', 'like', '%'.$term.'%')
                    ->orWhere('last_name', 'like', '%'.$term.'%')
                    ->orWhere('username', 'like', '%'.$term.'%');
            })
            ->limit(20)
            ->get();
        } catch (Exception $e) {
            throw new Exception('Unable to suggest users');
        }
    }
}