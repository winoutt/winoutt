<?php

namespace App\Http\Controllers;

use App\Repositories\CommentMentionRepository;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\Request;

class CommentMentionController extends Controller
{
    private $commentMentionRepository;

    function __construct()
    {
        $this->commentMentionRepository = new CommentMentionRepository;
    }

    public function suggestions (Request $request)
    {
        try {
            $postId = $request->query('post');
            $suggestions = $this->commentMentionRepository
                ->suggestions($request->user, $postId);
            return ResponseService::ok($suggestions);
        } catch (Exception $e) {
            return ResponseService::badRequest($e->getMessage());
        }
    }

    public function searchSuggestions (Request $request)
    {
        try {
            $postId = $request->query('post');
            $term = $request->query('term');
            $suggestions = $this->commentMentionRepository
                ->searchSuggestions($request->user, $postId, $term);
            return ResponseService::ok($suggestions);
        } catch (Exception $e) {
            return ResponseService::badRequest($e->getMessage());
        }
    }
}
