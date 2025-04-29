<?php

namespace App\Http\Controllers\Admin\Booking;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use Illuminate\Http\Request;

class AdminBookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['user', 'event', 'tickets'])
            ->orderBy('created_at', 'desc')
            ->paginate($this->defaultPerPage);

        return $this->success(BookingResource::collection($bookings)->response()->getData(true));
    }

    public function show(Booking $booking)
    {
        $booking->load(['user', 'event', 'tickets']);

        return $this->success(new BookingResource($booking));
    }

    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:reserved,paid,cancelled'],
        ]);

        $booking->update($validated);
        $booking->load(['user', 'event', 'tickets']);

        return $this->success(new BookingResource($booking));
    }

    public function destroy(Booking $booking)
    {
        $booking->tickets()->update(['status' => 'cancelled']);

        $booking->update(['status' => 'cancelled']);

        return $this->success(new BookingResource($booking), 'Booking cancelled successfully.');
    }
}
