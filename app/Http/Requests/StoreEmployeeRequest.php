<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreEmployeeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nome' => 'required|string|max:255',
            'celular' => 'required|string|max:255|celular_com_ddd',
            'email' => 'required|string|max:255|unique:users,email',
            'telefone_fixo' => 'nullable|string|max:255|telefone_com_ddd',
            'cpf' => 'required|string|max:255|cpf_ou_cnpj',
            'rg' => 'required|string|max:255',
            'inep' => 'nullable|string|max:255',
            'data_nascimento' => 'required|date',
            'genero' => 'required|string|max:255|in:M,F,NB',
            'naturalidade' => 'required|string|max:255',
            'logradouro' => 'nullable|string|max:255',
            'bairro' => 'required|string|max:255',
            'estado' => 'required|string|exists:states,ibge_code',
            'cidade' => 'required|string|exists:cities,ibge_code',
            'estado_nascimento' => 'required|string|exists:states,ibge_code',
            'cidade_nascimento' => 'required|string|exists:cities,ibge_code',
            'numero' => 'nullable|string|max:255',
            'zona' => 'required|string|max:255|in:U,R',
            'nome_mae' => 'nullable|string|max:255',
            'nome_pai' => 'nullable|string|max:255',
            'tipo_sanguineo' => 'nullable|string|max:255',
            'deficiencia' => 'nullable|boolean',
            'cep' => 'required|string|max:255',
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
