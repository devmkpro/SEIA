<?php

namespace App\Http\Requests\User\Teachers;

use App\Http\Requests\BaseRequest;

class StoreTeacherSubjects extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'teacher' => 'required|string|exists:users,username',
            'subject' => 'required|string|exists:subjects,code',
            'primay_teacher' => 'nullable|boolean',
        ];
    }
}
