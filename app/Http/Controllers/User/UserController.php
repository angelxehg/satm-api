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
    // Show all users
    public function index()
    {
        if ($this->isLoggedIn()) {
            $cached = IlluminateCache::remember('users', 10, function () {
                $users = User::all();
                $synthKey = $this->getSynthUsers();
                return [
                    'data' => $users,
                    'synthKey' => $synthKey
                ];
            });
            $data = $cached['data'];
            $synthKey = $cached['synthKey'];
            return $this->showMany($data, "All the users", $synthKey);
        }
    }

    // Create a new user
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|min:2|max:150',
            'email' => 'required|min:2|max:150|email|unique:users',
            'password' => 'required|min:6|max:150|confirmed',
            'hability' => 'required|min:2|max:150',
            'admin' => 'boolean'
        ];
        $this->validate($request, $rules);
        $fields = $request->all();
        $fields['password'] = Hash::make($fields['password']);
        $user = new User($fields);
        $user->save();
        $this->synthUsers();
        return $this->showOne($user, "User created");
    }

    // Update a user
    public function update(Request $request, $id)
    {
        $user = User::findorFail($id);
        $permission = $this->waterfallValidation($user);
        if ($permission['permited']) {
            $rules = [
                'name' => 'min:2|max:150',
                'email' => 'email|min:2|max:150|unique:users,email,' . $user->id,
                'password' => 'min:6|max:150|confirmed',
                'hability' => 'min:2|max:150',
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
            if ($request->has('hability')) {
                $user->hability = $request->hability;
            }
            if ($request->has('admin')) {
                $user->admin = $request->admin;
            }
            $user->save();
            $this->synthUsers();
            return $this->showOne($user, "User updated");
        } else {
            return $this->errorResponse($permission['message'], 401);
        }
    }

    // Delete a user
    public function destroy($id)
    {
        $user = User::findorFail($id);
        $permission = $this->waterfallValidation($user);
        if ($permission['permited']) {
            if ($permission['current']->id == $id) {
                return $this->errorResponse("No te puedes eliminar a ti mismo", 401);
            }
            $user = User::findorFail($id);
            $user->delete();
            $this->synthUsers();
            return $this->showOne($user, "User deleted");
        } else {
            return $this->errorResponse($permission['message'], 401);
        }
    }
}
