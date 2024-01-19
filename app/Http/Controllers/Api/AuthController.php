<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Login user and create token for API.
     */
    public function login(Request $request)
    {   
        $credentials = $request->only('email', 'password');

        if (empty($credentials['email']) || empty($credentials['password'])) {
            return $this->response($request, 'login', 'Login ou senha inválidos', 'error', 401, null, null , true);
        }

        if (Auth::attempt($credentials)) {
            $user = User::where('email', $credentials['email'])->first();

            if (!$user->active) {
                return $this->response($request, 'login', 'Login ou senha inválidos', 'error', 401, null, null , true);
            }

            $token = $user->createToken('invoice')->plainTextToken;

            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]);
        }

        return $this->response($request, 'login', 'Login ou senha inválidos', 'error', 401, null, null , true);
    }
}
