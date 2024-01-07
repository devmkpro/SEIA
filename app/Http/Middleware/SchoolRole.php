<?php

namespace App\Http\Middleware;

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
        $schoolUUID = decrypt($schoolUUID);

        if ($user->hasRole('admin')) {
            return $next($request);
        }

        $rolesArray = explode('|', $roles);

        foreach ($rolesArray as $role) {
            if ($schoolUUID && $user->hasRoleForSchool($role, $schoolUUID)) {
                return $next($request);
            }
        }

        abort(403, 'Unauthorized.');
    }
}
