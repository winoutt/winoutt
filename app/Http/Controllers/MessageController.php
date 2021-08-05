<?php

namespace App\Http\Controllers;

use App\Events\MessageCreated;
use App\Message;
use App\Repositories\MessageRepository;
use App\Services\File\MessageFile;
use App\Services\ImageResize;
use App\Services\MediaValidateRule;
use App\Services\OpenGraph;
use App\Services\ResponseService;
use App\Services\ValidatorService;
use Exception;
use Illuminate\Http\Request;
use Throwable;

class MessageController extends Controller
{
    private $messageRepository;
    private $mediaValidateRule;

    function __construct()
    {
        $this->messageRepository = new MessageRepository;
        $this->mediaValidateRule = new MediaValidateRule;
    }

    public function read (Request $request, $id)
    {
        try {
            $message = $this->messageRepository->read($request->user, $id);
            return ResponseService::ok($message);
        } catch (Exception $e) {
            return ResponseService::badRequest($e->getMessage());
        }
    }

    public function create(Request $request)
    {
        ValidatorService::validate($request, [
            'chatId' => 'required|exists:chats,id',
            'type' => 'required|in:' . implode(',', Message::$types)
        ]);
        if (ValidatorService::$failed) return ValidatorService::error();
        if ($request->type === 'text') {
            ValidatorService::validate($request, [
                'message' => 'required|string|max:1000'
            ]);
            if (ValidatorService::$failed) return ValidatorService::error();
        } else {
            ValidatorService::validate($request, [
                'file' => $this->mediaValidateRule->file($request->type),
                'filename' => 'required',
                'extension' => $this->mediaValidateRule->extension($request->type),
            ]);
            if (ValidatorService::$failed) return ValidatorService::error();
        }
        $data = (object) $request->all();
        $isFile = $request->type !== 'text';
        function store ($user, $uri, $extension) {
            $media = new MessageFile($user, $uri, $extension);
            return $media->store();
        }
        if ($isFile) {
            try {
                if ($request->type === 'image') {
                    $imageResize = new ImageResize($request->file);
                    $data->file = store(
                        $request->user,
                        $imageResize->message(),
                        $request->extension
                    );
                    $data->photo_original = store(
                        $request->user,
                        $imageResize->compress(),
                        $request->extension
                    );
                } else {
                    $data->file = store(
                        $request->user,
                        $request->file,
                        $request->extension
                    );
                }
            } catch (Throwable $e) {
                return ResponseService::badRequest('Unable to store file');
            }
        }
        try {
            $message = $this->messageRepository->create($request->user, $data);
            $openGraph = new OpenGraph($message->content);
            $linkPreview = $openGraph->fetch();
            if ($linkPreview) {
                $message = $this->messageRepository
                    ->createLinkPreview($message, $linkPreview);
            }
            event(new MessageCreated($message));
            return ResponseService::created($message);
        } catch (Throwable $e) {
            return ResponseService::badRequest('Unable to send message');
        }
    }

    public function paginate(Request $request, $chatId)
    {
        try {
            $messages = $this->messageRepository
                ->paginate($request->user, $chatId);
        } catch (Throwable $e) {
            return ResponseService::badRequest('Unable to collect messages');
        }
        return ResponseService::ok($messages);
    }

    public function unreadsCount (Request $request)
    {
        try {
            $count = $this->messageRepository->unreadsCount($request->user);
            return ResponseService::ok([ 'unreads_count' => $count ]);
        } catch (Throwable $e) {
            $message = 'Unable to collect unread messages count';
            return ResponseService::badRequest($message);
        }
    }
}
