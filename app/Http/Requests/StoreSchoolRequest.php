<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreSchoolRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'city_code' => 'required|exists:cities,ibge_code',
            'state_code' => 'required|exists:states,ibge_code',
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'nullable|celular_com_ddd',
            'landline' => 'nullable|string',
            'zip_code' => 'required|formato_cep',
            'district' => 'required|string',
            'email_responsible' => 'required|email',
            'public' => 'required|boolean',
            'has_education_infant' => 'required|boolean',
            'has_education_fundamental' => 'required|boolean',
            'has_education_medium' => 'required|boolean',
            'has_education_professional' => 'required|boolean',
            'inep' => 'nullable|string',
            'number' => 'nullable|string',
            'street' => 'nullable|string',
            'complement' => 'nullable|string',
            'cnpj' => 'nullable|cnpj',
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
