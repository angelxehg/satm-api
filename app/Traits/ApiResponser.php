<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;

trait ApiResponser {

    protected function showOne($element, $message) {
        return response()->json([
            'error' => false,
            'message' => $message, 
            'data' => $element
        ], 200);
    }

    protected function showMany($collection, $message) {
        return response()->json([
            'error' => false,
            'message' => $message,
            'data' => $collection
        ], 200);
    }

    protected function sendToken($token, $me) {
        return response()->json([
            'error' => false,
            'current' => $me,
            'message' => "Sucessful login",
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ], 200);
    }

    protected function sucessResponse($message, $code) {
        return response()->json([
            'error' => false,
            'message' => $message,
        ], $code);
    }

    protected function errorResponse($message, $code) {
        return response()->json([
            'error' => true,
            'message' => $message,
        ], $code);
    }    

    protected function errorDataResponse($message, $data, $code) {
        return response()->json([
            'error' => true,
            'message' => $message,
            'data' => $data
        ], $code);
    }

}