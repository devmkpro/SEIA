<?php

namespace App\Http\Requests\Notifications;

use App\Http\Requests\BaseRequest;

class ChangeConnectionRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'school_request' => 'required|string|exists:school_connection_requests,uuid',
            'notification' => 'required|string|exists:notifications,code',
            'status' => 'required|string|in:accepted,rejected',
        ];
    }
}
