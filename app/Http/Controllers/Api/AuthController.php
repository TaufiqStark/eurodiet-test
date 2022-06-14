<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $credentials = $request->validate([
            'name' => 'required|min:3|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);
        $credentials['password'] = Hash::make($credentials['password']);
        return User::create($credentials);
    }
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email|min:3',
            'password' => 'required'
        ]);
        if(!Auth::attempt($credentials)){
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }
        $user = User::where('email', $credentials['email'])->first();
        $token = $user->createToken('auth-token')->plainTextToken;
        return response()->json([
            'message' => 'Hello '. $user->name. ' Welcome back!',
            'access_token' => $token,
            'token_type' => 'Bearer'
        ], 200);
    }
    public function logout(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();
        return response()->json(['message' => 'Logout Successfully'], 200);
    }
}
