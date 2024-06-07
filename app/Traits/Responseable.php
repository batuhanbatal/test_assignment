<?php

namespace App\Traits;

trait Responseable
{
    public static function success($data = null, $message = null)
    {
        $response = [
            'success' => true,
            'code' => 200,
            'message' => $message,
            'data' => $data,
        ];

        return response()->json($response, $response['code']);
    }

    public static function error($message = null, $errors = null, $code = 404)
    {
        $response = [
            'success' => false,
            'code' => $code,
            'message' => $message,
            'errors' => $errors
        ];

        return response()->json($response, $response['code']);
    }
}
