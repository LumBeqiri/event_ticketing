<?php

namespace App\Http\Controllers\Admin\Event;

use App\Http\Controllers\Controller;
use App\Http\Requests\Event\StoreEventRequest;
use App\Http\Requests\Event\UpdateEventRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;

class AdminEventController extends Controller
{
    public function index()
    {
        $events = Event::with(['venue', 'category'])->paginate($this->defaultPerPage);

        return $this->success(EventResource::collection($events)->response()->getData(true));
    }

    public function show(Event $event)
    {
        return $this->success(new EventResource($event));
    }

    public function store(StoreEventRequest $request)
    {
        $event = Event::create($request->validated() + ['user_id' => auth()->id()]);

        return $this->success(new EventResource($event));
    }

    public function update(Event $event, UpdateEventRequest $request)
    {
        $event->update($request->validated());

        return $this->success(new EventResource($event));
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return $this->success([], 'Event deleted successfully.');
    }
}
