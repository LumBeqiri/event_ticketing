<?php

namespace App\Http\Controllers\Admin\Ticket;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ticket\UpdateTicketRequest;
use App\Http\Resources\TicketResource;
use App\Models\Ticket;

class AdminTicketController extends Controller
{
    /**
     * Display a listing of tickets.
     */
    public function index()
    {
        $tickets = Ticket::with(['booking'])->paginate($this->defaultPerPage);

        return $this->success(TicketResource::collection($tickets)->response()->getData(true));
    }

    /**
     * Display the specified ticket.
     */
    public function show(Ticket $ticket)
    {
        $ticket->load('booking');

        return $this->success(new TicketResource($ticket));
    }

    /**
     * Update the specified ticket.
     */
    public function update(UpdateTicketRequest $request, Ticket $ticket)
    {
        $ticket->update($request->validated());

        return $this->success(new TicketResource($ticket), 'Ticket updated successfully.');
    }

    /**
     * Remove the specified ticket.
     */
    public function destroy(Ticket $ticket)
    {
        $ticket->delete();

        return $this->success([], 'Ticket deleted successfully.');
    }
}
