<?php

namespace App\Http\Controllers;

use App\Repositories\HashtagRepository;
use App\Services\ResponseService;
use Throwable;

class HashtagController extends Controller
{
    private $hashtagRepository;

    function __construct()
    {
        $this->hashtagRepository = new HashtagRepository;
    }

    public function trending()
    {
        $trending = $this->hashtagRepository->trending();
        return ResponseService::ok($trending);
    }

    public function posts($hashtag)
    {
        try {
            $posts = $this->hashtagRepository->posts($hashtag);
            return ResponseService::ok($posts);
        } catch (Throwable $e) {
            return ResponseService::notFound('Unable to collect posts');
        }
    }
}
