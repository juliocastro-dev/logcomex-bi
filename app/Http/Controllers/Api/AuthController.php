<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function teste() {
        echo "Teste vindo da rota";
    }

    public function register(Request $request)
    {

        $registerdData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
    
        $user = User::create([
            'name' => $registerdData['name'],
            'email' => $registerdData['email'],
            'password' => Hash::make($registerdData['password']),
        ]);
    
        $accessToken = $user->createToken('authToken')->accessToken;
    
        return response()->json([
            'user' => $user, 
            'access_token' => $accessToken
        ], 201);
        
    }

    public function login(Request $request)
    {
        // $loginData = $request->all();

        $loginData = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
    
        if (!auth()->attempt($loginData)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    
        $user = auth()->user();
        $accessToken = $user->createToken('authToken')->accessToken;
    
        return response()->json([
            'user' => $user,
            'access_token' => $accessToken,
        ]);
    }
}
