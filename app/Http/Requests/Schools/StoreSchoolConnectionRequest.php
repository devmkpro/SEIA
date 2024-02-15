<?php

namespace App\Http\Requests\Schools;

use App\Http\Requests\BaseRequest;

class StoreSchoolConnectionRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'username' => 'required|string|exists:users,username',
            'role' => 'required|string|exists:roles,name',
        ];
    }
}
