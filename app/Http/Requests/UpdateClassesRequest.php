<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateClassesRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'class' => 'required|exists:classes,code',
            'nome' => 'required|string',
            'turno' => 'required|string|in:morning,afternoon,night',
            'modalidade' => 'required|string|in:regular,eja,eja_fundamental,eja_medio',
            'domingo' => 'required|boolean',
            'segunda' => 'required|boolean',
            'terca' => 'required|boolean',
            'quarta' => 'required|boolean',
            'quinta' => 'required|boolean',
            'sexta' => 'required|boolean',
            'sabado' => 'required|boolean',
            'horario_inicio' => 'nullable|date_format:H:i',
            'horario_fim' => 'nullable|date_format:H:i',
            'max_estudantes' => 'required|integer',
            'sala' => 'nullable|string|exists:rooms,code',
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
