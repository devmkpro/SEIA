<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Login user and create token
     */
    public function login(LoginRequest $request)
    {
        if (Auth::attempt($request->only('email', 'password'))) {
            $user = User::where('email', $request->email)->first();
            if (!$user->active) {
                return $this->response($request, 'login', 'Usuário inativo', 'error', 401);
            }

            return response()->json([
                'access_token' => $user->createToken('invoice')->plainTextToken,
                'token_type' => 'Bearer',
            ]);
        }
        return $this->response($request, 'login', 'Credenciais inválidas', 'error', 401);
    }
}
