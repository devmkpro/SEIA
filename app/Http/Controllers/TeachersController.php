<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Role;
use App\Models\TeachersSchool;
use App\Models\User;
use App\Models\UserSchool;
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
        
        if ($request->search){
            $users = User::where('email', $request->search)->orWhere('username', $request->search)->get();

            foreach ($users as $user) {
                if (!$user->hasRole('teacher')) {
                    $user->delete();
                }
                unset($user->email_verified_at, $user->created_at, $user->updated_at, $user->uuid, $user->password, $user->photo, $user->roles);
            }
            
            $users = array_values($users->toArray());
            return response()->json($users);
        }
        
        $teachers = $class->teachers;
        
        return response()->json(
            $teachers->map(function ($teacher) {
                return [
                    'name' => $teacher->name,
                    'email' => $teacher->email,
                    'subjects' => $teacher->subjects->map(function ($subject) {
                        return [
                            'name' => ucfirst($subject->subject->name)
                        ];
                    })->implode('name', ', ') ?: 'Nenhuma disciplina',
                    'phone' => $teacher->phone,
                    'username' => $teacher->username,
                ];
            })
        );
    }

   
}
