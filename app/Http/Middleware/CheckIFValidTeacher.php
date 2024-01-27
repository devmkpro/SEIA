<?php

namespace App\Http\Middleware;

use App\Models\School;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckIFValidTeacher
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $school = decrypt($request->cookie('school_home'));
        $school = School::where('code', $school)->first();
        if (!$request->username) {
            return $this->terminateError($request, 'Usuário não encontrado', 'Professor inválido!');
        }
    
        $user = User::where('username', $request->username)->first();
        if (!$user || !$user->hasRoleForSchool('teacher', $school->uuid)){
            return $this->terminateError($request, 'Usuário não é professor', 'Professor inválido!');
        }
        return $next($request);
    }

    public function terminateError ($request, $message, $error) {
        if ($request->bearerToken() || $request->ajax()) {
            return response()->json([
                'message' => $message,
                'error' => $error
            ], 404);
        } 
            
        return redirect()->back()->withErrors([
            'error' => $error
        ]);
    }
}
