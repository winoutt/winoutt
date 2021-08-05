<?php

use App\Chat;
use App\Message;
use Illuminate\Database\Seeder;

class MessagesTableSeeder extends Seeder
{
    public function run()
    {
        $chatsWithUser = Chat::with(['sentUser', 'receivedUser'])->get();
        $chatsWithUser->each(function($chat) {
            $users = collect([$chat->sentUser, $chat->receivedUser]);
            $users->each(function($user) use($chat) {
                $messages = factory(Message::class, 10)
                    ->make(['user_id' => $user->id])
                    ->makeHidden(['is_sent'])
                    ->toArray();
                $chat->messages()->createMany($messages);
            });
        });
    }
}
