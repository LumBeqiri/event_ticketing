<?php

use App\Http\Controllers\Admin\Booking\AdminBookingController;
use App\Http\Controllers\Admin\Event\AdminEventController;
use App\Http\Controllers\Admin\Ticket\AdminTicketController;
use App\Http\Controllers\Admin\Venue\AdminVenueController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('venues', [\App\Http\Controllers\Admin\Venue\AdminVenueController::class, 'index']);
    Route::get('venues/{venue}', [AdminVenueController::class, 'show']);
    Route::post('venues', [AdminVenueController::class, 'store']);
    Route::put('venues/{venue}', [AdminVenueController::class, 'update']);
    Route::delete('venues/{venue}', [AdminVenueController::class, 'destroy']);

    Route::get('events', [AdminEventController::class, 'index']);
    Route::get('events/{event}', [AdminEventController::class, 'show']);
    Route::post('events', [AdminEventController::class, 'store']);
    Route::put('events/{event}', [AdminEventController::class, 'update']);
    Route::delete('events/{event}', [AdminEventController::class, 'destroy']);

    Route::apiResource('tickets', AdminTicketController::class);

    Route::get('tickets/{ticket}', [AdminTicketController::class, 'show']);
    Route::post('eventicketsts', [AdminTicketController::class, 'store']);
    Route::put('tickets/{ticket}', [AdminTicketController::class, 'update']);
    Route::delete('tickets/{ticket}', [AdminTicketController::class, 'destroy']);

    // Admin Booking Routes
    Route::get('bookings', [AdminBookingController::class, 'index']);
    Route::get('bookings/{booking}', [AdminBookingController::class, 'show']);
    Route::put('bookings/{booking}', [AdminBookingController::class, 'update']);
    Route::delete('bookings/{booking}', [AdminBookingController::class, 'destroy']);
});
