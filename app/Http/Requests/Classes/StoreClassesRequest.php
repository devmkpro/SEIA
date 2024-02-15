<?php

namespace App\Http\Requests\Classes;

use App\Http\Requests\BaseRequest;

class StoreClassesRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
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
}
