<?php

namespace App\Repositories;

use App\Post;
use App\Team;
use App\User;
use Carbon\Carbon;

class PostRepository
{
    public function create(User $user, $data)
    {
        $team = Team::findOrFail($data->teamId);
        $post = $user->posts()->create([
            'team_id' => $team->id,
            'caption' => property_exists($data, 'caption') ?
                $data->caption : null
        ]);
        if ($data->type === 'poll') {
            $poll = $post->poll()->create([
                'question' => $data->question,
                'end_at' => new Carbon($data->endAt)
            ]);
            $choices = collect($data->choices)->map(function($choice) {
                return ['value' => $choice];
            });
            $poll->choices()->createMany($choices);
        } else if ($data->type === 'article') {
            $post->content()->create([
                'type' => $data->type,
                'body' => $data->body,
                'cover' => isset($data->cover)
                    ? $data->cover
                    : null,
                'cover_original' => isset($data->cover_original)
                    ? $data->cover_original
                    : null
            ]);
        } else if ($data->type === 'album') {
            $photos = collect($data->photos)->map(function($photo) {
                return [
                    'photo' => $photo['photo'],
                    'photo_original' => $photo['photo_original'],
                    'filename' => $photo['filename']
                ];
            });
            $post->album()->createMany($photos->all());
        } else if ($data->type !== 'text') {
            $content = [
                'type' => $data->type,
                'body' => $data->body,
                'filename' => $data->filename
            ];
            $content['photo_original'] = ($data->type === 'image')
                ? $data->photo_original
                : null;
            $post->content()->create($content);
        }
        return Post::findOrFail($post->id);
    }

    public function delete(User $user, $id)
    {
        $post = $user->posts()->findOrFail($id);
        $post->forceDelete();
    }

    public function read($id)
    {
        return Post::findOrFail($id);
    }

    public function top()
    {
        $previousWeekDay = Carbon::now()->addWeek(-1);
        return Post::where('created_at', '>', $previousWeekDay)
            ->withCount(['stars', 'comments'])
            ->orderBy('stars_count', 'desc')
            ->orderBy('comments_count', 'desc')
            ->limit(25)
            ->get();
    }

    public function createLinkPreview (Post $post, $preview)
    {
        $post->linkPreview()->create([
            'title' => $preview->title,
            'description' => $preview->description,
            'url' => $preview->url,
            'image' => $preview->image
        ]);
        return Post::findOrFail($post->id);
    }
}