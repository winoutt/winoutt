<?php

namespace App\Http\Controllers;

use App\Repositories\StarRepository;
use App\Services\NotificationService;
use App\Services\ResponseService;
use App\Services\ValidatorService;
use Illuminate\Http\Request;
use Throwable;

class StarController extends Controller
{
    private $starRepository;

    function __construct()
    {
        $this->starRepository = new StarRepository;
    }

    public function create(Request $request)
    {
        ValidatorService::validate($request, [
            'postId' => 'required|exists:posts,id'
        ]);
        if (ValidatorService::$failed) return ValidatorService::error();
        try {
            $star = $this->starRepository
                ->create($request->user, $request->postId);
            NotificationService::star($star);
        } catch (Throwable $e) {
            return ResponseService::badRequest($e->getMessage());
        }
        return ResponseService::created(['isStared' => true]);
    }

    public function delete(Request $request, $postId)
    {
        $data = ['postId' => $postId];
        ValidatorService::validate($data, [
            'postId' => 'required|exists:posts,id'
        ]);
        if (ValidatorService::$failed) return ValidatorService::error();
        try {
            $this->starRepository->delete($request->user, $postId);
        } catch (Throwable $e) {
            return ResponseService::badRequest($e->getMessage());
        }
        return ResponseService::ok(['isUnstared' => true]);
    }
}
