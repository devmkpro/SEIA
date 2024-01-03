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
            'series' => 'required|string|in:educ_infa_cc_0_3,educ_infa_cc_4_5,educ_ini_1_5,educ_ini_6_9,educ_med_1,educ_med_2,educ_med_3,other',
            'modality' => 'required|string|in:bercario,creche,pre_escola,fundamental,medio,eja,educacao_especial,other',
            'weekly_hours' => 'required|numeric|lte:total_hours',
            'total_hours' => 'required|numeric',
            'start_time' => 'required',
            'end_time' => 'required',
            'complementary_information' => 'nullable|string',
            'description' => 'nullable|string',
        ];
    }
}
