<?php

namespace App\Repositories;

use App\User;

class PeopleRepository
{
    public function paginate()
    {
        return User::orderByDesc('id')->paginate(25);
    }

    public function mayknow(User $user, $limit = null)
    {
        $user->activeConnections = $user->acceptedConnections()->pluck('id');
        function distantActiveConnections($user) {
            $activeConnections = $user->activeConnections;
            $requestedAccepted = User::whereIn('id', $activeConnections)
                ->with('requestedAcceptedConnections')
                ->get()
                ->pluck('requestedAcceptedConnections')
                ->flatten()
                ->pluck('id');
            $receivedAccepted = User::whereIn('id', $activeConnections)
                ->with('receivedAcceptedConnections')
                ->get()
                ->pluck('receivedAcceptedConnections')
                ->flatten()
                ->pluck('id');
            $userConnections = $user->connections()->pluck('id');
            $rejectables = [$user->id, ...$userConnections];
            return $requestedAccepted->merge($receivedAccepted)
                ->unique()
                ->reject(function ($connection) use ($rejectables) {
                    return in_array($connection, $rejectables);
                })->values();
        }
        function withMutualsCount($user) {
            function count ($user, $distant) {
                $userConnections = $user->acceptedConnections()
                    ->pluck('users.id');
                $connectionsOfConnection = $distant
                    ->acceptedConnections()
                    ->pluck('users.id');
                return $userConnections
                    ->intersect($connectionsOfConnection)
                    ->count();
            }
            $user->distantActiveConnections
                ->each(function($distant) use ($user) {
                    $distant->mutuals_count = count($user, $distant);
                });
            return $user->distantActiveConnections;
        }
        $user->distantActiveConnections = distantActiveConnections($user)
            ->shuffle();
        if ($limit) {
            $user->distantActiveConnections = $user->distantActiveConnections
                ->slice(0, $limit);
        }
        $user->distantActiveConnections = User::whereIn(
            'id',
            $user->distantActiveConnections
        )->get();
        return withMutualsCount($user);
    }

    public function mayknowPaginate (User $user, $page) {
        $data = $this->mayknow($user)->shuffle()->forPage($page, 30)->values();
        $nextPageUrl = $data->isEmpty()
            ? null
            : url('api/peoples/paginate/' . ++$page);
        return ['data' => $data, 'next_page_url' => $nextPageUrl];
    }

    public function search($term)
    {
        if (!$term) return [];
        return User::where('first_name', 'like', '%'.$term.'%')
            ->orWhere('last_name', 'like', '%'.$term.'%')
            ->orWhere('username', 'like', '%'.$term.'%')
            ->get();
    }
}