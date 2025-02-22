<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\School;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Guard;
use Spatie\Permission\Exceptions\UnauthorizedException; 


class CheckIFSetSchoolHome
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $guard=null): Response
    {
        if (!$request->school) {
            return $this->terminateError($request, 'Escola não definida');
        }

        try {
            School::where('uuid', decrypt($request->school))->firstOrFail();
        } catch (\Exception $e) {
            return $this->terminateError($request, 'Escola não encontrada');
        }

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

        $school = decrypt($request->school);

        if (!$user->hasRole('admin') && !$user->schools()->where('school_uuid', $school)->exists()) {
            return $this->terminateError($request, 'Você não tem permissão para acessar essa página!');
        }

        return $next($request);
    }

     /**
     * terminateError
     */

     public function terminateError ($request, $message=null) {
        if ($request->bearerToken()) {
            return response()->json([
                'message' => $message ?? 'Data nao definida',
            ], 404);
        } else {
            return redirect()->route('manage.curriculum')->withErrors(['error' => $message ?? 'Sem permissão']);
        }
    }
}
