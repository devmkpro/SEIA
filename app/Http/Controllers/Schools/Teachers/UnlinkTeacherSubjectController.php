<?php

namespace App\Http\Controllers\Schools\Teachers;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Teachers\LinkTeacherSubjectsRequest;
use App\Models\User;
use App\Models\Classes\Classes;
use App\Models\Teacher\TeachersSubjects;



class UnlinkTeacherSubjectController extends Controller
{
    /**
     * Unlink teacher to subject.
     */
    public function store(LinkTeacherSubjectsRequest $request)
    {
        $user = User::where('username', $request->teacher)->first();
        $class = Classes::where('code', $request->class)->first();
        $subject = $class->curriculum->subjects->where('code', $request->subject)->first();

        if (!$subject) {
            return $this->response($request, 'manage.classes', 'Disciplina não encontrada.', 'error', 404);
        }

        $teacher_subject = TeachersSubjects::where('user_uuid', $user->uuid)->where('class_uuid', $class->uuid)->where('subject_uuid', $subject->uuid)->first();

        if (!$teacher_subject) {
            return $this->response($request, 'manage.classes.teachers', 'Vinculo não encontrado.', 'error', 404, null, null, false, true);
        }

        $teacher_subject->delete();

        return $this->response($request, 'manage.classes.teachers', 'Disciplina desvinculada com sucesso!', 'message', 200, null, null, false, true);
    }
}
