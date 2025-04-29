<?php

namespace Database\Factories;

use App\Models\Venue;
use Illuminate\Database\Eloquent\Factories\Factory;

class VenueFactory extends Factory
{
    protected $model = Venue::class;

    public function definition(): array
    {
        return [
            'name' => fake()->company().' '.fake()->randomElement(['Arena', 'Stadium', 'Theater', 'Hall', 'Center']),
            'capacity' => fake()->numberBetween(100, 50000),
            'location' => fake()->address(),
        ];
    }
}
