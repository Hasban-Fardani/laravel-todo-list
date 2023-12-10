<?php

namespace App\Services;

use Illuminate\Http\Request;

interface UserServiceInterface
{
    public function login(Request $request);
    public function logout();
    public function register(Request $request);
}