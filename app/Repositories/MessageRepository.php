<?php

namespace App\Repositories;

use App\Message;
use App\User;
use Exception;

class MessageRepository
{
    private $chatRepository;

    function __construct()
    {
        $this->chatRepository = new ChatRepository;
    }

    public function read (User $user, $id)
    {
        $message = Message::find($id);
        if (!$message) throw new Exception('Message not found');
        $isUser = collect([$message->chat->sentUser->id, $message->chat->receivedUser->id])
            ->contains($user->id);
        if (!$isUser) {
            $message = 'You don\'t have permission to access this message';
            throw new Exception($message);
        }
        return $message;
    }

    public function create(User $user, $data)
    {
        $isExistsChat = $this->chatRepository->isExists($user, $data->chatId);
        if (!$isExistsChat) throw new Exception('Chat not found');
        $message = $user->messages()->create([
            'chat_id' => $data->chatId,
            'type' => $data->type,
            'content' => $data->type === 'text' ? $data->message : $data->file,
            'photo_original' => ($data->type === 'image')
                ? $data->photo_original
                : null,
            'filename' => $data->type === 'text' ? null : $data->filename,
            'status' => 'sent'
        ]);
        $message->chat->lastMessage()->sync($message);
        $user->chatArchives()->detach($message->chat);
        $receiveUser = $this->receiveUser($message);
        $receiveUser->chatArchives()->detach($message->chat);
        return $message;
    }

    public function paginate(User $user, $chatId)
    {
        $isExistsChat = $this->chatRepository->isExists($user, $chatId);
        if (!$isExistsChat) throw new Exception('Chat not found');
        return Message::where('chat_id', $chatId)
            ->orderByDesc('id')
            ->paginate();
    }

    public function receiveUser(Message $message)
    {
        $chat = $message->chat;
        $isUserCreatedChat = ($chat->user_id === $message->user_id);
        $userId = $isUserCreatedChat ? $chat->connection_id : $chat->user_id;
        return User::find($userId);
    }

    public function unreadsCount(User $user)
    {
        $sentChats = $user->sentChats()->pluck('chats.id');
        $receivedChats = $user->receivedChats()->pluck('chats.id');
        $archivedChats = $user->chatArchives()->pluck('chats.id');
        $allChats = $sentChats->merge($receivedChats);
        $chats = $allChats->diff($archivedChats);
        $sentMessages = $user->messages()
            ->whereIn('chat_id', $chats)
            ->pluck('id');
        $unreadMessages = Message::whereIn('chat_id', $chats)
            ->whereNotIn('id', $sentMessages)
            ->whereIn('status', ['delivered', 'sent']);
        return $unreadMessages->count();
    }

    public function createLinkPreview (Message $message, $preview)
    {
        $message->linkPreview()->create([
            'title' => $preview->title,
            'description' => $preview->description,
            'url' => $preview->url,
            'image' => $preview->image
        ]);
        return Message::findOrFail($message->id);
    }
}