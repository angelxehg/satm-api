<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Hash as Hash;
use Illuminate\Support\Facades\Cache as IlluminateCache;

class ApiController extends Controller {
    
    use ApiResponser;

    protected function isLogged() {
        if ($user = auth()->user()) {
            return $user;
        } else {
            throw new AuthenticationException();
        }
    }

    protected function isAdmin() {
        $currentUser = $this->isLogged();
        if ($currentUser->admin) {
            return $currentUser;
        } else {
            throw new AuthorizationException();
        }
    }

}
