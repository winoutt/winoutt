<?php

use App\User;
use Illuminate\Database\Seeder;

class ChatsTableSeeder extends Seeder
{
    public function run()
    {
        $senders = User::all();
        $receivers = $senders->reverse();
        $senders->each(function($sender) use($receivers) {
            $receivers->each(function($receiver) use($sender) {
                if (DatabaseSeeder::probability()) return;
                $isSameUser = $receiver->id === $sender->id;
                if ($isSameUser) return;
                $isExists = $sender->sentChats()->find($receiver->id);
                if ($isExists) return;
                $sender->sentChats()->attach($receiver);
            });
        });
    }
}
