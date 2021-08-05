<?php

namespace App\Http\Controllers;

use App\Repositories\UnfollowRepository;
use Illuminate\Http\Request;
use App\Services\ResponseService;
use App\Services\ValidatorService;
use Throwable;

class UnfollowController extends Controller
{
    private $unfollowRepository;

    function __construct()
    {
        $this->unfollowRepository = new UnfollowRepository;
    }

    public function create(Request $request)
    {
        ValidatorService::validate($request, [
            'connectionId' => 'required|exists:users,id'
        ]);
        if (ValidatorService::$failed) return ValidatorService::error();
        try {
            $this->unfollowRepository->unfollow(
                $request->user,
                $request->connectionId
            );
            return ResponseService::ok(['isUnfollowed' => true]);
        } catch (Throwable $e) {
            return ResponseService::badRequest($e->getMessage());
        }
    }

    public function delete(Request $request, $connectionId)
    {
        try {
            $this->unfollowRepository->follow($request->user, $connectionId);
            return ResponseService::ok(['isFollowed' => true]);
        } catch (Throwable $e) {
            return ResponseService::badRequest($e->getMessage());
        }
    }
}
