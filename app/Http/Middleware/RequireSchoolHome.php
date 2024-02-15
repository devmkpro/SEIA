<?php

namespace App\Http\Middleware;

use App\Models\School;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Guard;
use Spatie\Permission\Exceptions\UnauthorizedException;

class RequireSchoolHome
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $guard = null): Response
    {
        try{
            $schoolHome = decrypt($request->cookie('school_home'));
        } catch (\Exception $e) {
            return $this->terminateError($request, 'Escola não encontrada', 'school_not_found');
        }

        $school = School::where('code', $schoolHome)->first();

        if (!$school) {
            return $this->terminateError($request, 'Escola não encontrada', 'school_not_found');
        }

        $authGuard = Auth::guard($guard);
        $user = $authGuard->user();

        if (! $user && $request->bearerToken() && config('permission.use_passport_client_credentials')) {
            $user = Guard::getPassportClient($guard);
        }

        if (!$user) {
            throw UnauthorizedException::notLoggedIn();
        }

        return $next($request);
    }

    public function terminateError ($request, $message, $error) {
        if ($request->bearerToken()) {
            return response()->json([
                'message' => $message,
                'error' => $error
            ], 404);
        } 
            
        return redirect()->route('panel')->with(['error' => $message]);
    }
}
