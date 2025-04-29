<?php

namespace App\Http\Requests\Ticket;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTicketRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'booking_id' => ['sometimes', 'exists:bookings,id'],
            'price' => ['sometimes', 'numeric', 'min:0'],
            'seat_info' => ['nullable', 'string'],
            'status' => ['sometimes', 'in:reserved,paid,cancelled'],
            'payment_time' => ['nullable', 'date'],
            'ticket_number' => ['sometimes', 'string', 'unique:tickets,ticket_number,'.$this->ticket->id],
        ];
    }
}
