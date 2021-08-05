<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'username' => $faker->userName,
        'email' => $faker->safeEmail,
        'title' => $faker->jobTitle,
        'bio' => $faker->realText(250, 2),
        'date_of_birth' => $faker->date('Y-m-d', '2000-01-01'),
        'gender' => $faker->randomElement(User::$genders),
        'city' => $faker->city,
        'country' => $faker->country,
        'avatar' => 'https://i.imgur.com/mDQzOmP.png',
        'avatar_original' => 'https://i.imgur.com/mDQzOmP.png',
        'email_verified_at' => $faker->dateTime,
        'password' => bcrypt('password')
    ];
});
