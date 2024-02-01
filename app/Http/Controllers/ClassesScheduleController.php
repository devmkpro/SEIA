<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ClassesScheduleController extends Controller
{
    /**
     * Display the class schedule form.
     */
    public function edit(Classes $class, Request $request): mixed
    {
        return view('classes.schedule', [
            'title' => 'Editando horarios da turma', 
            'slot' => 'Aqui você pode editar e visualizar os horarios da turma.'
        ]);
    }

}
