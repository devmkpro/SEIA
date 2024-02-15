<?php

namespace App\Http\Requests\Schools;

use App\Http\Requests\BaseRequest;

class SchoolHomeChangeRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'school' => 'required|exists:schools,code',
        ];
    }
}
