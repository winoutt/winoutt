<?php

namespace App\Http\Controllers;

use App\Repositories\PollVoteRepository;
use App\Services\ResponseService;
use App\Services\ValidatorService;
use Illuminate\Http\Request;
use Throwable;

class PollVoteController extends Controller
{
    private $pollVoteRepository;

    function __construct()
    {
        $this->pollVoteRepository = new PollVoteRepository;
    }

    public function create(Request $request)
    {
        ValidatorService::validate($request, [
            'poll_id' => 'required|exists:polls,id',
            'choice_id' => 'required|exists:poll_choices,id'
        ]);
        if (ValidatorService::$failed) return ValidatorService::error();
        try {
            $post = $this->pollVoteRepository
                ->create($request->user, ValidatorService::$data);
            return ResponseService::created($post);
        } catch (Throwable $e) {
            return ResponseService::badRequest($e->getMessage());
        }
    }
}
