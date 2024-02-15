<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\School\SchoolYear;

class RequireSchoolYearActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $school_year = SchoolYear::where('active', true)->first();
        if (!$school_year) {
            return $this->terminateError($request);
        }
        return $next($request);
    }


    public function terminateError ($request) {
        if ($request->bearerToken()) {
            return response()->json([
                'message' => 'Ano letivo nao definido',
                'error' => 'O ano letivo nao foi encontrado',
            ], 404);
        }
        return redirect()->route('panel')->with(['error' => 'Ano letivo não definido no sistema.']);
    }
}
