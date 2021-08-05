<?php

namespace App\Http\Middleware;

use App\Services\TokenService;
use Closure;
use Exception;
use Illuminate\Support\Facades\Auth;

class UserAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            TokenService::verify($request->bearerToken(), 'auth');
            $request->user = Auth::loginUsingId(TokenService::$data->iss);
            return $next($request);
        } catch (Exception $e) {
            return $next($request);
        }
    }
}
