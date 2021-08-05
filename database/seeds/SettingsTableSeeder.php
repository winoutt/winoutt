<?php

use App\Settings;
use App\User;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();
        $users->each(function($user) {
            $settings = factory(Settings::class)->make()->toArray();
            $user->settings()->create($settings);
        });
    }
}
