<?php

namespace App\Http\Requests\Classes;

use App\Http\Requests\BaseRequest;

class LinkClassToRoomRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'class_code' => 'required|string|exists:classes,code',
            'room_code' => 'required|string|exists:rooms,code',
        ];
    }


    
}
