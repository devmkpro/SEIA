<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
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
            'zona' => 'nullable|string|max:255|in:U,R',
            'nome_mae' => 'nullable|string|max:255',
            'nome_pai' => 'nullable|string|max:255',
            'tipo_sanguineo' => 'nullable|string|max:255',
            'deficiencia' => 'nullable|boolean',
            'cep' => 'nullable|string|max:255',
        ];
    }
}
