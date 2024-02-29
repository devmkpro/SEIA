<?php

namespace App\Http\Requests\Classes;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class LinkClassToRoomRequest extends FormRequest
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

    /**
     * Return validation errors as JSON response
     */

     protected function failedValidation(Validator $validator)
     {
         if (request()->bearerToken() || request()->expectsJson()) {
             throw new HttpResponseException(response()->json([
                 $validator->errors(),
             ], 422));
         } else {
             throw new HttpResponseException(redirect()->back()->withErrors($validator->errors())->withInput());
         }
     }

    
}
