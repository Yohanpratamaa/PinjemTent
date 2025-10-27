<?php

namespace Database\Seeders;

use App\Models\Peminjaman;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PeminjamanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $units = Unit::all();
        $users = User::where('role', 'user')->get();

        if ($units->isEmpty() || $users->isEmpty()) {
            return; // Skip if no units or users exist
        }

        // Generate sample rentals for the last 12 months
        $peminjamans = [];

        for ($monthsAgo = 11; $monthsAgo >= 0; $monthsAgo--) {
            $month = Carbon::now()->subMonths($monthsAgo);

            // Generate 3-15 rentals per month (random)
            $rentalsCount = rand(3, 15);

            for ($i = 0; $i < $rentalsCount; $i++) {
                $user = $users->random();
                $unit = $units->random();

                // Random date within the month
                $tanggalPinjam = $month->copy()->addDays(rand(0, $month->daysInMonth - 1));
                $tanggalKembaliRencana = $tanggalPinjam->copy()->addDays(rand(1, 7));

                // Determine status and actual return date
                $status = ['dikembalikan', 'dipinjam', 'terlambat'][rand(0, 2)];
                $tanggalKembaliAktual = null;

                if ($status === 'dikembalikan') {
                    $tanggalKembaliAktual = $tanggalKembaliRencana->copy()->addDays(rand(-1, 2));
                } elseif ($status === 'terlambat') {
                    $tanggalKembaliAktual = $tanggalKembaliRencana->copy()->addDays(rand(1, 5));
                }

                $peminjamans[] = [
                    'user_id' => $user->id,
                    'unit_id' => $unit->id,
                    'tanggal_pinjam' => $tanggalPinjam,
                    'tanggal_kembali_rencana' => $tanggalKembaliRencana,
                    'tanggal_kembali_aktual' => $tanggalKembaliAktual,
                    'status' => $status,
                    'catatan' => 'Peminjaman ' . $unit->nama_unit . ' oleh ' . $user->name,
                    'created_at' => $tanggalPinjam,
                    'updated_at' => $tanggalKembaliAktual ?? $tanggalPinjam,
                ];
            }
        }

        // Insert in batches to avoid memory issues
        $chunks = array_chunk($peminjamans, 50);
        foreach ($chunks as $chunk) {
            Peminjaman::insert($chunk);
        }
    }
}
