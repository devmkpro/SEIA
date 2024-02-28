<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Session\CookieController;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\School\School;

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
        try {
            $schoolCode = decrypt($request->cookie('school_home'));
        } catch (\Exception $e) {
            return $this->terminate($request, 'Escola não definida');
        }

        $schoolExists = School::where('code', $schoolCode)->exists();
        if (!$schoolExists) {
            return $this->terminate($request, 'Escola não encontrada');
        }

        $userHasAdminRole = $request->user()->hasRole('admin');
        $userHasSchool = $request->user()->schools()->count() > 0 && $request->user()->schools()->where('school_uuid', School::where('code', $schoolCode)->first()->uuid)->exists();

        if ($userHasAdminRole || $userHasSchool) {
            return $next($request);
        } 

        return $this->terminate($request, 'Você não tem permissão para acessar essa página!');
    }


    /**
     * Delete the cookie if the user is not an admin or if the school does not exist.
     */
    public function terminate($request, $message)
    {
        $cookieController = new CookieController();
        $cookieController->deleteCookie('school_home');
    
        if ($request->bearerToken()) {
            return response()->json([
                'error' => $message,
            ], 404);
        }

        return redirect()->back()->withErrors(['error' => $message]);

    }
}
