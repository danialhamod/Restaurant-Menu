<?php

namespace App\Traits;

use App\Http\Responses\ApiCode;

Trait WrapsApiResponse
{
    /**
     * @param array $content
     * @return \Illuminate\Http\JsonResponse
     */
    public static function respondSuccess($content = null)
    {
        return response()->json([
            'result' => 'success',
            'content' => $content,
            'error_description' => '',
            'error_code' => 0
        ]);
    }

    public static function respondValidationError($validator)
    {
        return self::respondError($validator->errors()->all(), ApiCode::ValidationError);
    }

    public static function respondError($message, $code = 400)
    {
        return response()->json([
            'result' => 'error',
            'content' => null,
            'error_description' => is_array($message) ? $message : [$message],
            'error_code' => $code
        ], $code);
    }

    public static function respondOut($message)
    {
        return response()->json([
            'result' => 'error',
            'content' => null,
            'error_description' => is_array($message) ? $message : [$message],
            'error_code' => -1
        ]);
    }
}
