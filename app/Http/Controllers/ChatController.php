<?php

namespace App\Http\Controllers;

use App\Events\MessageDelivered;
use App\Events\MessageRead;
use App\Repositories\ChatRepository;
use App\Services\ResponseService;
use Exception;
use Illuminate\Http\Request;
use Throwable;

class ChatController extends Controller
{
    private $chatRepository;

    function __construct()
    {
        $this->chatRepository = new ChatRepository;
    }

    public function archive(Request $request, $id)
    {
        try {
            $this->chatRepository->archive($request->user, $id);
        } catch (Throwable $e) {
            return ResponseService::badRequest('Unable to archive chat');
        }
        return ResponseService::ok(['isArchived' => true]);
    }

    public function unarchive(Request $request, $id)
    {
        try {
            $this->chatRepository->unarchive($request->user, $id);
        } catch (Throwable $e) {
            return ResponseService::badRequest('Unable to unarchive chat');
        }
        return ResponseService::ok(['isUnarchived' => true]);
    }

    public function paginate(Request $request, $page = 1)
    {
        try {
            $chats = $this->chatRepository->paginate($request->user, $page);
        } catch (Throwable $e) {
            return ResponseService::badRequest('Unable to collect chats');
        }
        return ResponseService::ok($chats);
    }

    public function archived(Request $request, $page = 1)
    {
        try {
            $chats = $this->chatRepository->archived($request->user, $page);
        } catch (Throwable $e) {
            return ResponseService::badRequest('Unable to collect chats');
        }
        return ResponseService::ok($chats);
    }

    public function search(Request $request)
    {
        try {
            $chats = $this->chatRepository
                ->search($request->user, $request->query('term'));
        } catch (Throwable $e) {
            return ResponseService::badRequest('Unable to search chats');
        }
        return ResponseService::ok($chats);
    }

    public function read(Request $request, $id)
    {
        try {
            $messages = $this->chatRepository->read($request->user, $id);
            $messages->each(function($message) {
                event(new MessageRead($message));
            });
        } catch (Throwable $e) {
            return ResponseService::badRequest('Unable to read chat');
        }
        return ResponseService::ok(['isRead' => true]);
    }

    public function markDelivered(Request $request)
    {
        try {
            $messages = $this->chatRepository->markDelivered($request->user);
            $messages->each(function($message) {
                event(new MessageDelivered($message));
            });
        } catch (Throwable $e) {
            $message = 'Unable to mark chats delivered';
            return ResponseService::badRequest($message);
        }
        return ResponseService::ok(['isMarkDelivered' => true]);
    }
    
    public function readFromUser(Request $request, $id)
    {
        try {
            $chat = $this->chatRepository->getFromUser($request->user, $id);
            return ResponseService::ok($chat);
        } catch (Exception $e) {
            return ResponseService::badRequest($e->getMessage());
        }
    }
}
