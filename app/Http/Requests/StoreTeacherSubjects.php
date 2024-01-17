<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTeacherSubjects extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'teacher' => 'required|string|exists:users,uuid',
            'subject' => 'required|string|exists:subjects,uuid',
            'primay_teacher' => 'required|boolean',
            'weekly_workload' => 'required|integer',
        ];
    }
}
