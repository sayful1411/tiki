<?php

namespace Database\Seeders;

use App\Models\SeatAllocation;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SeatAllocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SeatAllocation::factory()->count(20)->create();
    }
}
