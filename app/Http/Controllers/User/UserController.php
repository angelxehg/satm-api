<?php

namespace App\Http\Controllers\User;

use App\User;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Hash as Hash;
use Illuminate\Support\Facades\Cache as IlluminateCache;

class UserController extends ApiController
{
    public function index()
    {
        if ($this->isAdmin()) {
            $cache = IlluminateCache::remember('users', 10, function () {
                $users = User::all();
                return [
                    'data' => $users
                ];
            });
            $data = $cache['data'];
            return $this->showOne($data, "All users");
        }
    }

    public function store(Request $request)
    {
        if ($currentUser = $this->isAdmin()) {
            $rules = [
                'first_name' => 'required|min:2|max:80',
                'last_name' => 'required|min:2|max:80',
                'email' => 'required|min:2|max:100|email|unique:users',
                'password' => 'required|min:6|max:100|confirmed',
                'admin' => 'boolean'
            ];
            $this->validate($request, $rules);
            $fields = $request->all();
            if ($request->has('admin')) {
                if ($fields['admin'] == 1 && $currentUser->id != 1) {
                    throw new AuthorizationException;
                }
            }
            $fields['password'] = Hash::make($fields['password']);
            $user = new User($fields);
            $user->save();
            return $this->showOne($user, "User created");
        }
    }

    public function update(Request $request, $id)
    {
        if ($currentUser = $this->isAdmin()) {
            if ($id == 1 && $currentUser->id != 1) {
                throw new AuthorizationException;
            }
            $user = User::findorFail($id);
            $rules = [
                'first_name' => 'min:2|max:80',
                'last_name' => 'min:2|max:80',
                'email' => 'email|min:2|max:100|unique:users,email,' . $user->id,
                'password' => 'min:6|max:100|confirmed',
                'admin' => 'boolean'
            ];
            $this->validate($request, $rules);
            if ($request->has('name')) {
                $user->name = $request->name;
            }
            if ($request->has('email') && $user->email != $request->email) {
                $user->email = $request->email;
            }
            if ($request->has('password')) {
                $user->password = Hash::make($request->password);
            }
            if ($request->has('admin')) {
                $user->admin = $request->admin;
            }
            $user->save();
            return $this->showOne($user, "User updated");
        }
    }

    public function destroy($id)
    {
        if ($currentUser = $this->isAdmin()) {
            if ($id == 1) {
                throw new AuthorizationException;
            }
            $user = User::findorFail($id);
            $user->delete();
            return $this->showOne($user, "User deleted");
        }
    }
}
