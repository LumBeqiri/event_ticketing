<?php

namespace App\Http\Requests\Ticket;

use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'booking_id' => ['required', 'exists:bookings,id'],
            'price' => ['required', 'numeric', 'min:0'],
            'seat_info' => ['nullable', 'string'],
            'status' => ['required', 'in:reserved,paid,cancelled'],
            'payment_time' => ['nullable', 'date'],
            'ticket_number' => ['required', 'string', 'unique:tickets,ticket_number'],
        ];
    }
}
