<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Curriculum;
use Illuminate\Http\Request;

class SetClassCurriculumController extends Controller
{
    /**
     * Set class curriculum.
     */
    public function store(Request $request): mixed
    {
        $failed = $this->validateRequest($request, [
            'curriculum' => 'required|exists:curricula,code',
            'class' => 'required|exists:classes,code',
        ]);

        if ($failed) {
            return $failed;
        }

        $school_home = (new SchoolController)->getHome($request);
        $curriculum = Curriculum::where('code', $request->curriculum)->where('school_uuid', $school_home->uuid)->first();
        $class = Classes::where('code', $request->class)->where('schools_uuid', $school_home->uuid)->first();

        if (!$curriculum) {
            return $this->response($request, 'manage.classes.edit', 'Matriz curricular não encontrada.', 'error', 404, 'class', $class->code);
        }

        $class->update([
            'curriculum_uuid' => $curriculum->uuid,
        ]);

        return $this->response($request, 'manage.classes.edit', 'Matriz curricular alterada com sucesso.', 'message', 200, 'class', $class->code);
    }
}
