<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TokenController extends Controller
{
    /**
     * create a token
     */
    public function create(Request $request)
    {
        // create user token with name 'auth_token'
        $token = $request->user()->createToken('auth_token');  

        // return token plaintext
        return ['token' => $token->plainTextToken()];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        //
    }
}
