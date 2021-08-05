<?php

namespace App\Services;
use Exception;
use Firebase\JWT\JWT;
use Illuminate\Support\Carbon;

class TokenService
{
    public static $data = null;

    public static function create($subject, $issuer)
    {
        $payload = [
            'sub' => $subject,
            'iss' => $issuer,
            'iat' => Carbon::now()->timestamp
        ];
        return JWT::encode($payload, config('app.key'));
    }

    public static function verify($token, $subject, $issuer = null)
    {
        try {
            $data = JWT::decode($token, config('app.key'), ['HS256']);
            $validSubject = ($data->sub === $subject);
            $validIssuer = ($issuer ? ($data->iss === $issuer) : true);
            $isValid = $validSubject && $validIssuer;
            if ($isValid) self::$data = $data;
            else throw new Exception('Invalid token');
        } catch (Exception $exc) {
            throw new Exception('Invalid token');
        }
    }
}