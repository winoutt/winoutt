<?php

namespace App\Repositories;
use App\User;
use Carbon\Carbon;
use Exception;

class ConnectionRepository
{
    public function create(User $user, $data)
    {
        $receiver = User::find($data->userId);
        if (!$receiver) {
            throw new Exception('Unable to send connection request');
        }
        $isSameUser = $user->id === $receiver->id;
        if ($isSameUser) {
            throw new Exception('You can\'t send connect request yourself');
        }
        $isInConnection = $user->connections()->whereId($receiver->id)
            ->exists();
        if ($isInConnection) {
            throw new Exception('Already connected or sent request');
        }
        $user->requestedConnections()
            ->attach($receiver, ['message' => $data->message]);
        return $receiver;
    }

    public function activeConnectionsPaginate($id, $page) {
        $user = User::find($id);
        if (!$user) throw new Exception('User not found');
        $data = $user->acceptedConnections()
            ->orderByDesc('id')
            ->get()
            ->forPage($page, 20)
            ->values();
        $apiEndpoint = 'api/connections/' . $id . '?page=' . ++$page;
        $nextPageUrl = $data->isEmpty() ? null : url($apiEndpoint);
        return ['data' => $data, 'next_page_url' => $nextPageUrl];
    }

    public function accept(User $user, $id)
    {
        $isConnected = $user->receivedAcceptedConnections()
            ->where('users.id', $id)
            ->exists();
        if ($isConnected) {
            throw new Exception('Already connected');
        }
        $requester = $user->receivedPendingConnections()->find($id);
        if (!$requester) {
            throw new Exception('Unable to accept the request');
        }
        $user->receivedPendingConnections()->updateExistingPivot(
            $requester,
            ['accepted_at' => Carbon::now()]
        );
        $hasChat = $user->chats()->where('id', $requester->id)->exists();
        if (!$hasChat) $user->sentChats()->attach($requester->id);
        return $requester;
    }

    public function ignore(User $user, $id)
    {
        $requester = $user->receivedPendingConnections()->find($id);
        if (!$requester) {
            throw new Exception('Unable to ignore the request');
        }
        $user->receivedPendingConnections()->detach($requester);
    }

    public function mutuals(User $user, $id)
    {
        $connection = User::findOrFail($id);
        $userConnections = $user->acceptedConnections()->get();
        $connectionsOfConnection = $connection->acceptedConnections()->get();
        $mutualConnections = $userConnections
            ->intersect($connectionsOfConnection);
        return $mutualConnections;
    }

    public function mutualsPaginate(User $user, $id, $page)
    {
        $data = $this->mutuals($user, $id)->forPage($page, 20)->values();
        $apiEndpoint = 'api/connections/' . $id . '/mutuals?page=' . ++$page;
        $nextPageUrl = $data->isEmpty() ? null : url($apiEndpoint);
        return ['data' => $data, 'next_page_url' => $nextPageUrl];
    }

    public function disconnect(User $user, $id)
    {
        $connection = $user->acceptedConnections()->findOrFail($id);
        $user->requestedAcceptedConnections()->detach($connection);
        $user->receivedAcceptedConnections()->detach($connection);
    }

    public function cancel(User $user, $id)
    {
        $connection = $user->requestedPendingConnections()->findOrFail($id);
        $user->requestedPendingConnections()->detach($connection);
    }

    public function getPivot(User $user, User $connection)
    {
        $requestedConnection = $connection
            ->requestedConnections()
            ->where('users.id', $user->id)
            ->first();
        $requestedPivot = $requestedConnection
            ? $requestedConnection->pivot
            : null;
        $receivedConnection = $connection
            ->receivedConnections()
            ->where('users.id', $user->id)
            ->first();
        $receivedPivot = $receivedConnection 
            ? $receivedConnection->pivot
            : null;
        return $requestedPivot ? $requestedPivot : (
            $receivedPivot ? $receivedPivot : (object) []
        );
    }
}