<?php

namespace App\Http\Controllers;

use App\Repositories\SettingsRepository;
use App\Services\ResponseService;
use App\Services\ValidatorService;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    private $settingsRepository;

    function __construct()
    {
        $this->settingsRepository = new SettingsRepository;
    }

    public function update(Request $request)
    {
        ValidatorService::validate($request, [
            'is_dark_mode' => 'required|boolean',
            'enabled_notification' => 'required|boolean'
        ]);
        if (ValidatorService::$failed) return ValidatorService::error();
        $settings = $this->settingsRepository->update(
            $request->user,
            ValidatorService::$data
        );
        return ResponseService::ok($settings);
    }
}
