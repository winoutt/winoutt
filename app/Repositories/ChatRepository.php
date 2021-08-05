<?php

namespace App\Repositories;

use App\Chat;
use App\Message;
use App\User;
use Carbon\Carbon;
use Exception;
use Fuse\Fuse;

class ChatRepository
{
    public function isExists(User $user, $id)
    {
        $sentChat = $user->sentChats()
            ->wherePivot('id', $id)
            ->exists();
        $receivedChat = $user->receivedChats()
            ->wherePivot('id', $id)
            ->exists();
        return $sentChat || $receivedChat;
    }

    private function withPivoteAttributes($chat)
    {
        $pivot = Chat::find($chat->pivot->id);
        $chat->unreads_count = $pivot->unreads_count;
        $chat->last_message = $pivot->last_message;
        $chat->is_archived = $pivot->is_archived;
        return $chat;
    }

    private function sortByLastMessageCreatedAt($chats)
    {
        $sorted = $chats->sortByDesc(function($chat) {
            $chat = $this->withPivoteAttributes($chat);
            return $chat->last_message
                ? $chat->last_message->created_at
                : Carbon::now();
        });
        return $sorted->reject(function ($chat) {
            return empty($chat->last_message);
        });
    }

    public function archive(User $user, $id)
    {
        $chat = Chat::findOrFail($id);
        $isChatExists = $this->isExists($user, $chat->id);
        if (!$isChatExists) throw new Exception('Chat not found');
        $isArchived = $user->chatArchives()->whereChatId($chat->id)->exists();
        if ($isArchived) throw new Exception('Already archived');
        $user->chatArchives()->attach($chat);
    }

    public function unarchive(User $user, $id)
    {
        $chat = Chat::findOrFail($id);
        $isChatExists = $this->isExists($user, $chat->id);
        if (!$isChatExists) throw new Exception('Chat not found');
        $isArchived = $user->chatArchives()->whereChatId($chat->id)->exists();
        if (!$isArchived) throw new Exception('Already unarchived');
        $user->chatArchives()->detach($chat);
    }

    public function paginate(User $user, $page)
    {
        $archivedChatIds = $user->chatArchives()->pluck('chats.id');
        $sent = $user->sentChats()
            ->wherePivotNotIn('id', $archivedChatIds)
            ->get();
        $received = $user->receivedChats()
            ->wherePivotNotIn('id', $archivedChatIds)
            ->get();
        $chats = $sent->merge($received);
        $data = $this->sortByLastMessageCreatedAt($chats)
        ->forPage($page, 20)
        ->values();
        $nextPageUrl = $data->isEmpty() ? null : url('api/chats/paginate/' . ++$page);
        return ['data' => $data, 'next_page_url' => $nextPageUrl];
    }

    public function archived(User $user, $page)
    {
        $archivedChatIds = $user->chatArchives()->pluck('chats.id');
        $sent = $user->sentChats()
            ->wherePivotIn('id', $archivedChatIds)
            ->get();
        $received = $user->receivedChats()
            ->wherePivotIn('id', $archivedChatIds)
            ->get();
        $chats = $sent->merge($received);
        $data = $this->sortByLastMessageCreatedAt($chats)
        ->forPage($page, 20)
        ->values();
        $nextPageUrl = $data->isEmpty() ? null : url('api/chats/archived/' . ++$page);
        return ['data' => $data, 'next_page_url' => $nextPageUrl];
    }

    public function search(User $user, $term)
    {
        $archivedChatIds = $user->chatArchives()->pluck('chats.id');
        $sent = $user->sentChats()
            ->wherePivotNotIn('id', $archivedChatIds)
            ->get();
        $received = $user->receivedChats()
            ->wherePivotNotIn('id', $archivedChatIds)
            ->get();
        $chats = $sent->merge($received);
        $chats = $this->sortByLastMessageCreatedAt($chats)
        ->values()
        ->toArray();
        if (!$term || !$chats) return $chats;
        $fuzzy = new Fuse($chats, [
            'keys' => ['first_name', 'last_name', 'last_message.content']
        ]);
        return $fuzzy->search($term);
    }

    public function read(User $user, $id)
    {
        $chat = Chat::findOrFail($id);
        $isUserChat = collect([$chat->user_id, $chat->connection_id])
            ->contains($user->id);
        if (!$isUserChat) throw new Exception('You can\'t read this chat');
        $messages = $chat->messages()
            ->where('user_id', '!=', $user->id)
            ->whereIn('status', ['sent', 'delivered']);
        $unreadMessags = $messages->get();
        $messages->update(['status' => 'read']);
        return $unreadMessags;
    }

    public function markDelivered(User $user)
    {
        $sent = $user->sentChats()->pluck('chats.id');
        $received = $user->receivedChats()->pluck('chats.id');
        $chats = $sent->merge($received);
        $messages = Message::whereIn('chat_id', $chats)
            ->where('user_id', '!=', $user->id)
            ->whereStatus('sent');
        $updatedMessages = $messages->get();
        $messages->update(['status' => 'delivered']);
        return $updatedMessages;
    }

    public function getFromUser(User $user, $id)
    {
        $sent = $user->sentChats()->where('users.id', $id)->first();
        $received = $user->receivedChats()->where('users.id', $id)->first();
        $chat = $sent ? $sent : $received;
        if (!$chat) throw new Exception('Chat not found');
        $chat = $this->withPivoteAttributes($chat);
        return $chat;
    }
}