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

        // Generate comprehensive sample rentals
        $peminjamans = [];

        // Generate rentals for the last 6 months with realistic patterns
        for ($monthsAgo = 5; $monthsAgo >= 0; $monthsAgo--) {
            $month = Carbon::now()->subMonths($monthsAgo);

            // More rentals in recent months
            $rentalsCount = $monthsAgo === 0 ? rand(20, 30) : rand(8, 15);

            for ($i = 0; $i < $rentalsCount; $i++) {
                $user = $users->random();
                $unit = $units->random();

                // Random date within the month, with higher frequency on weekends
                $day = rand(1, $month->daysInMonth);
                $tanggalPinjam = $month->copy()->day($day);

                // Adjust for weekend patterns (more camping on weekends)
                if ($tanggalPinjam->isWeekend()) {
                    $durationDays = rand(2, 5); // Longer trips on weekends
                } else {
                    $durationDays = rand(1, 3); // Shorter weekday trips
                }

                $tanggalKembaliRencana = $tanggalPinjam->copy()->addDays($durationDays);

                // Determine status based on realistic probabilities
                $statusRand = rand(1, 100);
                if ($monthsAgo >= 2) {
                    // Older rentals are mostly completed
                    $status = $statusRand <= 85 ? 'dikembalikan' : ($statusRand <= 95 ? 'terlambat' : 'dibatalkan');
                } elseif ($monthsAgo === 1) {
                    // Last month mix
                    $status = $statusRand <= 70 ? 'dikembalikan' : ($statusRand <= 85 ? 'terlambat' : ($statusRand <= 95 ? 'dipinjam' : 'dibatalkan'));
                } else {
                    // Current month - many active rentals
                    $status = $statusRand <= 40 ? 'dikembalikan' : ($statusRand <= 55 ? 'dipinjam' : ($statusRand <= 70 ? 'pending' : 'dibatalkan'));
                }

                $tanggalKembaliAktual = null;

                // Set actual return dates based on status
                if ($status === 'dikembalikan') {
                    // Most returned on time, some early, few late
                    $returnVariation = rand(-1, 2);
                    $tanggalKembaliAktual = $tanggalKembaliRencana->copy()->addDays($returnVariation);
                } elseif ($status === 'terlambat') {
                    // Late returns
                    $lateDays = rand(1, 7);
                    $tanggalKembaliAktual = $tanggalKembaliRencana->copy()->addDays($lateDays);
                }

                // Realistic quantity based on unit type
                $jumlah = $this->getRealisticQuantity($unit);

                // Calculate pricing
                $hargaSewaPerHari = $unit->harga_sewa_per_hari ?? 50000;
                $jumlahHari = $tanggalPinjam->diffInDays($tanggalKembaliRencana) + 1;
                $hargaSewaTotal = $hargaSewaPerHari * $jumlahHari * $jumlah;

                // Calculate late fees
                $dendaTotal = 0;
                if ($status === 'terlambat' && $tanggalKembaliAktual) {
                    $hariTerlambat = max(0, $tanggalKembaliAktual->diffInDays($tanggalKembaliRencana));
                    $dendaPerHari = $unit->denda_per_hari ?? 10000;
                    $dendaTotal = $hariTerlambat * $dendaPerHari * $jumlah;
                }

                $totalBayar = $hargaSewaTotal + $dendaTotal;

                // Generate realistic notes
                $catatanPeminjam = $this->generateUserNotes($unit, $jumlah, $durationDays);
                $catatanAdmin = $this->generateAdminNotes($status, $tanggalKembaliAktual, $tanggalKembaliRencana);

                $peminjamans[] = [
                    'user_id' => $user->id,
                    'unit_id' => $unit->id,
                    'kode_peminjaman' => 'PJM-' . $tanggalPinjam->format('Ymd') . '-' . str_pad(($monthsAgo * 100 + $i + 1), 4, '0', STR_PAD_LEFT),
                    'jumlah' => $jumlah,
                    'tanggal_pinjam' => $tanggalPinjam,
                    'tanggal_kembali_rencana' => $tanggalKembaliRencana,
                    'tanggal_kembali_aktual' => $tanggalKembaliAktual,
                    'status' => $status,
                    'rental_status' => $status === 'pending' ? 'pending' : 'approved',
                    'rental_approved_at' => $status !== 'pending' ? $tanggalPinjam->copy()->addHours(rand(1, 24)) : null,
                    'rental_approved_by' => $status !== 'pending' ? \App\Models\User::where('role', 'admin')->first()?->id : null,
                    'return_status' => $status === 'dikembalikan' ? 'approved' : 'not_requested',
                    'return_requested_at' => $status === 'dikembalikan' ? $tanggalKembaliAktual?->subHours(rand(1, 6)) : null,
                    'approved_return_at' => $status === 'dikembalikan' ? $tanggalKembaliAktual : null,
                    'approved_by' => $status === 'dikembalikan' ? \App\Models\User::where('role', 'admin')->first()?->id : null,
                    'harga_sewa_total' => $hargaSewaTotal,
                    'denda' => $dendaTotal,
                    'hari_terlambat' => $status === 'terlambat' && $tanggalKembaliAktual ? $tanggalKembaliAktual->diffInDays($tanggalKembaliRencana) : 0,
                    'keterangan_denda' => $status === 'terlambat' && $dendaTotal > 0 ? 'Denda keterlambatan pengembalian' : null,
                    'denda_total' => $dendaTotal,
                    'total_bayar' => $totalBayar,
                    'catatan_peminjam' => $catatanPeminjam,
                    'catatan_admin' => $catatanAdmin,
                    'created_at' => $tanggalPinjam->copy()->subHours(rand(1, 48)), // Booking made 1-48 hours before trip
                    'updated_at' => $tanggalKembaliAktual ?? $tanggalPinjam,
                ];
            }
        }

        // Add some specific scenario rentals
        $this->addSpecialScenarios($peminjamans, $users, $units);

        // Insert peminjamans one by one to avoid column mismatch
        foreach ($peminjamans as $peminjamanData) {
            Peminjaman::create($peminjamanData);
        }
    }

    private function getRealisticQuantity(Unit $unit): int
    {
        $unitName = strtolower($unit->nama_unit);

        if (str_contains($unitName, 'tenda')) {
            return rand(1, 2); // Usually 1-2 tents
        } elseif (str_contains($unitName, 'sleeping bag') || str_contains($unitName, 'carrier')) {
            return rand(1, 4); // Multiple sleeping bags or carriers for group
        } elseif (str_contains($unitName, 'kompor') || str_contains($unitName, 'cookset')) {
            return rand(1, 2); // 1-2 cooking equipment
        } elseif (str_contains($unitName, 'headlamp') || str_contains($unitName, 'senter')) {
            return rand(2, 6); // Multiple lights needed
        } else {
            return rand(1, 3); // Default
        }
    }

    private function generateUserNotes(Unit $unit, int $quantity, int $duration): string
    {
        $purposes = [
            'Camping keluarga di Gunung Bromo',
            'Hiking bersama teman-teman',
            'Scout camp sekolah',
            'Adventure weekend',
            'Family camping di Rancaupas',
            'Pendakian Gunung Prau',
            'Camping di Pantai Parangtritis',
            'Outbound kantor',
            'Camping reunion keluarga',
            'Hiking solo adventure',
            'Camping dengan komunitas',
            'Weekend getaway',
        ];

        $notes = [
            "Untuk {$purposes[rand(0, count($purposes) - 1)]}",
            "Membutuhkan {$quantity} unit {$unit->nama_unit} untuk {$duration} hari",
            "Rencana camping {$duration} hari, mohon kondisi barang dipastikan bagus",
            "Trip camping bersama keluarga, butuh equipment yang reliable",
            "Akan digunakan untuk kegiatan outdoor selama {$duration} hari",
        ];

        return $notes[rand(0, count($notes) - 1)];
    }

    private function generateAdminNotes(?string $status, $tanggalKembaliAktual, $tanggalKembaliRencana): ?string
    {
        if ($status === 'terlambat' && $tanggalKembaliAktual) {
            $hariTerlambat = $tanggalKembaliAktual->diffInDays($tanggalKembaliRencana);
            return "Pengembalian terlambat {$hariTerlambat} hari. Denda telah dikenakan sesuai ketentuan.";
        } elseif ($status === 'dikembalikan') {
            $conditions = ['Barang kembali dalam kondisi baik', 'Semua equipment lengkap dan bersih', 'Kondisi excellent, tidak ada kerusakan', 'Equipment dikembalikan sesuai checklist'];
            return $conditions[rand(0, count($conditions) - 1)];
        } elseif ($status === 'dibatalkan') {
            $reasons = ['Dibatalkan karena cuaca buruk', 'Pembatalan mendadak dari customer', 'Reschedule karena konflik jadwal', 'Dibatalkan karena sakit'];
            return $reasons[rand(0, count($reasons) - 1)];
        } elseif ($status === 'pending') {
            return 'Menunggu konfirmasi ketersediaan barang dan pembayaran.';
        }

        return null;
    }

    private function addSpecialScenarios(array &$peminjamans, $users, $units): void
    {
        // Add some current active rentals
        $activeRentals = [
            [
                'status' => 'dipinjam',
                'tanggal_pinjam' => Carbon::now()->subDays(2),
                'duration' => 5,
                'unit_type' => 'tenda',
                'notes' => 'Camping long weekend di Dieng Plateau'
            ],
            [
                'status' => 'dipinjam',
                'tanggal_pinjam' => Carbon::tomorrow(),
                'duration' => 3,
                'unit_type' => 'carrier',
                'notes' => 'Hiking Gunung Papandayan besok'
            ],
            [
                'status' => 'pending',
                'tanggal_pinjam' => Carbon::now()->addDays(3),
                'duration' => 4,
                'unit_type' => 'sleeping',
                'notes' => 'Camping keluarga weekend depan'
            ],
        ];

        foreach ($activeRentals as $rental) {
            $user = $users->random();
            $unit = $units->filter(function($u) use ($rental) {
                return str_contains(strtolower($u->nama_unit), $rental['unit_type']);
            })->first() ?? $units->random();

            $tanggalPinjam = $rental['tanggal_pinjam'];
            $tanggalKembaliRencana = $tanggalPinjam->copy()->addDays($rental['duration']);

            $peminjamans[] = [
                'user_id' => $user->id,
                'unit_id' => $unit->id,
                'kode_peminjaman' => 'PJM-' . $tanggalPinjam->format('Ymd') . '-SP' . str_pad(count($peminjamans) + 1, 3, '0', STR_PAD_LEFT),
                'jumlah' => rand(1, 2),
                'tanggal_pinjam' => $tanggalPinjam,
                'tanggal_kembali_rencana' => $tanggalKembaliRencana,
                'tanggal_kembali_aktual' => null,
                'status' => $rental['status'],
                'rental_status' => $rental['status'] === 'pending' ? 'pending' : 'approved',
                'rental_approved_at' => $rental['status'] !== 'pending' ? $tanggalPinjam->copy()->addHours(rand(1, 12)) : null,
                'rental_approved_by' => $rental['status'] !== 'pending' ? \App\Models\User::where('role', 'admin')->first()?->id : null,
                'return_status' => 'not_requested',
                'harga_sewa_total' => ($unit->harga_sewa_per_hari ?? 50000) * $rental['duration'],
                'denda' => 0,
                'hari_terlambat' => 0,
                'denda_total' => 0,
                'total_bayar' => ($unit->harga_sewa_per_hari ?? 50000) * $rental['duration'],
                'catatan_peminjam' => $rental['notes'],
                'catatan_admin' => $this->generateAdminNotes($rental['status'], null, $tanggalKembaliRencana),
                'created_at' => $tanggalPinjam->copy()->subHours(rand(1, 24)),
                'updated_at' => now(),
            ];
        }
    }
}
