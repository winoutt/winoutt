<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\PostContent;
use App\Fixture\PostFixture;
use Faker\Generator as Faker;

$factory->define(PostContent::class, function (Faker $faker) {
    $validTypes = collect(PostContent::$types)
        ->reject(function($type) { return $type === 'album'; })
        ->all();
    $type = $faker->randomElement($validTypes);
    $fixture = new PostFixture($type, $faker);
    $post = $fixture->post();
    return [
        'type' => $type,
        'body' => $post->body,
        'photo_original' => $post->photo_original,
        'filename' => $post->filename,
        'cover' => $post->cover,
        'cover_original' => $post->photo_original,
    ];
});
