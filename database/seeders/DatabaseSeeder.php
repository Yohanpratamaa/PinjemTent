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
        $this->command->info('🌱 Starting database seeding...');

        // Seed basic data first (categories, admin users)
        $this->command->info('📂 Seeding categories...');
        $this->call([
            KategoriSeeder::class,
        ]);

        $this->command->info('👤 Seeding admin users...');
        $this->call([
            AdminSeeder::class,
        ]);

        $this->command->info('🎒 Seeding units and equipment...');
        $this->call([
            UnitSeeder::class,
        ]);

        // Create basic test user
        $this->command->info('👥 Creating basic test users...');
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '081234567892',
            'role' => 'user',
            'email_verified_at' => now(),
        ]);

        // Create additional test users with factory
        User::factory(3)->create([
            'role' => 'user',
        ]);

        // Add comprehensive test users for development
        if (app()->environment(['local', 'testing'])) {
            $this->command->info('🧪 Adding comprehensive test users...');
            $this->call([
                TestUsersSeeder::class,
            ]);
        }

        // Seed sample rental data after users and units exist
        $this->command->info('📋 Seeding rental history...');
        $this->call([
            PeminjamanSeeder::class,
        ]);

        // Seed cart data for active users
        $this->command->info('🛒 Seeding shopping carts...');
        $this->call([
            CartSeeder::class,
        ]);

        // Seed notifications for users and admins
        $this->command->info('🔔 Seeding notifications...');
        $this->call([
            NotificationSeeder::class,
        ]);

        $this->command->info('✅ Database seeding completed successfully!');
        $this->command->info('');
        $this->command->info('📊 Summary:');
        $this->command->info('Categories: ' . \App\Models\Kategori::count());
        $this->command->info('Units/Equipment: ' . \App\Models\Unit::count());
        $this->command->info('Users: ' . \App\Models\User::count());
        $this->command->info('- Regular Users: ' . \App\Models\User::where('role', 'user')->count());
        $this->command->info('- Admin Users: ' . \App\Models\User::where('role', 'admin')->count());
        $this->command->info('Rentals: ' . \App\Models\Peminjaman::count());
        $this->command->info('Cart Items: ' . \App\Models\Cart::count());
        $this->command->info('Notifications: ' . \App\Models\Notification::count());
        $this->command->info('');
        $this->command->info('🔐 Default Login Credentials:');
        $this->command->info('Admin: admin@example.com / password');
        $this->command->info('User: test@example.com / password');
        $this->command->info('Other test users: check TestUsersSeeder for more accounts');
    }
}
