<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseRequest extends FormRequest
{
    /**
     * Return validation errors as JSON response
     */

    public function failedValidation(Validator $validator)
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
