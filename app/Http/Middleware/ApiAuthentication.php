<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Services\ResponseService;
use App\Services\TokenService;
use Throwable;
use Illuminate\Support\Str;

class ApiAuthentication
{
    private function unautherize()
    {
        $message = 'Unauthorized access';
        return ResponseService::unauthorized($message);
    }

    public function handle($request, Closure $next) {
        try {
            $bearerToken = $request->bearerToken();
            $beaconRequest = json_decode($request->getContent());
            if (!$bearerToken && $beaconRequest) {
                $authorization = $beaconRequest->authorization;
                $bearerToken = Str::replaceFirst('Bearer ', '', $authorization);
            }
            TokenService::verify($bearerToken, 'auth');
        } catch (Throwable $e) {
            return $this->unautherize();
        }
        $request->user = Auth::loginUsingId(TokenService::$data->iss);
        if (!$request->user) return $this->unautherize();
        return $next($request);
    }
}
