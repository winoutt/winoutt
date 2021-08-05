<?php

namespace App\Repositories;

use App\Comment;
use App\Post;
use App\Services\MentionService;
use App\User;
use Exception;

class CommentMentionRepository
{
    public function create(Comment $comment)
    {
        $usernames = MentionService::parseUsernames($comment->content);
        $commentMentions = collect([]);
        $usernames->each(function($username) use($comment, $commentMentions) {
            $user = User::where('username', $username)->first();
            if (!$user) return;
            $isCreated = $comment->mentions()->where('users.id', $user->id)
                ->exists();
            if ($isCreated) return;
            $comment->mentions()->attach($user);
            $commentMention = $comment->commentMentions()
                ->whereUserId($user->id)
                ->first();
            $commentMentions->push($commentMention);
        });
        return $commentMentions;
    }

    public function suggestions (User $user, $postId)
    {
        $post = Post::find($postId);
        if (!$post) throw new Exception('Unable to find the post');
        try {
            $author = $post->user->id;
            $connectedUsers = $user->acceptedConnections()->pluck('id');
            $commentedUsers = $post->comments()->pluck('user_id');
            $users = [$author, ...$connectedUsers, ...$commentedUsers];
            return User::whereIn('id', $users)->limit(20)->get();
        } catch (Exception $e) {
            throw new Exception('Unable to suggest users');
        }
    }

    public function searchSuggestions (User $user, $postId, $term)
    {
        if (!$term) return [];
        $post = Post::find($postId);
        if (!$post) throw new Exception('Unable to find the post');
        try {
            $author = $post->user->id;
            $connectedUsers = $user->acceptedConnections()->pluck('id');
            $commentedUsers = $post->comments()->pluck('user_id');
            $users = [$author, ...$connectedUsers, ...$commentedUsers];
            return User::where('first_name', 'like', '%'.$term.'%')
                ->orWhere('last_name', 'like', '%'.$term.'%')
                ->orWhere('username', 'like', '%'.$term.'%')
                ->whereIn('id', $users)
                ->limit(20)
                ->get();
        } catch (Exception $e) {
            throw new Exception('Unable to suggest users');
        }
    }
}