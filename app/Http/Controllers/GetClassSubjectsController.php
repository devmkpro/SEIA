<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use Illuminate\Http\Request;

class GetClassSubjectsController extends Controller
{
    /**
     * Get subjects of a class
     */

    public function store(Classes $class, $teacherUsername = null)
    {
        $subjects = $class->curriculum->subjects()->get();
        return $subjects->map(function ($subject) use ($teacherUsername) {
            return [
                'code' => $subject->code,
                'name' => (new SubjectsController)->formatName($subject->name),
                'ch_week' => $subject->ch_week,
                'teachers' =>  $subject->teachers,
                'isTeacher' => (new SubjectsController)->verifyTeacherOfSubject($subject, $teacherUsername)
            ];
        });
    }
}
