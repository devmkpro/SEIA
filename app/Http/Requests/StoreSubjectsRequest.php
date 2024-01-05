<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
}
