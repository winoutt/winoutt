<?php

namespace App\Repositories;

use App\Team;
use App\User;
use Illuminate\Database\Eloquent\Builder;

class TeamRepository
{
    public function list()
    {
        return Team::all();
    }

    public function top()
    {
        return Team::all()
            ->sortByDesc(function($team) {
                return $team->posts()->count();
            })
            ->values()
            ->slice(0, 3);
    }

    public function read($slug)
    {
        return Team::where('slug', $slug)->firstOrFail();
    }

    public function contributors($id)
    {
        $team = Team::findOrFail($id);
        return $team->posts()->with('user')->get()
            ->sortByDesc(function($post) use($team) {
                $post->user->posts_count = $team->posts()
                    ->where('user_id', $post->user->id)
                    ->count();
                return $post->user->posts_count;
            })
            ->sortByDesc(function($post) use($team) {
                $post->user->comments_count = $team->posts()->with('comments')
                    ->whereHas('comments', function(Builder $query) use($post) {
                        $query->where('user_id', $post->user->id);
                    })
                    ->count();
                return $post->user->comments_count;
            })
            ->pluck('user')
            ->unique('id')
            ->slice(0, 5)
            ->values();
    }

    public function posts($id)
    {
        $team = Team::findOrFail($id);
        return $team->posts()
            ->with(['content', 'poll', 'poll.choices'])
            ->orderByDesc('id')
            ->paginate(20);
    }
}