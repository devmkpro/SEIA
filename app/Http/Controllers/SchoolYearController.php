<?php

namespace App\Http\Controllers;

use App\Models\SchoolYear;
use Illuminate\Http\Request;

class SchoolYearController extends Controller
{


    /**
     * Display a listing of the school years.
     */
    public function index()
    {
        return response()->json(SchoolYear::all()->map(function ($schoolyear) {
            return [
                'uuid' => encrypt($schoolyear->uuid),
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
        ]);
    }

    /**
     * Show School Year
     */
    public function show($uuidEncoded)
    {
        $uuid = decrypt($uuidEncoded);
        $schoolYear = SchoolYear::where('uuid', $uuid)->firstOrFail();

        return response()->json([
            'uuid' => encrypt($schoolYear->uuid),
            'name' => $schoolYear->name,
            'start_date' => $schoolYear->start_date,
            'end_date' => $schoolYear->end_date,
            'status' => $schoolYear->active ? '1' : '0',
        ]);
    }

    /**
     * Store a new school year.
    **/
    public function store(Request $request)
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

        return redirect()->route('manage.school-years')->with('success', 'Ano letivo criado com sucesso!');
    }

    /**
     * Update a school year.
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'start_date' => 'required|date|before:end_date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'nullable|boolean',
            'schoolYear' => 'required',
        ]);

        $schoolYear = SchoolYear::where('uuid', decrypt($request->schoolYear))->firstOrFail();

        if (!$schoolYear){
            return redirect()->route('manage.school-years')->with('error', 'Ano letivo não encontrado!');
        }

        $hasSchoolYearActive = SchoolYear::where('active', true)->first();
        if ($hasSchoolYearActive && $request->status){
            $hasSchoolYearActive->update(['active' => false]);
        }

        $schoolYear->update([
            'name' => $request->name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'active' =>  $request->status,
        ]);

        return redirect()->route('manage.school-years')->with('success', 'Ano letivo atualizado com sucesso!');
    }

}
