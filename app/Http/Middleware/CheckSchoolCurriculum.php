<?php

namespace App\Http\Middleware;

use App\Http\Controllers\SchoolController;
use App\Models\Curriculum;
use App\Models\Subjects;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSchoolCurriculum
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $curriculum = Curriculum::where('code', $request->curriculum)->first();
        if (!$curriculum) {
            // Check if the subject exists
            $subject = Subjects::where('uuid', decrypt($request->subject))->firstOrFail();
            $curriculum = $subject->curriculum()->firstOrFail();
        }

        $school_home = (new SchoolController)->getHome($request);
        if ($curriculum->school_uuid != $school_home->uuid) {
            return redirect()->route('manage.curriculum')->withErrors(['error' => 'Você não tem permissão para acessar essa página!']);
        }

        return $next($request);
    }
}
