<?php

namespace App\Http\Controllers;

use App\Repositories\PostStarRepository;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use Throwable;

class PostStarController extends Controller
{
    private $postStarRepository;

    function __construct()
    {
        $this->postStarRepository = new PostStarRepository;
    }

    public function paginate(Request $request, $postId)
    {
        try {
            $stars = $this->postStarRepository
                ->paginate($request->user, $postId);
            return ResponseService::ok($stars);
        } catch (Throwable $e) {
            return ResponseService::badRequest($e->getMessage());
        }
    }
}
