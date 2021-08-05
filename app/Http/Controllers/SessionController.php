<?php

namespace App\Http\Controllers;

use App\Repositories\SessionRepository;
use App\Services\ResponseService;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    private $sessionRepository;

    function __construct()
    {
        $this->sessionRepository = new SessionRepository;
    }

    public function update(Request $request)
    {
        $this->sessionRepository->update($request->user);
        return ResponseService::ok(['isUpdated' => true]);
    }
}
