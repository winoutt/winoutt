<?php

namespace App\Services;

class MediaValidateRule
{
    protected $size = [
        'image' => 3,
        'video' => 25,
        'audio' => 5,
        'document' => 20
    ];
    protected $extensions = [
        'image' => 'jpg,jpeg,png,JPG,JPEG,PNG',
        'video' => 'mp4,MP4',
        'audio' => 'mp3,wav,MP3,WAV'
    ];

    protected function getSize($type)
    {
        return $this->size[$type] * 1024;
    }

    protected function getBase64max($type)
    {
        $isValid = isset($this->size[$type]);
        return $isValid
            ? '|base64max:' . $this->getSize($type)
            : null;
    }

    protected function getExtensions($type)
    {
        $isValid = isset($this->extensions[$type]);
        return $isValid
            ? '|in:' . $this->extensions[$type]
            : null;
    }

    public function file($type)
    {
        return 'required|base64file' . $this->getBase64max($type);
    }

    public function extension($type)
    {
        return 'required' . $this->getExtensions($type);
    }
}