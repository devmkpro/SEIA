<?php

namespace App\Http\Middleware;

use App\Models\Classes;
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
        $class = Classes::where('code', $request->route('code'))->first();
        if (!$class->curriculum_uuid) {
            return $this->terminateError($request);
        }

        return $next($request);
    }

    public function terminateError ($request) {
        if ($request->bearerToken()) {
            return response()->json([
                'message' => 'Matriz curricular nao definida para a turma',
                'error' => 'Matriz curricular nao encontrada',
            ], 404);
        } else {
            return redirect()->route('manage.classes.edit', $request->route('code'))->with(['error' => 'Você precisa definir uma matriz curricular para a turma!']);
        }
    }
}
