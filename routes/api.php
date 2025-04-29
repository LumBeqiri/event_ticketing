<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\User\Profile\UserProfileController;
use App\Http\Controllers\User\UserBookEvent;
use App\Http\Controllers\User\UserBookingsController;
use App\Http\Controllers\User\UserEventController;
use Illuminate\Support\Facades\Route;

Route::post('/login', LoginController::class);
Route::post('/register', RegisterController::class);

Route::group(['middleware' => ['auth:sanctum'], 'prefix' => 'user'], function () {
    // Event routes
    Route::get('events', [UserEventController::class, 'index']);
    Route::get('events/{event}', [UserEventController::class, 'show']);
    Route::post('events-book', [UserBookEvent::class, 'bookEvent'])
        ->middleware(['throttle:3,1']); // 3 attempts per 1 minute

    // Profile routes
    Route::get('profile', [UserProfileController::class, 'show']);
    Route::put('profile', [UserProfileController::class, 'update']);
    Route::get('profile/categories', [UserProfileController::class, 'getCategories']);

    // Booking routes
    Route::get('bookings', [UserBookingsController::class, 'index']);
    Route::get('bookings/{booking}', [UserBookingsController::class, 'show']);
});
