<?php

namespace Database\Factories;

use App\Constants\Role;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // // Get or create a trip
        // $trip = Trip::inRandomOrder()->first() ?? Trip::factory()->create();

        // // Get or create a user with the 'user' role
        // $user = User::where('role', Role::USER)->inRandomOrder()->first() ?? User::factory()->create(['role' => Role::USER]);

        // // Calculate the total number of seats available on the bus for this trip
        // $totalSeats = $trip->bus->total_seats;

        // // Generate random and unique seat numbers
        // $seatNumbers = fake()->unique()->randomElements(range(1, $totalSeats), min(4, $totalSeats));
        // shuffle($seatNumbers);
        // $selectedSeatNumbers = array_slice($seatNumbers, 0, min(4, count($seatNumbers)));

        // sort($selectedSeatNumbers);

        // // Calculate the total price based on the fare for each seat
        // $totalPrice = collect($seatNumbers)->sum(function ($seatNumber) use ($trip) {
        //     return $trip->fare_amount;
        // });

        // return [
        //     'user_id' => $user->id,
        //     'trip_id' => $trip->id,
        //     'seat_numbers' => implode(',', $selectedSeatNumbers),
        //     'total_price' => $totalPrice,
        //     'booking_date' => fake()->dateTimeBetween('-30 days', 'now'),
        // ];

        // Get or create a trip
        $trip = Trip::inRandomOrder()->first() ?? Trip::factory()->create();

        // Get or create a user with the 'user' role
        $user = User::where('role', Role::USER)->inRandomOrder()->first() ?? User::factory()->create(['role' => Role::USER]);

        // Generate a random number between 1 and 4 for the number of bookings per user
        $numberOfBookings = fake()->numberBetween(1, 4);

        // Calculate the total number of seats available on the bus for this trip
        $totalSeats = $trip->bus->total_seats;

        // Generate random and unique seat numbers with a maximum based on the randomly chosen number
        $seatNumbers = fake()->unique()->randomElements(range(1, $totalSeats), min($numberOfBookings, $totalSeats));
        shuffle($seatNumbers);
        $selectedSeatNumbers = array_slice($seatNumbers, 0, min($numberOfBookings, count($seatNumbers)));

        // Calculate the total price based on the fare for each seat
        $totalPrice = collect($selectedSeatNumbers)->sum(function ($seatNumber) use ($trip) {
            return $trip->fare_amount;
        });

        return [
            'user_id' => $user->id,
            'trip_id' => $trip->id,
            'seat_numbers' => implode(',', $selectedSeatNumbers),
            'total_price' => $totalPrice,
            'booking_date' => fake()->dateTimeBetween('-30 days', 'now')
        ];
    }
}
