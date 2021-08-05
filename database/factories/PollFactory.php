<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Poll;
use Faker\Generator as Faker;
use Illuminate\Support\Carbon;

$factory->define(Poll::class, function (Faker $faker) {
    return [
        'question' => $faker->realText(20),
        'end_at' => Carbon::now()->addDay($faker->randomDigit()),
    ];
});
