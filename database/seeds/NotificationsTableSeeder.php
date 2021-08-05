<?php

use App\Services\NotificationService;
use App\User;
use Illuminate\Database\Seeder;

class NotificationsTableSeeder extends Seeder
{
    private function createConnectionRequests(User $user)
    {
        $pendingConnections = $user->receivedPendingConnections;
        $pendingConnections->each(function($requester) use($user) {
            NotificationService::connectionRequest($requester, $user);
        });
    }

    private function createConnectionAccepts(User $user)
    {
        $acceptedConnections = $user->requestedAcceptedConnections;
        $acceptedConnections->each(function($receiver) use($user) {
            NotificationService::connectionAccept($receiver, $user);
        });
    }

    private function createStars(User $user)
    {
        $stars = $user->postStars;
        $stars->each(function($star) {
            NotificationService::star($star);
        });
    }

    private function createComments(User $user)
    {
        $comments = $user->postComments;
        $comments->each(function($comment) {
            NotificationService::comment($comment);
        });
    }

    private function createPostMetions(User $user)
    {
        $mentions = $user->postMentions;
        $mentions->each(function($mention) {
            NotificationService::postMention($mention);
        });
    }

    private function createCommentMentions($user)
    {
        $mentions = $user->_commentMentions;
        $mentions->each(function($mention) {
            NotificationService::commentMention($mention);
        });
    }

    private function createPostCreate ($user)
    {
        $user->posts->each(function($post) {
            NotificationService::postCreate($post);
        });
    }

    private function createCommentStarredPost(User $user)
    {
        $comments = $user->postComments;
        $comments->each(function($comment) {
            NotificationService::commentStarredPost($comment);
        });
    }

    private function createCommentCommentedPost(User $user)
    {
        $comments = $user->postComments;
        $comments->each(function($comment) {
            NotificationService::commentCommentedPost($comment);
        });
    }

    private function createCommentVote(User $user)
    {
        $comments = $user->postComments;
        $comments->each(function($comment) use ($user) {
            NotificationService::commentVote($user, $comment);
        });
    }

    public function run()
    {
        $users = User::all();
        NotificationService::$canBroadcast = false;
        $users->each(function($user) {
            $this->createConnectionRequests($user);
            $this->createConnectionAccepts($user);
            $this->createStars($user);
            $this->createComments($user);
            $this->createPostMetions($user);
            $this->createCommentMentions($user);
            $this->createPostCreate($user);
            $this->createCommentStarredPost($user);
            $this->createCommentCommentedPost($user);
            $this->createCommentVote($user);
        });
    }
}
