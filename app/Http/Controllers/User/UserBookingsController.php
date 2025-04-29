<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserBookingsController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::query()
            ->with(['event', 'tickets'])
            ->where('bookings.user_id', Auth::id())
            ->whereHas('event')
            ->join('events', 'bookings.event_id', '=', 'events.id')
            ->select('bookings.*');

        if ($request->has('status')) {
            $query->where('bookings.status', $request->status);
        }

        if ($request->input('filter') === 'past') {
            $query->where('events.end_time', '<', now());
        } else {
            $query->where('events.end_time', '>=', now());
        }

        $bookings = $query
            ->orderBy('events.start_time', 'asc')
            ->paginate($this->defaultPerPage);

        return $this->success(BookingResource::collection($bookings)->response()->getData(true));
    }

    public function show(Booking $booking)
    {
        $this->authorize('view', [Booking::class, $booking]);

        $booking->load(['event', 'tickets']);

        return $this->success(new BookingResource($booking));
    }
}
