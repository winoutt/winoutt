<?php

use App\Hashtag;
use Illuminate\Database\Seeder;

class HashtagsTableSeeder extends Seeder
{
    public function run()
    {
        factory(Hashtag::class, 150)->create();
    }
}
