<?php

namespace App\Http\Controllers\Schools\Teachers;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Teachers\LinkTeacherSubjectsRequest;
use App\Models\Teacher\TeachersSchools;
use App\Models\User;
use App\Models\Classes\Classes;
use App\Models\Teacher\TeachersSubjects;



class LinkTeacherSubjectController extends Controller
{
    /**
     * Link teacher to subject.
     */
    public function store(LinkTeacherSubjectsRequest $request)
    {
        $user = User::where('username', $request->teacher)->first();
        $class = Classes::where('code', $request->class)->first();
        $teacher_school = TeachersSchools::where('user_uuid', $user->uuid)->where('class_uuid', $class->uuid)->first();
        
        if (!$teacher_school) {
            return $this->response($request, 'manage.classes.teachers', 'Professor não encontrado.', 'error', 404);
        }

        $curriculum_class = $class->curriculum;
        $subject = $curriculum_class->subjects->where('code', $request->subject)->first();
        if (!$subject) {
            return $this->response($request, 'manage.classes', 'Disciplina da matriz curricular não encontrada.', 'error', 404);
        }

        $teacher_subject = TeachersSubjects::where('user_uuid', $user->uuid)->where('class_uuid', $class->uuid)->where('subject_uuid', $subject->uuid)->first();
        if ($teacher_subject) {
            return $this->response($request, 'manage.classes.teachers', 'Disciplina já vinculada.', 'error', 404, null, null, false, true);
        }

        TeachersSubjects::create([
            'class_uuid' => $class->uuid,
            'user_uuid' => $teacher_school->user_uuid,
            'subject_uuid' => $subject->uuid,
            'primary_teacher' => $request->primary_teacher ? true : false,
        ]);

        return $this->response($request, 'manage.classes.teachers', 'Disciplina vinculada com sucesso!', 'message', 200, null, null, false, true);

    }
}
