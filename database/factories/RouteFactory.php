<?php

namespace Database\Factories;

use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Route>
 */
class RouteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Get or create origin and destination locations
        $origin = Location::inRandomOrder()->first() ?? Location::factory()->create();
        $destination = Location::inRandomOrder()->first() ?? Location::factory()->create();

        return [
            'origin' => $origin->id,
            'destination' => $destination->id,
            'distance' => fake()->randomFloat(2, 50, 500),
        ];
    }
}
