<?php

namespace Database\Seeders;

use App\Models\User;
use App\Constants\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'phone' => '+8801702020202',
            'role' => Role::ADMIN,
        ]);

        User::factory()->count(5)->create();
    }
}
