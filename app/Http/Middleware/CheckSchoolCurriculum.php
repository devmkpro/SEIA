<?php

namespace App\Http\Middleware;

use App\Http\Controllers\SchoolController;
use App\Models\Curriculum;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Guard;
use Spatie\Permission\Exceptions\UnauthorizedException; 

class CheckSchoolCurriculum
{
    /**
     * Handle an incoming request.
     *
    * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $guard=null): Response
    {
        $authGuard = Auth::guard($guard);
        $user = $authGuard->user();

        if (! $user && $request->bearerToken() && config('permission.use_passport_client_credentials')) {
            $user = Guard::getPassportClient($guard);
        }

        if (!$user) {
            throw UnauthorizedException::notLoggedIn();
        }

        if (! method_exists($user, 'hasAnyRole')) {
            throw UnauthorizedException::missingTraitHasRoles($user);
        }

        $curriculum = Curriculum::where('code', $request->curriculum)->first();

        if (!$curriculum ) {
            return $this->terminateError($request, 'Matriz curricular nao encontrada');
        }

        $school_home = (new SchoolController)->getHome($request);
        
        if ($curriculum->school_uuid != $school_home->uuid) {
            return $this->terminateError($request, 'Essa matriz curricular nao pertence a escola selecionada');
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
