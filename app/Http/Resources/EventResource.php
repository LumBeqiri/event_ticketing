<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'is_active' => $this->is_active,
            'venue' => new VenueResource($this->whenLoaded('venue')),
            'category' => new CategoryResource($this->whenLoaded('category')),
            'user' => new UserResource($this->whenLoaded('user')),
            'price' => $this->ticket_price,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
