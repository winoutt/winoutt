<?php

namespace App\Http\Controllers;

use App\Repositories\PostUnfollowRepository;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\Request;

class PostUnfollowController extends Controller
{
    private $postUnfollowRepository;

    function __construct()
    {
        $this->postUnfollowRepository = new PostUnfollowRepository;
    }

    public function create (Request $request, $postId)
    {
        try {
            $post = $this->postUnfollowRepository
                ->attach($request->user, $postId);
            return ResponseService::created($post);
        } catch (Exception $e) {
            return ResponseService::badRequest($e->getMessage());
        }
    }

    public function delete (Request $request, $postId)
    {
        try {
            $post = $this->postUnfollowRepository
                ->detach($request->user, $postId);
            return ResponseService::created($post);
        } catch (Exception $e) {
            return ResponseService::badRequest($e->getMessage());
        }
    }
}
