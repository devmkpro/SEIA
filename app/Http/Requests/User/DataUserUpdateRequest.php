<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest;

class DataUserUpdateRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'phone' => ['required', 'string', 'max:20'],
            'birth_date' => ['required', 'date', 'date_format:Y-m-d'],
            'country' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'string', 'max:255'],
            'district' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:255'],
            'zip_code' => ['required', 'string', 'max:255'],
            'cpf_responsible' => ['required', 'string', 'max:255'],
        ];
    }
}
