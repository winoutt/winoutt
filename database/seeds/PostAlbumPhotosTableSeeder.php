<?php

use App\Post;
use App\PostAlbumPhoto;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PostAlbumPhotosTableSeeder extends Seeder
{
    private $faker;

    function __construct()
    {
        $this->faker = Faker::create();
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = Post::all();
        $posts->each(function($post) {
            if (DatabaseSeeder::probability()) return;
            $albumSize = $this->faker->numberBetween(2, 20);
            $albumPhotos = factory(PostAlbumPhoto::class, $albumSize)
                ->make()
                ->toArray();
            $post->album()->createMany($albumPhotos);
        });
    }
}
