<?php

namespace App\Http\Controllers;

use App\Repositories\PeopleRepository;
use App\Services\ResponseService;
use Illuminate\Http\Request;

class PeopleController extends Controller
{
    private $peopleRepository;

    function __construct()
    {
        $this->peopleRepository = new PeopleRepository;
    }

    public function paginate(Request $request, $page = 1)
    {
        $peoples = $this->peopleRepository
            ->mayknowPaginate($request->user, $page);
        return ResponseService::ok($peoples);
    }

    public function mayknow(Request $request)
    {
        $connections = $this->peopleRepository->mayknow($request->user, 5);
        return ResponseService::ok($connections);
    }

    public function search(Request $request)
    {
        $peoples = $this->peopleRepository->search($request->query('term'));
        return ResponseService::ok($peoples);
    }
}
