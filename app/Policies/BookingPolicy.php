<?php

namespace App\Policies;

use App\Models\User;

class BookingPolicy
{
    public function view(User $user, $booking)
    {
        return $user->id === $booking->user_id;
    }
}
