<?php

namespace App\Http\Controllers;

use App\Repositories\CommentVoteRepository;
use App\Services\NotificationService;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use Throwable;

class CommentVoteController extends Controller
{
    private $commentVoteRepository;

    function __construct()
    {
        $this->commentVoteRepository = new CommentVoteRepository;
    }

    public function create(Request $request, $commentId)
    {
        try {
            $comment = $this->commentVoteRepository
                ->attach($request->user, $commentId);
            NotificationService::commentVote($request->user, $comment);
            return ResponseService::created($comment);
        } catch (Throwable $e) {
            return ResponseService::badRequest($e->getMessage());
        }
    }

    public function delete (Request $request, $commentId)
    {
        try {
            $comment = $this->commentVoteRepository
                ->detach($request->user, $commentId);
            return ResponseService::ok($comment);
        } catch (Throwable $e) {
            return ResponseService::badRequest($e->getMessage());
        }
    }
}
