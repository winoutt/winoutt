<?php

namespace App\Http\Controllers;

use App\Repositories\UserStatusRepository;
use App\Services\ResponseService;
use App\Services\ValidatorService;
use Illuminate\Http\Request;
use Throwable;

class UserStatusController extends Controller
{
    private $userStatusRepository;

    function __construct()
    {
        $this->userStatusRepository = new UserStatusRepository;
    }

    public function update(Request $request)
    {
        $beaconRequest = (array) json_decode($request->getContent());
        ValidatorService::validate($beaconRequest, [
            'is_online' => 'required|boolean'
        ]);
        if (ValidatorService::$failed) return ValidatorService::error();
        try {
            $user = $this->userStatusRepository
                ->update($request->user, $beaconRequest['is_online']);
            return ResponseService::ok($user);
        } catch (Throwable $e) {
            return ResponseService::badRequest($e->getMessage());
        }
    }
}
