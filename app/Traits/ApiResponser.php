<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;
use App\Modif;

trait ApiResponser {

    // Synth probe
    protected function synthResponse($error, $session, $admin, $synthKeys, $code, $me) {
        return response()->json([
            'error' => $error,
            'session' => $session,
            'admin' => $admin,
            'synthKeys' => $synthKeys,
            'current' => $me
        ], $code);
    }

    // Show one element
    protected function showOne($element, $message) {
        return response()->json([
            'error' => false,
            'message' => $message, 
            'data' => $element
        ], 200);
    }

    // Show multiple elements
    protected function showMany($collection, $message, $synthKey) {
        return response()->json([
            'error' => false,
            'message' => $message,
            'synthKey' => $synthKey,
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

    // Show a sucess response
    protected function sucessResponse($message, $code) {
        return response()->json([
            'error' => false,
            'message' => $message,
        ], $code);
    }

    // Show a error response
    protected function errorResponse($message, $code) {
        return response()->json([
            'error' => true,
            'message' => $message,
        ], $code);
    }    

    // Show multiple error response
    protected function errorDataResponse($message, $data, $code) {
        return response()->json([
            'error' => true,
            'message' => $message,
            'data' => $data
        ], $code);
    }

}
