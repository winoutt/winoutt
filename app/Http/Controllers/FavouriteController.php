<?php

namespace App\Http\Controllers;

use App\Repositories\FavouriteRepository;
use App\Services\ResponseService;
use App\Services\ValidatorService;
use Illuminate\Http\Request;
use Throwable;

class FavouriteController extends Controller
{
    private $favouriteRepository;

    function __construct()
    {
        $this->favouriteRepository = new FavouriteRepository;
    }

    public function create(Request $request)
    {
        ValidatorService::validate($request, [
            'postId' => 'required|exists:posts,id'
        ]);
        if (ValidatorService::$failed) return ValidatorService::error();
        try {
            $this->favouriteRepository
                ->create($request->user, $request->postId);
        } catch (Throwable $e) {
            return ResponseService::badRequest($e->getMessage());
        }
        return ResponseService::ok(['isFavourited' => true]);
    }

    public function paginate(Request $request)
    {
        $favourites = $this->favouriteRepository->paginate($request->user);
        return ResponseService::ok($favourites);
    }

    public function delete (Request $request, $id)
    {
        try {
            $this->favouriteRepository->delete($request->user, $id);
            return ResponseService::ok(['isDeleted' => true]);
        } catch (Throwable $e) {
            return ResponseService::badRequest($e->getMessage());
        }
    }
}
