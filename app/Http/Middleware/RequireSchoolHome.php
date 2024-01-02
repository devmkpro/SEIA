<?php

namespace App\Http\Middleware;

use App\Models\School;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequireSchoolHome
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() || !$request->cookie('school_home')) {
            return redirect()->route('panel')->withErrors(['error' => 'Você precisa selecionar uma escola.']);
        } else if (School::where('uuid', decrypt($request->cookie('school_home')))->first() == null) {
            return redirect()->route('panel')->withErros(['error' => 'A escola selecionada não existe.']);
        }

        return $next($request);
    }
}
