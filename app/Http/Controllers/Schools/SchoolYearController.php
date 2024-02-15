<?php

namespace App\Http\Controllers\Schools;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\School\SchoolYear;

class SchoolYearController extends Controller
{


    /**
     * Display a listing of the school years.
     */
    public function index()
    {
        return response()->json(SchoolYear::all()->map(function ($schoolyear) {
            return [
                'code' => $schoolyear->code,
                'name' => $schoolyear->name,
                'start_date' => $schoolyear->start_date,
                'end_date' => $schoolyear->end_date,
                'status' => $schoolyear->active ? 'Ativo' : 'Inativo',
            ];
        }));
    }

    /**
     * Display the school year index
     */
    public function schoolsyears()
    {
        return view('admin.schools_years.index', [
            'schoolsyears' => SchoolYear::all(),
            'title' => 'Anos letivos',
            'slot' => 'Olá, nesta página você pode gerenciar os anos letivos da sua escola! Filtrando por ano letivo, você pode adicionar e editar os anos letivos.',
        ]);
    }

    /**
     * Show School Year
     */
    public function show(SchoolYear $schoolYear)
    {
        return response()->json([
            'code' => $schoolYear->code,
            'name' => $schoolYear->name,
            'start_date' => $schoolYear->start_date,
            'end_date' => $schoolYear->end_date,
            'status' => $schoolYear->active ? '1' : '0',
        ]);
    }

    /**
     * Store a new school year.
     **/
    public function store(Request $request): mixed
    {
        $request->validate([
            'name' => 'required|string',
            'start_date' => 'required|date|before:end_date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'nullable|boolean',
        ]);

        $hasSchoolYearActive = SchoolYear::all()->where('active', true)->first();

        SchoolYear::create([
            'name' => $request->name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'active' => $hasSchoolYearActive ? false : $request->status,
        ]);

        return $this->response($request, 'manage.school-years', 'Ano letivo criado com sucesso!');
    }

    /**
     * Update a school year.
     */
    public function update(Request $request): mixed
    {
        $request->validate([
            'name' => 'required|string',
            'start_date' => 'required|date|before:end_date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'nullable|boolean',
            'schoolYear' => 'required|string|exists:school_years,code',
        ]);

        $schoolYear = SchoolYear::where('code', $request->schoolYear)->first();
        $hasSchoolYearActive = SchoolYear::where('active', true)->first();
        
        if ($hasSchoolYearActive && $request->status) {
            $hasSchoolYearActive->update(['active' => false]);
        }

        $schoolYear->update([
            'name' => $request->name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'active' =>  $request->status,
        ]);

        return $this->response($request, 'manage.school-years', 'Ano letivo atualizado com sucesso!');
    }

    /**
     * Get Active School Year
     */
    public function getActive()
    {
        $schoolYear = SchoolYear::where('active', true)->firstOrFail();

        return $schoolYear;
    }
}
