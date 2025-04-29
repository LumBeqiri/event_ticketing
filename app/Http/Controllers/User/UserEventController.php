<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\EventResource;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserEventController extends Controller
{
    /**
     * Browse upcoming events with optional filtering
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $preferredCategoryIds = $user->preferredCategories()->pluck('categories.id');

        $query = Event::query()
            ->with(['venue', 'category'])
            ->where('is_active', true)
            ->where('end_time', '>', now());

        if ($preferredCategoryIds->isNotEmpty()) {
            $query->orderByRaw('CASE 
                WHEN category_id IN ('.$preferredCategoryIds->implode(',').') THEN 0 
                ELSE 1 
            END');
        }

        $query->orderBy('start_time');

        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->has('venue_id')) {
            $query->where('venue_id', $request->venue_id);
        }

        if ($request->has('start_date')) {
            $query->where('start_time', '>=', $request->start_date);
        }

        if ($request->has('end_date')) {
            $query->where('end_time', '<=', $request->end_date);
        }

        $events = $query->paginate($this->defaultPerPage);

        return $this->success(EventResource::collection($events)->response()->getData(true));
    }

    /**
     * Display the specified event.
     */
    public function show(Event $event)
    {
        if (! $event->is_active) {
            return $this->error('Event not found.', 404);
        }

        $event->load(['venue', 'category']);

        return $this->success(new EventResource($event));
    }
}
