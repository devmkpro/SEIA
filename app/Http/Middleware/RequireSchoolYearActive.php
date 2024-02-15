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
            return $this->terminateError($request, 'O sistema nao abriu o periodo letivo para o ano corrente');
        }
        return $next($request);
    }


    public function terminateError ($request, $message) {
        if ($request->bearerToken()) {
            return response()->json([
                'error' => $message,
            ], 404);
        }
        return redirect()->route('panel')->with(['error' => 'Ano letivo não definido no sistema.']);
    }
}
