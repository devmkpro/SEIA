<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreClassesRequest;
use App\Models\Classes;

class ClassesController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClassesRequest $request)
    {
        $school_home = (new SchoolController)->getHome($request);
        $school_year = (new SchoolYearController)->getActive();
        
        Classes::create([
            'name' => $request->nome,
            'turn' => $request->turno,
            'monday' => $request->segunda,
            'tuesday' => $request->terca,
            'wednesday' => $request->quarta,
            'thursday' => $request->quinta,
            'friday' => $request->sexta,
            'saturday' => $request->sabado,
            'sunday' => $request->domingo,
            'max_students' => $request->max_estudantes,
            'room' => $request->sala,
            'start_time' => $request->horario_inicio,
            'end_time' => $request->horario_fim,
            'schools_uuid' => $school_home->uuid,
            'school_years_uuid' => $school_year->uuid,
        ]);

        return $this->response($request, 'manage.classes', 'Turma criada com sucesso.', 'message', 201);
    }

    /**
     * Index classes.
     */
    public function classes(Request $request)
    {
        $school_home = (new SchoolController)->getHome($request);
        $classes = Classes::where('schools_uuid', $school_home->uuid)->get();
        return view('manage.classes', compact('classes'));
    }
}
