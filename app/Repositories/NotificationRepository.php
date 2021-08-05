<?php

namespace App\Repositories;

use App\User;
use App\Comment;
use App\CommentMention;
use App\CommentVote;
use App\Notification;
use App\Post;
use App\PostMention;
use App\Star;
use Exception;

class NotificationRepository
{
    private $connectionRepository;

    function __construct()
    {
        $this->connectionRepository = new ConnectionRepository;
    }

    public function read (User $user, $id)
    {
        $notification = $user->userNotifications()->find($id);
        if (!$notification) throw new Exception('Notification not found');
        $notification->connection->pivot = $this->connectionRepository
                    ->getPivot($user, $notification->connection);
        return $notification;
    }

    public function paginate(User $user)
    {
        return $user->userNotifications()
            ->whereHasMorph('notifiable', [
                Comment::class,
                CommentMention::class,
                CommentVote::class,
                Notification::class,
                Post::class,
                PostMention::class,
                Star::class,
                User::class
            ])
            ->where('type', '!=', 'connection_request')
            ->orderByDesc('id')
            ->paginate(20);
    }

    public function markRead(User $user, $id)
    {
        $notification = $user->userNotifications()
            ->whereId($id)
            ->where('is_read', false)
            ->firstOrFail();
        $notification->update(['is_read' => true]);
    }

    public function connectionRequests (User $user)
    {
        try {
            $notifications = $user->userNotifications()
                ->where('type', 'connection_request')
                ->orderByDesc('id')
                ->limit(20)
                ->get();
            $notifications->each(function($notification) use ($user) {
                $notification->connection->pivot = $this->connectionRepository
                    ->getPivot($user, $notification->connection);
            });
            $notifications = $notifications->reject(function($notification) {
                    $isConnected = $notification->connection->is_connected;
                    $isReceived = $notification->connection->is_received;
                    $isPendingConnection = !$isConnected && $isReceived;
                    return $isConnected || !$isPendingConnection;
                })
                ->unique('connection.id')
                ->values();
            return $notifications;
        } catch (Exception $e) {
            $message = 'Unable to list connection requests notifications';
            throw new Exception($message);
        }
    }

    public function unreadsCount (User $user)
    {
        $unreadsCount = $user->userNotifications()
            ->where('is_read', false)
            ->count();
        return $unreadsCount;
    }

    public function markAllRead (User $user)
    {
        $user->userNotifications()
            ->where('is_read', false)
            ->update(['is_read' => true]);
    }
}