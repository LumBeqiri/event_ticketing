<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'ticket_number' => $this->ticket_number,
            'price' => $this->price,
            'status' => $this->status,
            'seat_info' => $this->seat_info,
            'booking_time' => $this->booking_time,
            'payment_time' => $this->payment_time,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
