<?php

namespace Database\Factories;

use App\Models\Bus;
use App\Models\Location;
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
        return [
            'bus_id' => Bus::factory()->create()->id,
            'starting_location_id' => Location::factory()->create()->id,
            'ending_location_id' => Location::factory()->create()->id,
            'trip_date' => fake()->date,
            'starting_time' => fake()->time(),
            'arrival_time' => fake()->time(),
            'round_trip' => fake()->boolean,
            'return_date' => fake()->boolean ? fake()->date : null,
        ];
    }
}
