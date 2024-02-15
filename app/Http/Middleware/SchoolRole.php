<?php

namespace App\Http\Middleware;

use App\Models\School\School;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Spatie\Permission\Guard;

class SchoolRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $roles, $guard = null): Response
    {
        $authGuard = Auth::guard($guard);
        $user = $authGuard->user();
        $user = User::find($user->uuid); // Refresh user data to funcion model methods

        if (!$user && $request->bearerToken() && config('permission.use_passport_client_credentials')) {
            $user = Guard::getPassportClient($guard);
        }

        if (!$user) {
            throw UnauthorizedException::notLoggedIn();
        }

        if (!method_exists($user, 'hasAnyRole')) {
            throw UnauthorizedException::missingTraitHasRoles($user);
        }

        $schoolUUID = Cookie::get('school_home');

        if ($user->hasRole('admin')) {
            return $next($request);
        } 

        try {
            $schoolUUID = decrypt($schoolUUID);
        } catch (\Exception $e) {
            return $this->terminateError($request, 'Escola não encontrada');
        }
        $school = School::where('code', $schoolUUID)->first();
        $rolesArray = explode('|', $roles);

        foreach ($rolesArray as $role) {
            if ($schoolUUID && $user->hasRoleForSchool($role, $school->uuid)) {
                return $next($request);
            }
        }

        return $this->terminateError($request, 'Você não tem permissão para acessar essa página!');
    }

    public function terminateError ($request, $message) {
        if ($request->bearerToken()) {
            return response()->json([
                'error' => $message,
            ], 404);
        } else {
            return redirect()->route('panel')->with(['error' => 'Escola inválida ou sem permissão!']);
        }
    }
}
