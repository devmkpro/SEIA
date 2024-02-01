<?php

namespace App\Http\Middleware;

use App\Http\Controllers\SchoolController;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckValidSchoolClass
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $school_home = (new SchoolController)->getHome($request);
        $class = $request->route('class');

        if ($class->schools_uuid != $school_home->uuid) {
            return $this->terminateError($request, 'Turma não encontrada', 'Turma não encontrada');
        }

        return $next($request);
    }

    public function terminateError ($request, $message, $error) {
        if ($request->bearerToken() || $request->ajax()) {
            return response()->json([
                'message' => $message,
                'error' => $error
            ], 404);
        } 
            
        return redirect()->back()->withErrors([
            'error' => $error
        ]);
    }
}
