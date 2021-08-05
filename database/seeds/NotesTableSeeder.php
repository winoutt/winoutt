<?php

use App\Note;
use App\User;
use Illuminate\Database\Seeder;

class NotesTableSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();
        $users->each(function($user) {
            $notes = factory(Note::class, 25)->make()->toArray();
            $user->notes()->createMany($notes);
        });
    }
}
