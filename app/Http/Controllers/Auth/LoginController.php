<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\UserServiceInterface;

class LoginController extends Controller
{
    public function __invoke(Request $request)
    {
        $this->validateRequest($request);

        $userService = app()->make(UserServiceInterface::class);

        // dd(auth()->check(), auth()->user());
        if ($userService->login($request)) {
            return redirect('/')->with('success', 'Login successful');
        }
        return redirect('/')->with('error', 'Invalid email or password');
    }

    private function validateRequest(Request $request): void
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    }
}
