<?php

namespace Database\Factories;

use App\Models\Trip;
use App\Models\User;
use App\Constants\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SeatAllocation>
 */
class SeatAllocationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Define alphabet range
        $alphabet = range('A', 'L');

        // Get or create a user with the 'user' role
        $user = User::where('role', Role::USER)->inRandomOrder()->first() ?? User::factory()->create(['role' => Role::USER]);

        // Get or create a trip
        $trip = Trip::inRandomOrder()->first() ?? Trip::factory()->create();

        // Conditionally seed seat only for 'user' role
        $seatNumber = $user->role == Role::USER ? fake()->randomElement($alphabet) . fake()->numberBetween(1, 3) : null;

        return [
            'trip_id' => $trip->id,
            'user_id' => $user->id,
            'seat_number' => $seatNumber,
            'return_trip' => fake()->boolean,
        ];
    }
}
