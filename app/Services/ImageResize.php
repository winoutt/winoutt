<?php

namespace App\Services;

use Intervention\Image\ImageManagerStatic as Image;

class ImageResize
{
    private $image;

    function __construct($dataUri)
    {
        $this->image = self::toFile($dataUri);
    }

    private static function toFile($dataUri)
    {
        return file_get_contents($dataUri, true);
    }

    private function resize ($width)
    {
        return Image::make($this->image)
            ->resize($width, null, function($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->encode('jpg', 75)
            ->encode('data-url');
    }

    public function compress ()
    {
        return Image::make($this->image)
            ->encode('jpg', 75)
            ->encode('data-url');
    }

    public function avatar ()
    {
        return $this->resize(200);
    }

    public function post ()
    {
        return $this->resize(800);
    }

    public function message ()
    {
        return $this->resize(500);
    }
}