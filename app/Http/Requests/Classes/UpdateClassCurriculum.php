<?php

namespace App\Http\Requests\Classes;

use App\Http\Requests\BaseRequest;

class UpdateClassCurriculum extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'curriculum' => 'required|exists:curricula,code',
            'class' => 'required|exists:classes,code',
        ];
    }
}
