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
        if (!$request->cookie('school_home') || School::where('uuid', decrypt($request->cookie('school_home')))->first() == null) {
            return $this->terminateError($request);
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

    public function terminateError ($request) {
        if ($request->bearerToken()) {
            return response()->json([
                'message' => 'School Home nao definida',
                'error' => 'Escola nao encontrada',
            ], 404);
        } else {
            return redirect()->route('panel')->with(['error' => 'Primeiro selecione uma escola!']);
        }
    }



}
