<?php

namespace App\Http\Requests\Event;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEventRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'venue_id' => ['sometimes', 'exists:venues,id'],
            'category_id' => ['sometimes', 'exists:categories,id'],
            'name' => ['sometimes', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'start_time' => ['sometimes', 'date', 'after:now'],
            'end_time' => ['sometimes', 'date', 'after:start_time'],
            'is_active' => ['boolean'],
        ];
    }
}
