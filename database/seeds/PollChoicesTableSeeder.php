<?php

use App\Poll;
use App\PollChoice;
use Illuminate\Database\Seeder;

class PollChoicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $polls = Poll::all();
        $polls->each(function(Poll $poll) {
            $choices = factory(PollChoice::class, rand(3,4))
                ->make()
                ->makeHidden(['is_voted'])
                ->toArray();
            $poll->choices()->createMany($choices);
        });
    }
}
