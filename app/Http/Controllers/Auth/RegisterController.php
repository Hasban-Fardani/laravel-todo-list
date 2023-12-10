<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\UserServiceInterface;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    //
    public function __invoke(Request $request)
    {
        try {
            $this->validateRequest($request);   
    
            $userService = app()->make(UserServiceInterface::class);
            $userService->register($request);
        } catch (\Throwable $th) {
            return redirect('/')->with('error', $th->getMessage());
        }
        return redirect('/')->with('success', 'Register successful, please login');
    }

    private function validateRequest(Request $request): void
    {
        $request->validate([
            'email' => 'required|string|max:255',
            'password' => 'required|string|min:6',
        ]);
    }
}
