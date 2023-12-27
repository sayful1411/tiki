<?php

namespace Database\Factories;

use App\Models\Bus;
use App\Models\Location;
use App\Models\Route;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Trip>
 */
class TripFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Get or create a bus
        $bus = Bus::inRandomOrder()->first() ?? Bus::factory()->create();

        // Get or create a route
        $route = Route::inRandomOrder()->first() ?? Route::factory()->create();

        return [
            'bus_id' => $bus->id,
            'route_id' => $route->id,
            'trip_date' => fake()->date,
            'departure_time' => fake()->time(),
            'arrival_time' => fake()->time(),
            'fare_amount' => fake()->randomFloat(2, 100, 10000),
            'round_trip' => fake()->boolean,
            'return_date' => fake()->boolean ? fake()->date : null,
        ];
    }
}
