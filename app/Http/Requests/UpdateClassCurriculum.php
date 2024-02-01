<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateClassCurriculum extends FormRequest
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

    /**
     * Return validation errors as JSON response
     */
    protected function failedValidation(Validator $validator)
    {
        if (request()->bearerToken() || request()->expectsJson()) {
            throw new HttpResponseException(response()->json([
                'errors' => $validator->errors(),
                'status' => true
            ], 422));
        } else {
            throw new HttpResponseException(redirect()->back()->withErrors($validator->errors())->withInput());
        }
    }
}
