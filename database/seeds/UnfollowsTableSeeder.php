<?php

use App\User;
use Illuminate\Database\Seeder;

class UnfollowsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        $connections = $users->reverse();
        $users->each(function(User $user) use($connections) {
            $connections->each(function(User $connection) use($user) {
                if (DatabaseSeeder::probability()) return;
                $user->unfollows()->attach($connection);
            });
        });
    }
}
