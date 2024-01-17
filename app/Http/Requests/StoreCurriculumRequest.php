<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCurriculumRequest extends FormRequest
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
            'serie' => 'required|string|in:educ_infa_cc_0_3,educ_infa_cc_4_5,educ_ini_1_5,educ_ini_6_9,educ_med_1,educ_med_2,educ_med_3,courses,other',
            'modalidade' => 'required|string|in:bercario,creche,pre_escola,fundamental,medio,eja,educacao_especial,tecnico,other',
            'horas_semanais' => 'required|numeric|lte:horas_totais',
            'horas_totais' => 'required|numeric',
            'tempo_padrao_de_aula' => 'required|numeric',
            'hora_início' => 'required',
            'hora_final' => 'required',
            'informacoes_complementares' => 'nullable|string',
            'descricao' => 'nullable|string',
            'turno' => 'required|string|in:morning,afternoon,night,integral,other',
        ];
    }

}
