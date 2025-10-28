<?php

namespace Database\Seeders;

use App\Models\Peminjaman;
use App\Models\User;
use App\Models\Unit;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TestRentalsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get test user (create if not exists)
        $user = User::firstOrCreate([
            'email' => 'user1@test.com'
        ], [
            'name' => 'User Test 1',
            'phone' => '081234567893',
            'password' => bcrypt('password'),
            'role' => 'user',
            'email_verified_at' => now(),
        ]);

        // Get some units
        $units = Unit::take(3)->get();

        if ($units->count() === 0) {
            $this->command->error('No units found. Please run UnitsSeeder first.');
            return;
        }

        $testRentals = [
            // Active rental - not late
            [
                'user_id' => $user->id,
                'unit_id' => $units[0]->id,
                'kode_peminjaman' => 'TEST-001',
                'jumlah' => 1,
                'tanggal_pinjam' => Carbon::now()->subDays(2),
                'tanggal_kembali_rencana' => Carbon::now()->addDays(3),
                'status' => 'dipinjam',
                'harga_sewa_total' => 150000,
                'total_bayar' => 150000,
                'catatan_peminjam' => 'Test rental aktif'
            ],
            // Late rental - overdue
            [
                'user_id' => $user->id,
                'unit_id' => $units[1]->id,
                'kode_peminjaman' => 'TEST-002',
                'jumlah' => 1,
                'tanggal_pinjam' => Carbon::now()->subDays(7),
                'tanggal_kembali_rencana' => Carbon::now()->subDays(2), // 2 days overdue
                'status' => 'dipinjam',
                'harga_sewa_total' => 200000,
                'denda_total' => 20000, // 2 days * 10000
                'total_bayar' => 220000,
                'catatan_peminjam' => 'Test rental terlambat'
            ],
            // Completed rental
            [
                'user_id' => $user->id,
                'unit_id' => $units[2]->id,
                'kode_peminjaman' => 'TEST-003',
                'jumlah' => 2,
                'tanggal_pinjam' => Carbon::now()->subDays(10),
                'tanggal_kembali_rencana' => Carbon::now()->subDays(7),
                'tanggal_kembali_aktual' => Carbon::now()->subDays(6),
                'status' => 'dikembalikan',
                'harga_sewa_total' => 300000,
                'total_bayar' => 300000,
                'catatan_peminjam' => 'Test rental selesai'
            ],
            // Pending rental
            [
                'user_id' => $user->id,
                'unit_id' => $units[0]->id,
                'kode_peminjaman' => 'TEST-004',
                'jumlah' => 1,
                'tanggal_pinjam' => Carbon::now()->addDays(1),
                'tanggal_kembali_rencana' => Carbon::now()->addDays(4),
                'status' => 'pending',
                'harga_sewa_total' => 120000,
                'total_bayar' => 120000,
                'catatan_peminjam' => 'Test rental pending'
            ]
        ];

        foreach ($testRentals as $rental) {
            Peminjaman::firstOrCreate(
                ['kode_peminjaman' => $rental['kode_peminjaman']],
                $rental
            );
        }

        $this->command->info('Test rentals created successfully!');
        $this->command->info('- 1 active rental (not late)');
        $this->command->info('- 1 late rental (2 days overdue)');
        $this->command->info('- 1 completed rental');
        $this->command->info('- 1 pending rental');
    }
}
