<?php

use App\Connection;
use App\User;
use Illuminate\Database\Seeder;

class ConnectionsTableSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();
        $requesters = collect($users)->shuffle();
        $receivers = $requesters->shuffle();
        $requesters->each(function($requester) use ($receivers) {
            $receivers->each(function($receiver) use ($requester) {
                if (DatabaseSeeder::probability()) return;
                $isSameUser = $requester->id === $receiver->id;
                if ($isSameUser) return;
                $connection = factory(Connection::class)->make()->toArray();
                $requester->requestedConnections()->attach($receiver);
                $requester->requestedConnections()->updateExistingPivot(
                    $receiver,
                    $connection
                );
            });
        });
    }
}
