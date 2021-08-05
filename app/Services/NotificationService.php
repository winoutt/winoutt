<?php

namespace App\Services;

use App\Comment;
use App\CommentMention;
use App\Events\NotificationCreated;
use App\Notification;
use App\Post;
use App\PostMention;
use App\Star;
use App\User;
use Illuminate\Support\Facades\Auth;

class NotificationService
{
    public static $canBroadcast = true;

    private static function canProcess (User $user, $type, Post $post = null)
    {
        $isSameUser = Auth::id() === $user->id;
        $isEnabled = $user->settings->enabled_notification;
        $isPostUnfollowed = $post && $user->postUnfollows()
            ->where('post_id', $post->id)
            ->exists();
        $isUserUnfollowed = $user->unfollows()
            ->where('connection_id', Auth::id())
            ->exists();
        $canNormal = (
            !$isSameUser
            && $isEnabled
            && !$isPostUnfollowed
            && !$isUserUnfollowed
        );
        $canRequest = !$isSameUser;
        $isConnectionRequest = ($type === 'connection_request');
        return $isConnectionRequest ? $canRequest : $canNormal;
    }

    private static function broadcast(Notification $notification)
    {
        if (!self::$canBroadcast) return;
        event(new NotificationCreated($notification));
    }

    /**
     * Notification creator
     * @param string type Notification type
     * @param User user The user who receive the notification
     * @param User connection The user who send the notification
     * @param object notifiable The notifiable data
     * @return Notification
     */
    private static function create($type, User $user, User $connection, $notifiable)
    {
        $notification = $notifiable->notifications()->create([
            'user_id' => $user->id,
            'connection_id' => $connection->id,
            'type' => $type,
            'is_read' => false
        ]);
        return Notification::find($notification->id);
    }

    /**
     * Get post Id from notification meta data
     * The same implementation find on client side notification service
     * in ordr to get post Id from notification object
     * @param Notification notification The notification data
     * @return integer|null
     */
    public static function getPostId(Notification $notification)
    {
        if (!$notification->notifiable) return null;
        $hasPostId = in_array($notification->type, [
        'star',
        'comment',
        'post_mention',
        'comment_starred_post',
        'comment_commented_post',
        'comment_vote'
        ]);
        if ($hasPostId) return $notification->notifiable->post_id;
        else if ($notification->type === 'comment_mention') {
            return $notification->notifiable->comment->post_id;
        } else if ($notification->type === 'post_create') {
            return $notification->notifiable->id;
        } else return null;
    }

    public static function connectionRequest(User $user, User $receiver)
    {
        $type = 'connection_request';
        if (!self::canProcess($receiver, $type)) return;
        $notification = self::create(
            $type,
            $receiver,
            $user,
            $user
        );
        self::broadcast($notification);
    }
    
    public static function connectionAccept(User $user, User $requester)
    {
        $type = 'connection_accept';
        if (!self::canProcess($requester, $type)) return;
        $notification = self::create(
            $type,
            $requester,
            $user,
            $user
        );
        self::broadcast($notification);
    }
    
    public static function star(Star $star)
    {
        $type = 'star';
        if (!self::canProcess($star->post->user, $type, $star->post)) return;
        $notification = self::create(
            $type,
            $star->post->user,
            $star->user,
            $star
        );
        self::broadcast($notification);
    }

    public static function comment(Comment $comment)
    {
        $type = 'comment';
        if (!self::canProcess($comment->post->user, $type, $comment->post)) return;
        $notification = self::create(
            $type,
            $comment->post->user,
            $comment->user,
            $comment
        );
        self::broadcast($notification);
    }

    public static function postMention(PostMention $postMention)
    {
        $type = 'post_mention';
        if (!self::canProcess($postMention->user, $type, $postMention->post)) return;
        $notification = self::create(
            $type,
            $postMention->user,
            $postMention->post->user,
            $postMention
        );
        self::broadcast($notification);
    }

    public static function commentMention(CommentMention $commentMention)
    {
        $type = 'comment_mention';
        $mention = clone $commentMention;
        if (!self::canProcess($mention->user, $type, $mention->comment->post)) return;
        $notification = self::create(
            $type,
            $commentMention->user,
            $commentMention->comment->user,
            $commentMention
        );
        self::broadcast($notification);
    }

    public static function postCreate (Post $post)
    {
        $type = 'post_create';
        $userConnections = $post->user->acceptedConnections()->get();
        $userConnections->each(function($connection) use ($post, $type) {
            if (!self::canProcess($connection, $type)) return;
            $post = clone $post;
            $notification = self::create(
                $type,
                $connection,
                $post->user,
                $post
            );
            self::broadcast($notification);
        });
    }

    public static function commentStarredPost (Comment $comment)
    {
        $type = 'comment_starred_post';
        $comment = clone $comment;
        $stars = $comment->post->stars;
        $stars->each(function ($starredUser) use ($comment, $type) {
            if (!self::canProcess($starredUser, $type, $comment->post)) return;
            $notification = self::create(
                $type,
                $starredUser,
                $comment->user,
                $comment
            );
            self::broadcast($notification);
        });
    }

    public static function commentCommentedPost (Comment $comment)
    {
        $type = 'comment_commented_post';
        $comment = clone $comment;
        $postComments = $comment->post->comments()
            ->with('user')
            ->get()
            ->unique('user.id')
            ->values();
        $postComments->each(function ($postComment) use ($comment, $type) {
            if (!self::canProcess($postComment->user, $type, $postComment->post)) return;
            $notification = self::create(
                $type,
                $postComment->user,
                $comment->user,
                $comment
            );
            self::broadcast($notification);
        });
    }

    public static function commentVote (User $user, Comment $comment)
    {
        $type = 'comment_vote';
        $comment = clone $comment;
        if (!self::canProcess($comment->user, $type, $comment->post)) return;
        $notification = self::create(
            $type,
            $comment->user,
            $user,
            $comment
        );
        self::broadcast($notification);
    }
}