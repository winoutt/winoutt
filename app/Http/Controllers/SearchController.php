<?php

namespace App\Http\Controllers;

use App\Repositories\SearchRepository;
use App\Services\ResponseService;
use App\Services\TokenService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;

class SearchController extends Controller
{
    private $searchRepository;

    function __construct()
    {
        $this->searchRepository = new SearchRepository;
    }

    public function all(Request $request)
    {
        try {
            TokenService::verify($request->bearerToken(), 'auth');
            $request->user = Auth::loginUsingId(TokenService::$data->iss);
            $result = $this->searchRepository
                ->all($request->query('term'), $request->user);
        } catch (Exception $e) {
            try {
                $result = $this->searchRepository
                    ->all($request->query('term'));
            } catch (Throwable $e) {
                return ResponseService::badRequest('Unable to search');
            }
        }
        return ResponseService::ok($result);
    }
}
