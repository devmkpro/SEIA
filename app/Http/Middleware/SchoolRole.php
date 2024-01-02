<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class SchoolRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        $schoolUUID = Cookie::get('school_home');
        $schoolUUID = decrypt($schoolUUID);

        if (Auth::check() && Auth::user()->hasRole('admin')) {
            return $next($request);
        }

        if ($schoolUUID && Auth::check() && Auth::user()->hasRoleForSchool($role, $schoolUUID)) {
            return $next($request);
        }

        abort(403, 'Unauthorized.');
    }
}
