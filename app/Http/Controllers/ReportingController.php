<?php

namespace App\Http\Controllers;

use App\Events\ReportingCreated;
use App\Reporting;
use App\Repositories\ReportingRepository;
use App\Services\ResponseService;
use App\Services\ValidatorService;
use Illuminate\Http\Request;
use Throwable;

class ReportingController extends Controller
{
    private $reportingRepository;

    function __construct()
    {
        $this->reportingRepository = new ReportingRepository;
    }

    public function create(Request $request)
    {
        $validCategories = ($request->type === 'user') ?
            collect(Reporting::$categories)->implode(',') :
            collect(Reporting::$categories)
                ->reject('mimic')
                ->reject('fake')
                ->implode(',');
        ValidatorService::validate($request, [
            'id' => 'required|integer',
            'type' => 'required|in:' . collect(Reporting::$types)->implode(','),
            'category' => 'required|in:' . $validCategories,
            'message' => 'required|string|max:500'
        ]);
        if (ValidatorService::$failed) return ValidatorService::error();
        try {
            $reporting = $this->reportingRepository
                ->create($request->user, ValidatorService::$data);
        } catch (Throwable $e) {
            return ResponseService::badRequest('Unable to report');
        }
        event(new ReportingCreated($reporting));
        return ResponseService::created(['isCreated' => true]);
    }
}
