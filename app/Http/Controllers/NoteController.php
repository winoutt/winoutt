<?php

namespace App\Http\Controllers;

use App\Repositories\NoteRepository;
use App\Services\ResponseService;
use App\Services\ValidatorService;
use Illuminate\Http\Request;
use Throwable;

class NoteController extends Controller
{
    private $noteRepository;

    function __construct()
    {
        $this->noteRepository = new NoteRepository;
    }

    public function list(Request $request)
    {
        $notes = $this->noteRepository->list($request->user);
        return ResponseService::ok($notes);
    }

    public function archived (Request $request)
    {
        $notes = $this->noteRepository->archived($request->user);
        return ResponseService::ok($notes);
    }

    public function create(Request $request)
    {
        ValidatorService::validate($request, [
            'content' => 'nullable|max:1000'
        ]);
        if (ValidatorService::$failed) return ValidatorService::error();
        $note = $this->noteRepository->create(
            $request->user,
            $request->content
        );
        return ResponseService::created($note);
    }

    public function edit(Request $request, $id)
    {
        ValidatorService::validate($request, [
            'content' => 'required|max:1000'
        ]);
        if (ValidatorService::$failed) return ValidatorService::error();
        try {
            $note = $this->noteRepository->edit(
                $request->user,
                $id,
                $request->content
            );
            return ResponseService::ok($note);
        } catch (Throwable $e) {
            return ResponseService::badRequest($e->getMessage());
        }
    }

    public function archive(Request $request, $id)
    {
        try {
            $this->noteRepository->archive($request->user, $id);
            return ResponseService::ok(['isArchived' => true]);
        } catch (Throwable $e) {
            return ResponseService::badRequest($e->getMessage());
        }
    }

    public function unarchive(Request $request, $id)
    {
        try {
            $this->noteRepository->unarchive($request->user, $id);
            return ResponseService::ok(['isUnarchived' => true]);
        } catch (Throwable $e) {
            return ResponseService::badRequest($e->getMessage());
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            $this->noteRepository->forceDeleteFromAll($request->user, $id);
            return ResponseService::ok(['isDeleted' => true]);
        } catch (Throwable $e) {
            return ResponseService::badRequest($e->getMessage());
        }
    }

    public function deleteBlanks(Request $request)
    {
        try {
            $notes = $this->noteRepository
                ->forceDeleteBlanksFromAll($request->user);
            return ResponseService::ok($notes);
        } catch (Throwable $e) {
            return ResponseService::ok([]);
        }
    }
}
