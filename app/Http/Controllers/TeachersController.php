<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSchoolConnectionRequest;
use App\Models\Classes;
use App\Models\Role;
use App\Models\SchoolConnectionRequest;
use App\Models\TeachersSchoolsSubjects;
use App\Models\User;
use Illuminate\Http\Request;

class TeachersController extends Controller
{
    /**
     * Render the teachers view.
     */
    public function teachers(Request $request, $code)
    {
        $school_home = (new SchoolController)->getHome($request);
        $class = Classes::where('code', $code)->where('schools_uuid', $school_home->uuid)->first();
        if (!$class) {
            return $this->response($request, 'manage.classes', 'Turma não encontrada.', 'error', 404);
        }
        return view('teachers.index', [
            'class' => $class,
            'title' => 'Aqui você pode gerenciar os professores da turma ' . $class->name . '/' . $class->schoolYear->name,
            'slot' => 'Os professores são responsáveis por gerenciar as notas e faltas dos alunos, e também por lançar os conteúdos e atividades.',
        ]);
    }

    /**
     * Get teachers from class.
     */
    public function getTeachers(Request $request, $code)
    {
        $school_home = (new SchoolController)->getHome($request);
        $class = Classes::where('code', $code)->where('schools_uuid', $school_home->uuid)->first();

        if (!$class) {
            return $this->response($request, 'manage.classes', 'Turma não encontrada.', 'error', 404);
        }

        if ($request->search) {
            $users = User::where('email', $request->search)->orWhere('username', $request->search)->get();
            $users = $users->filter(function ($user) {
                $class = Classes::where('code', request()->code)->first();
                return $user->hasRole('teacher') && !TeachersSchoolsSubjects::where('user_uuid', $user->uuid)->where('class_uuid', $class->uuid)->first();
            });

            return $users->map(function ($user) {
                return [
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'username' => $user->username,
                ];
            });
        }

        $teachers = $class->teachers;
        return $teachers->map(function ($teacher) {
            if ($teacher->subjects){
                $subjects = $teacher->subjects->pluck('name')->map(function ($subject) {
                    return ucfirst($subject);
                })->implode(', ');
            } else {
                $subjects = 'Nenhuma disciplina vinculada';
            }
           
            return [
                'name' => $teacher->user->name,
                'email' => $teacher->user->email,
                'subjects' => $subjects,
                'phone' => $teacher->user->phone,
                'username' => $teacher->user->username,
            ];
        })->unique('user_uuid');
    }

    /**
     * Create new request to connect school.
     */
    public function invite(StoreSchoolConnectionRequest $request, $code)
    {   
        $class = Classes::where('code', $code)->first();
        if (!$class) {
            return $this->response($request, 'manage.classes', 'Turma não encontrada.', 'error', 404);
        }

        $user = User::where('username', $request->username)->first();
        $role = Role::where('name', $request->role)->first();

        $isInvited = SchoolConnectionRequest::where('user_uuid', $user->uuid)
            ->where('class_uuid', $class->uuid)
            ->where('role', $role->uuid)
            ->first();

        if ($isInvited) {
            return $this->response($request, 'manage.classes.teachers', 'Solicitação de vínculo já enviada!', 'message', 200, 'code', $class->code);
        }

        $isTeacher = TeachersSchoolsSubjects::where('user_uuid', $user->uuid)
            ->where('class_uuid', $class->uuid)
            ->first();

        if ($isTeacher) {
            return $this->response($request, 'manage.classes.teachers', 'Professor já vinculado à turma!', 'error', 200, 'code', $class->code);
        }

        SchoolConnectionRequest::create([
            'school_uuid' => (new SchoolController)->getHome($request)->uuid,
            'user_uuid' => $user->uuid,
            'role' => $role->uuid,
            'class_uuid' => $class->uuid,
        ]);

        return $this->response($request, 'manage.classes.teachers', 'Solicitação de vínculo enviada com sucesso!', 'message', 200, 'code', $class->code);
    }
}
