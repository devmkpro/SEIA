<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);


        if (Auth::attempt($request->only('email', 'password'))) {
            if (!User::where('email', $request->email)->first()->active) {
                return response()->json([
                    'message' => 'Usuário inativo',
                ], 401);
            } else {
                return response()->json([
                    'access_token' => request()->user()->createToken('invoice')->plainTextToken,
                    'token_type' => 'Bearer',
                ]);
            }
        }

        return response()->json([
            'message' => 'Login inválido',
        ], 401);
    }
}
