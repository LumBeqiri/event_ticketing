<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user' => new UserResource($this->whenLoaded('user')),
            'event' => new EventResource($this->whenLoaded('event')),
            'tickets' => TicketResource::collection($this->whenLoaded('tickets')),
            'quantity' => $this->quantity,
            'total_price' => $this->total_price,
            'status' => $this->status,
            'booking_time' => $this->booking_time,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
