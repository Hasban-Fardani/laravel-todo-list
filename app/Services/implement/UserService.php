<?php

namespace App\Services\implement;

use App\Models\User;
use App\Services\UserServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserService implements UserServiceInterface
{
    public function login(Request $request){
        return Auth::attempt($request->only('email', 'password'));
    }

    public function logout(){
        Auth::logout();
    }

    public function register(Request $request){
        return User::create($request->only('name', 'email', 'password'));
    }
}