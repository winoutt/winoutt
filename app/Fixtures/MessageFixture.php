<?php

namespace App\Fixture;

use App\Message;
use Illuminate\Support\Str;

class MessageFixture
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
            'text' => null,
            'image' => 'jpeg',
            'video' => 'mp4',
            'audio' => 'mp3',
            'document' => 'pdf'
        ];
        return $extensions[$this->type];
    }

    protected function filename()
    {
        return $this->faker->realText(25) . '.' . $this->extension();
    }

    protected function status ()
    {
        return $this->faker->randomElement(Message::$validStatus);
    }

    public function message ()
    {
        $posts = collect([
            [
                'type' => 'text',
                'content' => $this->faker->realText(20),
                'photo_original' => null,
                'filename' => null,
                'status' => $this->status()
            ],
            [
                'type' => 'image',
                'content' => 'https://oceanpace-dev.s3.us-east-2.amazonaws.com/seeds/image.jpeg',
                'photo_original' => 'https://oceanpace-dev.s3.us-east-2.amazonaws.com/seeds/image.jpeg',
                'filename' => $this->filename(),
                'status' => $this->status()
            ],
            [
                'type' => 'video',
                'content' => 'https://oceanpace-dev.s3.us-east-2.amazonaws.com/seeds/video.mp4',
                'photo_original' => null,
                'filename' => $this->filename(),
                'status' => $this->status()
            ],
            [
                'type' => 'audio',
                'content' => 'https://oceanpace-dev.s3.us-east-2.amazonaws.com/seeds/audio.mp3',
                'photo_original' => null,
                'filename' => $this->filename(),
                'status' => $this->status()
            ],
            [
                'type' => 'document',
                'content' => 'https://oceanpace-dev.s3.us-east-2.amazonaws.com/seeds/doc.pdf',
                'photo_original' => null,
                'filename' => $this->filename(),
                'status' => $this->status()
            ]
        ]);
        return (object) $posts->firstWhere('type', $this->type);
    }
}
