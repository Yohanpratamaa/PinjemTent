<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create test users for different scenarios
        $testUsers = [
            [
                'name' => 'User Test 1',
                'email' => 'user1@test.com',
                'phone' => '081234567893',
                'password' => Hash::make('password'),
                'role' => 'user',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'User Test 2',
                'email' => 'user2@test.com',
                'phone' => '081234567894',
                'password' => Hash::make('password'),
                'role' => 'user',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'User Test Tanpa Phone',
                'email' => 'user3@test.com',
                'phone' => null, // Testing user without phone
                'password' => Hash::make('password'),
                'role' => 'user',
                'email_verified_at' => null, // Testing unverified user
            ],
            [
                'name' => 'Admin Test',
                'email' => 'admintest@test.com',
                'phone' => '081234567895',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ],
        ];

        foreach ($testUsers as $userData) {
            User::firstOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }

        $this->command->info('Test users created successfully!');
    }
}
