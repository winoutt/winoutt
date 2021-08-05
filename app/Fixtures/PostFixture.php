<?php

namespace App\Fixture;

class PostFixture
{
    protected $faker;
    protected $type;

    function __construct($type, $faker)
    {
        $this->type = $type;
        $this->faker = $faker;
    }

    protected function extension ()
    {
        $extensions = [
            'image' => 'jpeg',
            'video' => 'mp4',
            'audio' => 'mp3',
            'document' => 'pdf',
            'article' => null
        ];
        return $extensions[$this->type];
    }

    protected function filename()
    {
        return $this->faker->realText(25) . '.' . $this->extension();
    }

    protected function article ()
    {
        return '<h1>' . $this->faker->realText(40) . '</h1><p>' . $this->faker->realText(500) . '</p>';
    }

    public function post ()
    {
        $posts = collect([
            [
                'type' => 'image',
                'body' => 'https://oceanpace-dev.s3.us-east-2.amazonaws.com/seeds/image.jpeg',
                'photo_original' => 'https://oceanpace-dev.s3.us-east-2.amazonaws.com/seeds/image.jpeg',
                'filename' => $this->filename('image'),
                'cover' => null,
                'cover_original' => null,
            ],
            [
                'type' => 'video',
                'body' => 'https://oceanpace-dev.s3.us-east-2.amazonaws.com/seeds/video.mp4',
                'photo_original' => null,
                'filename' => $this->filename('video'),
                'cover' => null,
                'cover_original' => null,
            ],
            [
                'type' => 'audio',
                'body' => 'https://oceanpace-dev.s3.us-east-2.amazonaws.com/seeds/audio.mp3',
                'photo_original' => null,
                'filename' => $this->filename('audio'),
                'cover' => null,
                'cover_original' => null,
            ],
            [
                'type' => 'document',
                'body' => 'https://oceanpace-dev.s3.us-east-2.amazonaws.com/seeds/doc.pdf',
                'photo_original' => null,
                'filename' => $this->filename('document'),
                'cover' => null,
                'cover_original' => null,
            ],
            [
                'type' => 'article',
                'body' => $this->article(),
                'photo_original' => null,
                'filename' => null,
                'cover' => 'https://oceanpace-dev.s3.us-east-2.amazonaws.com/seeds/image.jpeg',
                'cover_original' => 'https://oceanpace-dev.s3.us-east-2.amazonaws.com/seeds/image.jpeg',
            ]
        ]);
        return (object) $posts->firstWhere('type', $this->type);
    }
}
