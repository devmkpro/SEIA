<?php

namespace App\Http\Controllers\Schools\Classes;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Schools\Subjects\SubjectsController;
use App\Models\Classes\Classes;

class GetClassSubjectsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Classes $class, $user = null)
    {
        $subjects = $class->curriculum->subjects()->get();
        $sbc = new SubjectsController();
        return $subjects->map(function ($subject) use ($user, $sbc) {
            return [
                'code' => $subject->code,
                'name' => $sbc->formatName($subject->name),
                'ch_week' => $subject->ch_week,
                'teachers' =>  $subject->teachers,
                'isTeacher' => $sbc->verifyTeacherOfSubject($subject, $user)
            ];
        });
    }
}
