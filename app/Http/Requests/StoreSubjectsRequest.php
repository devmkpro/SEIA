<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreSubjectsRequest extends FormRequest
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
            'curriculum' => ['required', 'string', 'exists:curricula,code'],
            'nome' => ['required', 'string', 'in:artes,biologia,ciencias,educacao-fisica,filosofia,fisica,geografia,historia,ingles,literatura,matematica,portugues,quimica,sociologia,ensino-religioso,other'],
            'carga_horaria' => ['required', 'integer'],
            'carga_horaria_semanal' => ['required', 'integer', 'lte:carga_horaria'],
            'descricao' => ['nullable', 'string'],
            'modalidade' => ['nullable', 'string', 'in:linguagens-e-suas-tecnologias,ciencias-da-natureza-e-suas-tecnologias,ciencias-humanas-e-suas-tecnologias,estudos-literarios,ensino-religioso,parte-diversificada'],
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
