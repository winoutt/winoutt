<?php

use App\Poll;
use App\PollChoice;
use App\User;
use Illuminate\Database\Seeder;

class PollVotesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        $polls = Poll::all();
        $choices = PollChoice::all();
        $users->each(function($user) use($polls, $choices) {
            $polls->each(function($poll) use($choices, $user) {
                $choices->each(function($choice) use($poll, $user) {
                    if (DatabaseSeeder::probability()) return;
                    $poll->votes()->create([
                        'choice_id' => $choice->id,
                        'user_id' => $user->id
                    ]);
                });
            });
        });
    }
}
