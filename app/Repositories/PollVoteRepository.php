<?php

namespace App\Repositories;

use App\Poll;
use App\PollChoice;
use App\Post;
use App\User;
use Exception;

class PollVoteRepository
{
    public function create(User $user, $data)
    {
        $poll = Poll::find($data->poll_id);
        if (!$poll) throw new Exception('Unable to find poll');
        $choice = PollChoice::find($data->choice_id);
        if (!$choice) throw new Exception('Unable to find poll choice');
        $isPollChoice = $poll->choices()->find($choice->id);
        if (!$isPollChoice) throw new Exception('Invalid poll choice');
        $isUserPost = $poll->post->user->id === $user->id;
        if ($isUserPost) throw new Exception('You can\'t vote to poll');
        $isVoted = $poll->votes()->whereUserId($user->id)
            ->exists();
        if ($isVoted) throw new Exception('Already voted to poll');
        $poll->votes()->create([
            'choice_id' => $choice->id,
            'user_id' => $user->id
        ]);
        return Post::findOrFail($poll->post_id);
    }
}