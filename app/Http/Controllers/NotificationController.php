<?php

namespace App\Http\Controllers;

use App\Repositories\NotificationRepository;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\Request;
use Throwable;

class NotificationController extends Controller
{
    private $notificationRepository;

    function __construct()
    {
        $this->notificationRepository = new NotificationRepository;
    }

    public function read (Request $request, $id)
    {
        try {
            $notification = $this->notificationRepository
                ->read($request->user, $id);
            return ResponseService::ok($notification);
        } catch (Exception $e) {
            return ResponseService::badRequest($e->getMessage());
        }
    }

    public function paginate(Request $request)
    {
        try {
            $notifications = $this->notificationRepository
                ->paginate($request->user);
            return ResponseService::ok($notifications);
        } catch (Throwable $e) {
            $message = 'Unable to collect notifications';
            return ResponseService::badRequest($message);
        }
    }

    public function markRead(Request $request, $id)
    {
        try {
            $this->notificationRepository->markRead($request->user, $id);
            return ResponseService::ok(['isRead' => true]);
        } catch (Throwable $e) {
            $message = 'Unable to read notification';
            return ResponseService::badRequest($message);
        }
    }

    public function connectionRequests (Request $request)
    {
        try {
            $notifications = $this->notificationRepository
                ->connectionRequests($request->user);
            return ResponseService::ok($notifications);
        } catch (Exception $e) {
            return ResponseService::badRequest($e->getMessage());
        }
    }

    public function unreadsCount (Request $request)
    {
        try {
            $unreadsCount = $this->notificationRepository
                ->unreadsCount($request->user);
            return ResponseService::ok(['unreads_count' => $unreadsCount]);
        } catch (Exception $e) {
            $message = 'Unable to collect unread notifications count';
            return ResponseService::badRequest($message);
        }
    }

    public function markAllRead(Request $request)
    {
        try {
            $this->notificationRepository->markAllRead($request->user);
            return ResponseService::ok(['isRead' => true]);
        } catch (Exception $e) {
            $message = 'Unable to mark all notifications as read';
            return ResponseService::badRequest($message);
        }
    }
}
