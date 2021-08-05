<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Message;
use Faker\Generator as Faker;
use App\Fixture\MessageFixture;

$factory->define(Message::class, function (Faker $faker) {
    $type = $faker->randomElement(Message::$types);
    $fixture = new MessageFixture($type, $faker);
    $message = $fixture->message();
    return [
        'type' => $type,
        'content' => $message->content,
        'photo_original' => $message->photo_original,
        'filename' => $message->filename,
        'status' => $message->status
    ];
});
