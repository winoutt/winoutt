<?php

namespace App\Http\Controllers;

use App\Repositories\ConnectionRepository;
use App\Services\NotificationService;
use App\Services\ResponseService;
use App\Services\ValidatorService;
use Exception;
use Illuminate\Http\Request;
use Throwable;

class ConnectionController extends Controller
{
    private $connectionRepository;

    function __construct()
    {
        $this->connectionRepository = new ConnectionRepository;
    }

    public function list (Request $request, $id)
    {
        try {
            $page = $request->query('page');
            $connections = $this->connectionRepository
                ->activeConnectionsPaginate($id, $page);
            return ResponseService::ok($connections);
        } catch (Exception $e) {
            return ResponseService::badRequest($e->getMessage());
        }
    }

    public function create(Request $request)
    {
        ValidatorService::validate($request, [
            'userId' => 'required|integer|exists:users,id',
            'message' => 'nullable'
        ]);
        if (ValidatorService::$failed) return ValidatorService::error();
        try {
            $receiver = $this->connectionRepository
                ->create($request->user, ValidatorService::$data);
            NotificationService::connectionRequest($request->user, $receiver);
        } catch (Throwable $e) {
            return ResponseService::badRequest($e->getMessage());
        }
        return ResponseService::created(['isRequested' => true]);
    }

    public function accept(Request $request, $id)
    {
        try {
            $requester = $this->connectionRepository
                ->accept($request->user, $id);
            NotificationService::connectionAccept($request->user, $requester);
        } catch (Throwable $e) {
            return ResponseService::badRequest($e->getMessage());
        }
        return ResponseService::ok(['isAccepted' => true]);
    }

    public function ignore(Request $request, $id)
    {
        try {
            $this->connectionRepository->ignore($request->user, $id);
        } catch (Throwable $e) {
            return ResponseService::badRequest($e->getMessage());
        }
        return ResponseService::ok(['isIgnored' => true]);
    }

    public function mutuals(Request $request, $id)
    {
        try {
            $mutuals = $this->connectionRepository
                ->mutualsPaginate($request->user, $id, $request->query('page'));
            return ResponseService::ok($mutuals);
        } catch (Throwable $e) {
            $message = 'Unable to find mutual connections';
            return ResponseService::badRequest($message);
        }
    }

    public function disconnect(Request $request, $id)
    {
        try {
            $this->connectionRepository->disconnect($request->user, $id);
            return ResponseService::ok(['isDisconnected' => true]);
        } catch (Throwable $e) {
            return ResponseService::badRequest('Unable to disconnect');
        }
    }

    public function cancel(Request $request, $id)
    {
        try {
            $this->connectionRepository->cancel($request->user, $id);
        } catch (Throwable $e) {
            $message = 'Unable to cancel the connection request';
            return ResponseService::badRequest($message);
        }
        return ResponseService::ok(['isCanceled' => true]);
    }
}
