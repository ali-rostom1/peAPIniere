<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        try{
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            $user->assignRole('client');
            return response()->json([
                'status' => 'success',
                'message' => 'User created successfully',
                'user' => $user
            ],201);
        }catch(\Throwable $e){
            return response()->json([
                'status' => 'error',
                'message' => 'An internal server error occurred while trying to register the user.',
                'error' => $e->getMessage(),
            ],500);
        }
    }
    public function login(LoginRequest $request)
    {
        try{
            $token = Auth::attempt($request->only('email','password'));
            if(!$token){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Couldnt find user with given credentials',
                ],401);
            } 
            $user = Auth::user();
            // $refreshToken = JWTAuth::claims(['type' => 'refresh'])->setTTL(config('jwt.refresh_ttl'))->fromUser($user);
            return response()->json([
                'status' => 'success',
                'message' => 'Successfully authentificated user',
                'user' => $user,
                'authorisation' => [
                    'access_token' => $token,
                    'token_type' => 'bearer',
                    'expires_in' => JWTAuth::factory()->getTTL() * 60,
                ]
            ]);
        }catch(\Throwable $e){
            return response()->json([
                'status' => 'error',
                'message' => 'An internal server error occurred while trying to register the user.',
                'error' => $e->getMessage(),
            ],500);
        }
    }
    public function logout()
    {
        try{
            JWTAuth::invalidate(JWTAuth::getToken());
            return response()->json([
                'status' => 'success',
                'message' => 'Successfully logged out',
            ]);
        }catch(\Throwable $e){
            return response()->json([
                'status' => 'error',
                'message' => 'An internal server error ocurred while trying to log out the user',
            ],500);
        }
        
    }
    public function refreshToken(Request $request)
    {
        try {
            $newAccessToken = Auth::refresh();
            return response()->json([
                'access_token' => $newAccessToken,
                'token_type' => 'bearer',
                'expires_in' => JWTAuth::factory()->getTTL() * 60, 
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Invalid refresh token'], 401);
        }
    }

}
