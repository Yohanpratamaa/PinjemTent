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
        // Seed basic data first (categories, admin users)
        $this->call([
            AdminSeeder::class,
            KategoriSeeder::class,
            UnitSeeder::class,
        ]);

        // Create test users with phone field
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '081234567892',
            'role' => 'user', // Explicitly set role
        ]);

        // Create additional test users if needed
        User::factory(5)->create([
            'role' => 'user',
        ]);

        // Add specific test users for development
        if (app()->environment('local')) {
            $this->call([
                TestUsersSeeder::class,
            ]);
        }

        // Seed sample rental data after users and units exist
        $this->call([
            PeminjamanSeeder::class,
        ]);
    }
}
