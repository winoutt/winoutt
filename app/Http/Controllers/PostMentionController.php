<?php

namespace App\Http\Controllers;

use App\Repositories\PostMentionRepository;
use App\Services\ResponseService;
use Illuminate\Http\Request;
use Exception;

class PostMentionController extends Controller
{
    private $postMentionRepository;

    function __construct()
    {
        $this->postMentionRepository = new PostMentionRepository;
    }

    public function suggestions (Request $request)
    {
        try {
            $suggestions = $this->postMentionRepository
                ->suggestions($request->user);
            return ResponseService::ok($suggestions);
        } catch (Exception $e) {
            return ResponseService::badRequest($e->getMessage());
        }
    }

    public function searchSuggestions (Request $request)
    {
        try {
            $term = $request->query('term');
            $suggestions = $this->postMentionRepository
                ->searchSuggestions($request->user, $term);
            return ResponseService::ok($suggestions);
        } catch (Exception $e) {
            return ResponseService::badRequest($e->getMessage());
        }
    }
}
