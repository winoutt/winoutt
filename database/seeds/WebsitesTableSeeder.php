<?php

use App\User;
use App\Website;
use Illuminate\Database\Seeder;

class WebsitesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        $users->each(function(User $user) {
            $websites = factory(Website::class)->make()->toArray();
            $user->website()->create($websites);
        });
    }
}
