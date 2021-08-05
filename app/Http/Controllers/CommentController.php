<?php

namespace App\Http\Controllers;

use App\Repositories\CommentHashtagRepository;
use App\Repositories\CommentMentionRepository;
use App\Repositories\CommentRepository;
use App\Services\NotificationService;
use App\Services\ResponseService;
use App\Services\ValidatorService;
use Illuminate\Http\Request;
use Throwable;

class CommentController extends Controller
{
    private $commentRepository;
    private $commentMentionRepository;
    private $commentHashtagRepository;

    function __construct()
    {
        $this->commentRepository = new CommentRepository;
        $this->commentMentionRepository = new CommentMentionRepository;
        $this->commentHashtagRepository = new CommentHashtagRepository;
    }

    public function create(Request $request)
    {
        ValidatorService::validate($request, [
            'postId' => 'required|exists:posts,id',
            'content' => 'required|string|max:500'
        ]);
        if (ValidatorService::$failed) return ValidatorService::error();
        try {
            $comment = $this->commentRepository
                ->create($request->user, ValidatorService::$data);
            $commentMentions = $this->commentMentionRepository
                ->create($comment);
            $this->commentHashtagRepository->create($comment);
            $commentMentions->each(function($commentMention) {
                NotificationService::commentMention($commentMention);
            });
            NotificationService::comment($comment);
            NotificationService::commentStarredPost($comment);
            NotificationService::commentCommentedPost($comment);
        } catch (Throwable $e) {
            return ResponseService::badRequest('Unable to create comment');
        }
        return ResponseService::created($comment);
    }

    public function paginate(Request $request, $postId)
    {
        if (ValidatorService::$failed) return ValidatorService::error();
        try {
            $comments = $this->commentRepository->paginate($postId);
        } catch (Throwable $e) {
            return ResponseService::badRequest('Unable to collect comments');
        }
        return ResponseService::ok($comments);
    }

    public function delete(Request $request, $id)
    {
        try {
            $this->commentRepository->delete($request->user, $id);
        } catch (\Throwable $th) {
            return ResponseService::badRequest('Unable to delete comment');
        }
        return ResponseService::ok(['isDeleted' => true]);
    }
}
