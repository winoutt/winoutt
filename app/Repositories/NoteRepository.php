<?php

namespace App\Repositories;

use App\User;
use Exception;

class NoteRepository
{
    public function list(User $user)
    {
        return $user->notes()->orderByDesc('id')->get();
    }

    public function archived (User $user)
    {
        return $user->notes()->onlyTrashed()->orderByDesc('id')->get();
    }

    public function create(User $user, $content)
    {
        $note = ['content' => $content];
        return $user->notes()->create($note);
    }

    public function edit(User $user, $id, $content)
    {
        $note = $user->notes()->find($id);
        if (!$note) {
            throw new Exception('Unable to update the note');
        }
        $note->content = $content;
        $note->save();
        return $note;
    }

    public function archive(User $user, $id)
    {
        $note = $user->notes()->find($id);
        if (!$note) {
            throw new Exception('Unable to archive the note');
        }
        $note->delete();
    }

    public function unarchive(User $user, $id)
    {
        $note = $user->notes()->onlyTrashed()->find($id);
        if (!$note) {
            throw new Exception('Unable to unarchive the note');
        }
        $note->restore();
    }

    public function forceDeleteFromAll(User $user, $id)
    {
        $note = $user->notes()->withTrashed()->find($id);
        if (!$note) throw new Exception('Note not found');
        $note->forceDelete($id);
        return $note;
    }

    public function forceDeleteBlanksFromAll(User $user)
    {
        $notes = $user->notes()->withTrashed()->where('content', null)->get();
        if (!$notes) throw new Exception('No blank notes found');
        $notes->each(function($note) {
            $note->forceDelete();
        });
        return $notes;
    }
}