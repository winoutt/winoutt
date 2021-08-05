<?php

namespace App\Services;
use Illuminate\Support\Str;

class ResponseService
{
    private static function response($payload, $status)
    {
        return response()->json($payload, $status);
    }

    private static function error($message, $status)
    {
        $error = [
            'message' => $message,
            'code' => Str::snake($message),
            'status' => $status
        ];
        return self::response($error, $status);
    }

    public static function ok($payload)
    {
        return self::response($payload, 200);
    }

    public static function created($payload)
    {
        return self::response($payload, 201);
    }

    public static function badRequest($message)
    {
        return self::error($message, 400);
    }

    public static function unauthorized($message)
    {
        return self::error($message, 401);
    }

    public static function forbidden($message)
    {
        return self::error($message, 403);
    }

    public static function notFound($message)
    {
        return self::error($message, 404);
    }

    public static function unprocessable($message)
    {
        return self::error($message, 422);
    }

    public static function serviceUnavailable($message)
    {
        return self::error($message, 503);
    }
}