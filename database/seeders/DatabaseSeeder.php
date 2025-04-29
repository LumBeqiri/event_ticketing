<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Category;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Venue;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Role::create(['name' => 'admin', 'guard_name' => 'api']);
        Role::create(['name' => 'user', 'guard_name' => 'api']);
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole('admin');

        $users = User::factory()->count(5)->create();

        $categories = Category::factory()->count(5)->create([
            'name' => fn () => fake()->unique()->randomElement([
                'Concert',
                'Sports',
                'Theater',
                'Conference',
                'Exhibition',
            ]),
        ]);

        $venues = Venue::factory()->count(3)->create();

        $events = collect();

        $events = $events->concat(
            Event::factory()->count(5)->create([
                'user_id' => $admin->id,
                'category_id' => fn () => $categories->random()->id,
                'venue_id' => fn () => $venues->random()->id,
            ])
        );

        $events = $events->concat(
            Event::factory()->past()->count(2)->create([
                'user_id' => $admin->id,
                'category_id' => fn () => $categories->random()->id,
                'venue_id' => fn () => $venues->random()->id,
            ])
        );

        foreach ($users as $user) {
            $userBookings = Booking::factory()
                ->count(fake()->numberBetween(1, 3))
                ->create([
                    'user_id' => $user->id,
                    'event_id' => fn () => $events->random()->id,
                ]);

            // Create tickets for each booking
            foreach ($userBookings as $booking) {
                Ticket::factory()
                    ->count($booking->quantity)
                    ->create([
                        'status' => $booking->status,
                        'booking_time' => $booking->booking_time,
                        'payment_time' => $booking->status === 'paid' ? $booking->updated_at : null,
                    ]);
            }
        }
    }
}
