<?php

namespace App\Http\Requests\Rooms;

use App\Http\Requests\BaseRequest;

class UpdateRoomsRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'room_code' => 'required|exists:rooms,code',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ];
    }
}
