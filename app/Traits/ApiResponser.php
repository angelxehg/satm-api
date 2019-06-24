<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;
use App\Modif;
trait ApiResponser {

    // Synth probe
    protected function synthResponse($error, $session, $isAdmin, $synthKeys, $code, $me) {
        return response()->json([
            'error' => $error,
            'session' => $session,
            'isAdmin' => $isAdmin,
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

    // Send a token
    protected function sendToken($token, $me) {
        return response()->json([
            'error' => false,
            'current' => $me,
            'message' => "Sucessful login",
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ], 200);
    }
}
