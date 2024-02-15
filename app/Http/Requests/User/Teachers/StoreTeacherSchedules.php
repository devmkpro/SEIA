<?php

namespace App\Http\Requests\User\Teachers;

use App\Http\Requests\BaseRequest;

class StoreTeacherSchedules extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'teacher_subject_uuid' => 'required|string|exists:teachers_subjects,uuid',
            'day' => 'required|string|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'total_hours' => 'required|integer|min:1|max:11'
        ];
    }
}
