<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Settings;
use Faker\Generator as Faker;

$factory->define(Settings::class, function (Faker $faker) {
    return [
        'enabled_notification' => $faker->boolean(),
        'is_dark_mode' => $faker->boolean()
    ];
});
