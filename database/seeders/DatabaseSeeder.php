<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed admin users first
        $this->call([
            AdminSeeder::class,
        ]);

        // Create test users
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => 'user', // Explicitly set role
        ]);

        // Create additional test users if needed
        // User::factory(10)->create();
    }
}
