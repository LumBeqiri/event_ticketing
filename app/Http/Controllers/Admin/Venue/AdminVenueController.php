<?php

namespace App\Http\Controllers\Admin\Venue;

use App\Http\Controllers\Controller;
use App\Http\Requests\Venue\StoreVenueRequest;
use App\Http\Requests\Venue\UpdateVenueRequest;
use App\Http\Resources\VenueResource;
use App\Models\Venue;

class AdminVenueController extends Controller
{
    public function index()
    {
        $venues = Venue::paginate($this->defaultPerPage);

        return $this->success(VenueResource::collection($venues)->response()->getData(true));
    }

    public function show(Venue $venue)
    {

        return $this->success(new VenueResource($venue));
    }

    public function store(StoreVenueRequest $request)
    {
        $venue = Venue::create($request->validated());

        return $this->success(new VenueResource($venue));
    }

    public function update(Venue $venue, UpdateVenueRequest $request)
    {

        $venue->update($request->validated());

        return $this->success(new VenueResource($venue));
    }

    public function destroy(Venue $venue)
    {

        $venue->delete();

        return $this->success([], 'Venue deleted successfully.');
    }
}
