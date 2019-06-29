<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function login()
    {
        $credentials = request(['email', 'password']);
        if (! $token = auth()->attempt($credentials)) {
            return $this->errorResponse("Email o contraseña incorrectos", 401);
        }
        $me = auth()->user();
        return $this->sendToken($token, $me);
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    public function logout()
    {
        auth()->logout();
        return $this->sucessResponse("Sesión cerrada en el servidor", 200);
    }

    public function refresh()
    {
        $me = auth()->user();
        return $this->sendToken(auth()->refresh(), $me);
    }

}
