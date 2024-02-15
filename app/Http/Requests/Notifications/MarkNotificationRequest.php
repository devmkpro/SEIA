<?php

namespace App\Http\Requests\Notifications;

use App\Http\Requests\BaseRequest;
class MarkNotificationRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'notification' => 'required|exists:notifications,code',
        ];
    }
}
