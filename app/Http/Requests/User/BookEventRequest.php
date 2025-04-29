<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class BookEventRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
            'throttle' => 'Too many booking attempts. Please wait before trying again.',
        ];
    }

    public function rules()
    {
        return [
            'quantity' => ['required', 'integer', 'min:1'],
            'event_id' => ['required', 'exists:events,id'],
        ];
    }
}
