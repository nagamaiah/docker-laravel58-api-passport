<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Hash;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        // dd($request->only(['email','password','name']));
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|unique:users|max:255',
            'password' => 'required|min:4'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $token = $user->createToken('auth-token')->accessToken;

        return response()->json([
            'message' => 'User created successfully',
            'token' => $token
        ]);
    }

    public function login(Request $request)
    {   
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();
        if(!$user || !Hash::check($request->password, $user->password))
        {
            return response()->json([
                'message' => 'The provided credentials are incorrect'
            ]);
        }
        $token = $user->createToken('auth-token')->accessToken;
        return response()->json([
            'message' => 'Login succssfully',
            'token' => $token
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }
}
