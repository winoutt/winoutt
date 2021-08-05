<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\File as FileInfo;
use Illuminate\Http\UploadedFile;

class File
{
    protected $uri;
    protected $extension;
    protected $directory;

    function __construct($uri, $extension, $directory)
    {
        $this->uri = $uri;
        $this->extension = $extension;
        $this->directory = $directory;
    }

    public static function getUploadedFile($uri)
    {
        if (strpos($uri, ';base64') !== false) {
            [, $uri] = explode(';', $uri);
            [, $uri] = explode(',', $uri);
        }
        $binaryData = base64_decode($uri);
        $tmpFile = tempnam(sys_get_temp_dir(), 'WU');
        file_put_contents($tmpFile, $binaryData);
        $fileinfo = new FileInfo($tmpFile);
        $uploadedFile = new UploadedFile(
            $fileinfo->getPathname(),
            $fileinfo->getFilename(),
            $fileinfo->getMimeType(),
            null,
            false
        );
        return UploadedFile::createFromBase($uploadedFile);
    }

    protected function getFile()
    {
        return file_get_contents($this->uri, true);
    }

    protected function getPath()
    {
        return $this->directory . '/' . Str::uuid() . '.' . $this->extension;
    }

    public function store()
    {
        $path = $this->getPath();
        Storage::disk('s3')->put($path, $this->getFile(), 'public');
        return Storage::disk('s3')->url($path);
    }
}