<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Connection;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Connection::class, function (Faker $faker) {
    $acceptedAts = [null, Carbon::now()];
    return [
        'accepted_at' => $faker->randomElement($acceptedAts)
    ];
});
