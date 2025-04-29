<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Event;
use App\Models\User;
use App\Models\Venue;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition(): array
    {
        $startTime = fake()->dateTimeBetween('+1 day', '+6 months');
        $endTime = clone $startTime;
        $endTime->modify('+'.fake()->numberBetween(1, 4).' hours');

        return [
            'venue_id' => Venue::factory(),
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
            'name' => fake()->sentence(3),
            'description' => fake()->paragraph(3),
            'start_time' => $startTime,
            'end_time' => $endTime,
            'is_active' => fake()->boolean(80), // 80% chance of being active
            'ticket_price' => fake()->randomFloat(2, 10, 500), // Random price between 10 and 500
        ];
    }

    /**
     * Configure the factory to generate inactive events.
     */
    public function inactive(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'is_active' => false,
            ];
        });
    }

    /**
     * Configure the factory to generate past events.
     */
    public function past(): Factory
    {
        return $this->state(function (array $attributes) {
            $startTime = fake()->dateTimeBetween('-6 months', '-1 day');
            $endTime = clone $startTime;
            $endTime->modify('+'.fake()->numberBetween(1, 4).' hours');

            return [
                'start_time' => $startTime,
                'end_time' => $endTime,
                'is_active' => false,
            ];
        });
    }

    /**
     * Configure the factory to generate future events.
     */
    public function future(): Factory
    {
        return $this->state(function (array $attributes) {
            $startTime = fake()->dateTimeBetween('+1 day', '+6 months');
            $endTime = clone $startTime;
            $endTime->modify('+'.fake()->numberBetween(1, 4).' hours');

            return [
                'start_time' => $startTime,
                'end_time' => $endTime,
            ];
        });
    }
}
