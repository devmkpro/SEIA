<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequireCurriculumSet
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $class = $request->route('class');
        if (!$class || !$class->curriculum_uuid) {
            return $this->terminateError($request);
        }

        return $next($request);
    }

    public function terminateError ($request) {
        if ($request->bearerToken()) {
            return response()->json([
                'message' => 'A turma precisa ter uma matriz curricular definida',
                'error' => 'A turma precisa ter uma matriz curricular definida',
            ], 404);
        } else {
            return redirect()->route('manage.classes.edit', $request->route('class'))->with(['error' => 'Você precisa definir uma matriz curricular para a turma!']);
        }
    }
}
