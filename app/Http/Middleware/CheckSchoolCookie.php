<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\CookieController;
use App\Models\School;

class CheckSchoolCookie
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() || !$request->cookie('school_home')) {
            return $next($request);
        }

        $schoolUUID = decrypt($request->cookie('school_home'));

        if ($request->user()->hasRole('admin') && School::where('uuid', $schoolUUID)->exists()) {
            return $next($request);
        } else if (!School::where('uuid', $schoolUUID)->exists()) {
            $this->terminate();
            return $next($request);
        }

        if ($request->user()->schools()->count() > 0 && $request->user()->schools()->where('school_uuid', $schoolUUID)->exists()) {
            return $next($request);
        }

        $this->terminate();
        return redirect()->route('panel');
    }

    /**
     * Delete the cookie if the user is not an admin or if the school does not exist.
     */
    public function terminate()
    {
        $cookieController = new CookieController();
        $cookieController->deleteCookie('school_home');
    }
}
