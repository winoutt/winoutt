<?php

use App\Chat;
use Illuminate\Database\Seeder;

class LastMessagesTableSeeder extends Seeder
{
    public function run()
    {
        $chatsWithMessages = Chat::with('messages')->get();
        $chatsWithMessages->each(function($chat) {
            $lastMessage = $chat->messages->last();
            $chat->lastMessage()->attach($lastMessage);
        });
    }
}
