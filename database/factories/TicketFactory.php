<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TicketFactory extends Factory
{
    protected $model = Ticket::class;

    public function definition(): array
    {
        $status = fake()->randomElement(['reserved', 'paid', 'cancelled']);

        return [
            'booking_id' => Booking::factory(),

            'price' => fake()->numberBetween(50, 500),
            'seat_info' => 'Row '.fake()->randomLetter().', Seat '.fake()->numberBetween(1, 100),
            'status' => $status,

            'booking_time' => now(),
            'payment_time' => $status === 'paid' ? fake()->dateTimeBetween('-1 month', 'now') : null,

            'ticket_number' => strtoupper(Str::random(8)),
        ];
    }

    /**
     * Configure the factory to generate paid tickets.
     */
    public function paid(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'paid',
                'payment_time' => fake()->dateTimeBetween('-1 month', 'now'),
            ];
        });
    }

    /**
     * Configure the factory to generate cancelled tickets.
     */
    public function cancelled(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'cancelled',
                'payment_time' => null,
            ];
        });
    }
}
