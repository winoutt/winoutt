<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\PollChoice;
use Faker\Generator as Faker;

$factory->define(PollChoice::class, function (Faker $faker) {
    return [
        'value' => $faker->word()
    ];
});
