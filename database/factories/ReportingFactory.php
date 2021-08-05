<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Reporting;
use Faker\Generator as Faker;

$factory->define(Reporting::class, function (Faker $faker) {
    return [
        'category' => $faker->randomElement(Reporting::$categories)
    ];
});
