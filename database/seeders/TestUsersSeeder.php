<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class TestUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID'); // Indonesian locale for realistic names

        // Create specific test users for different scenarios
        $specificTestUsers = [
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'phone' => '081234567893',
                'password' => Hash::make('password'),
                'role' => 'user',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'phone' => '081234567894',
                'password' => Hash::make('password'),
                'role' => 'user',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budi@example.com',
                'phone' => '087654321098',
                'password' => Hash::make('password'),
                'role' => 'user',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Siti Nurhaliza',
                'email' => 'siti@example.com',
                'phone' => '085678901234',
                'password' => Hash::make('password'),
                'role' => 'user',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Ahmad Reza',
                'email' => 'ahmad@example.com',
                'phone' => '081567890123',
                'password' => Hash::make('password'),
                'role' => 'user',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Dewi Lestari',
                'email' => 'dewi@example.com',
                'phone' => '089012345678',
                'password' => Hash::make('password'),
                'role' => 'user',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Test User Premium',
                'email' => 'premium@test.com',
                'phone' => '081999888777',
                'password' => Hash::make('password'),
                'role' => 'user',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Test User Unverified',
                'email' => 'unverified@test.com',
                'phone' => null, // Testing user without phone
                'password' => Hash::make('password'),
                'role' => 'user',
                'email_verified_at' => null, // Testing unverified user
            ],
            [
                'name' => 'Manager Test',
                'email' => 'manager@test.com',
                'phone' => '081234567899',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@test.com',
                'phone' => '081111222333',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ],
        ];

        // Create specific test users
        foreach ($specificTestUsers as $userData) {
            User::firstOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }

        // Create additional random users for more realistic data
        for ($i = 1; $i <= 20; $i++) {
            $firstName = $faker->firstName;
            $lastName = $faker->lastName;
            $name = $firstName . ' ' . $lastName;
            $email = strtolower($firstName . '.' . $lastName . $i . '@gmail.com');

            // Generate Indonesian phone numbers
            $phoneProviders = ['081', '082', '083', '085', '087', '088', '089'];
            $provider = $faker->randomElement($phoneProviders);
            $phone = $provider . $faker->numberBetween(10000000, 99999999);

            User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => $name,
                    'email' => $email,
                    'phone' => $phone,
                    'password' => Hash::make('password'),
                    'role' => 'user',
                    'email_verified_at' => $faker->boolean(85) ? now() : null, // 85% verified
                    'created_at' => $faker->dateTimeBetween('-2 years', 'now'),
                ]
            );
        }

        // Create some additional admin users
        $adminUsers = [
            [
                'name' => 'Admin Inventory',
                'email' => 'inventory@admin.com',
                'phone' => '081444555666',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Admin Customer Service',
                'email' => 'cs@admin.com',
                'phone' => '081777888999',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ],
        ];

        foreach ($adminUsers as $userData) {
            User::firstOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }

        $this->command->info('Test users created successfully!');
        $this->command->info('Regular Users: ' . User::where('role', 'user')->count());
        $this->command->info('Admin Users: ' . User::where('role', 'admin')->count());
        $this->command->info('Total Users: ' . User::count());
    }
}
