<?php

namespace App\Http\Requests\Event;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'venue_id' => ['required', 'exists:venues,id'],
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'start_time' => ['required', 'date', 'after:now'],
            'end_time' => ['required', 'date', 'after:start_time'],
            'is_active' => ['boolean'],
        ];
    }
}
