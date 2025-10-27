<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default admin user
        User::firstOrCreate(
            ['email' => 'admin@pinjemtent.com'],
            [
                'name' => 'Administrator',
                'email' => 'admin@pinjemtent.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // You can add more admin users here if needed
        User::firstOrCreate(
            ['email' => 'superadmin@pinjemtent.com'],
            [
                'name' => 'Super Administrator',
                'email' => 'superadmin@pinjemtent.com',
                'password' => Hash::make('superpassword'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );
    }
}
