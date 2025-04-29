<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\BookEventRequest;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserBookEvent extends Controller
{
    public function bookEvent(BookEventRequest $request)
    {
        $validated = $request->validated();

        $event = Event::findOrFail($validated['event_id']);

        if (! $event->is_active) {
            return $this->error('Event is not available for booking.', 400);
        }

        if ($event->end_time <= now()) {
            return $this->error('Event has already ended.', 400);
        }

        return DB::transaction(function () use ($event, $validated) {
            $event = Event::with(['venue'])
                ->lockForUpdate()
                ->findOrFail($validated['event_id']);

            $bookedTickets = $event->bookings()
                ->where('status', '!=', 'cancelled')
                ->sum('quantity');

            $availableSeats = $event->venue->capacity - $bookedTickets;

            if ($availableSeats < $validated['quantity']) {
                return $this->error('Not enough seats available. Available seats: '.$availableSeats, 400);
            }
            $total_price = $validated['quantity'] * $event->ticket_price;

            $booking = $event->bookings()->create([
                'user_id' => Auth::id(),
                'quantity' => $validated['quantity'],
                'total_price' => $total_price,
                'booking_time' => now(),
                'status' => 'reserved',
            ]);

            for ($i = 0; $i < $validated['quantity']; $i++) {
                $booking->tickets()->create([
                    'price' => $event->ticket_price,
                    'status' => 'reserved',
                    'booking_time' => now(),
                ]);
            }

            $booking->load(['tickets']);

            return $this->success(['booking' => $booking], 'Booking created successfully');
        });
    }
}
