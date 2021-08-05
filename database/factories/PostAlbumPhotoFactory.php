<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Fixture\PostFixture;
use App\PostAlbumPhoto;
use Faker\Generator as Faker;

$factory->define(PostAlbumPhoto::class, function (Faker $faker) {
    $fixture = new PostFixture('image', $faker);
    $post = $fixture->post();
    return [
        'photo' => $post->body,
        'photo_original' => $post->photo_original,
        'filename' => $post->filename
    ];
});
