<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;


class ResponseFormatter extends Controller
{
    private static $response = [
        "meta" => [
            "status" => null,
            "code" => null,
            "message" => null
        ]
    ];

    public static function success($message, $data = [])
    {
        self::$response['meta']['status'] = 'success!';
        self::$response['meta']['code'] = 200;
        self::$response['meta']['message'] = $message;
        self::$response['data'] = $data;

        return response()->json(self::$response);
    }

    public static function failed($message, $code = 500, $errors = [])
    {
        self::$response['meta']['status'] = 'failed!';
        self::$response['meta']['code'] = $code;
        self::$response['meta']['message'] = $message;
        self::$response['errors'] = $errors;

        return response()->json(self::$response);
    }
}
