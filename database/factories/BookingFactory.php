<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{
    protected $model = Booking::class;

    public function definition(): array
    {
        $quantity = fake()->numberBetween(1, 5);
        $pricePerTicket = fake()->numberBetween(50, 500);

        return [
            'user_id' => User::factory(),
            'event_id' => Event::factory(),
            'quantity' => $quantity,
            'total_price' => $quantity * $pricePerTicket,
            'booking_time' => fake()->dateTimeBetween('-1 month', 'now'),
            'status' => fake()->randomElement(['reserved', 'paid', 'cancelled']),
        ];
    }

    /**
     * Configure the factory to generate paid bookings.
     */
    public function paid(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'paid',
            ];
        });
    }

    /**
     * Configure the factory to generate cancelled bookings.
     */
    public function cancelled(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'cancelled',
            ];
        });
    }
}
