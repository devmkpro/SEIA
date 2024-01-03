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
            'name' => ['required', 'string', 'in:artes,biologia,ciencias,educacao-fisica,filosofia,fisica,geografia,historia,ingles,literatura,matematica,portugues,quimica,sociologia,ensino-religioso,other'],
            'ch' => ['required', 'integer'],
            'ch_week' => ['required', 'integer'],
            'description' => ['nullable', 'string'],
            'modality' => ['nullable', 'string', 'in:linguagens-e-suas-tecnologias,ciencias-da-natureza-e-suas-tecnologias,ciencias-humanas-e-suas-tecnologias,estudos-literarios,ensino-religioso,parte-diversificada'],
        ];
    }
}
