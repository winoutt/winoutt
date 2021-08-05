<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Website;
use Faker\Generator as Faker;

function website(Faker $faker) {
    return 'https://' . $faker->domainName;
}

$factory->define(Website::class, function (Faker $faker) {
    return [
        'company' => website($faker),
        'personal' => website($faker),
    ];
});
