<?php

namespace App\Http\Controllers;

use App\Services\ResponseService;
use App\Repositories\TeamRepository;
use Illuminate\Http\Request;
use Throwable;

class TeamController extends Controller
{
    private $teamRepository;

    function __construct()
    {
        $this->teamRepository = new TeamRepository;
    }

    public function list()
    {
        $teams = $this->teamRepository->list();
        return ResponseService::ok($teams);
    }

    public function top()
    {
        $topPosts = $this->teamRepository->top();
        return ResponseService::ok($topPosts);
    }

    public function read($slug)
    {
        try {
            $team = $this->teamRepository->read($slug);
            return ResponseService::ok($team);
        } catch (Throwable $e) {
            return ResponseService::notFound('Unable to collect team');
        }
    }

    public function contributors(Request $request, $id)
    {
        try {
            $contributors = $this->teamRepository->contributors($id);
            return ResponseService::ok($contributors);
        } catch (Throwable $e) {
            $message = 'Unable to collect team contributors';
            return ResponseService::badRequest($message);
        }
    }

    public function posts($id)
    {
        try {
            $posts = $this->teamRepository->posts($id);
            return ResponseService::ok($posts);
        } catch (Throwable $e) {
            return ResponseService::badRequest('Unable to collect posts');
        }
    }
}
