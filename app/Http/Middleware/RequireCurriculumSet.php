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
        
        if (!$class) {
            return $this->terminateError($request, 'Turma não encontrada.');
        }

        if (!$class->curriculum) {
            return $this->terminateError($request, 'Você precisa definir uma matriz curricular para a turma!');
        }

        return $next($request);
    }

    public function terminateError ($request, $message) {
        if ($request->bearerToken()) {
            return response()->json([
                'error' => $message,
            ], 404);
        } else {
            return redirect()->route('manage.classes.edit', $request->route('class'))->with(['error' => 'Você precisa definir uma matriz curricular para a turma!']);
        }
    }
}
