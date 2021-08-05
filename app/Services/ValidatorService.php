<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ValidatorService
{
    private static $message;
    public static $failed = false;
    public static $data;

    public static function validate($data, $schema, $messages = [])
    {
        $data = $data instanceof Request ? $data->all() : $data;
        $validator = Validator::make($data, $schema, $messages);
        if ($validator->fails()) {
            self::$failed = true;
            self::$message = $validator->errors()->first();
        } else {
            self::$data = json_decode(json_encode($data));
        }
    }

    public static function error()
    {
        self::replaceAttributes();
        return ResponseService::unprocessable(self::$message);
    }

    private static function replaceAttributes()
    {
        $validation = include(resource_path('/lang/en/validation.php'));
        $attributes = collect($validation['attributes']);
        $attributes->each(function($value, $key) {
            $isReplasable = Str::contains(self::$message, $key);
            self::$message = str_replace($key, $value, self::$message);
            if ($isReplasable) return false;
        });
    }
}