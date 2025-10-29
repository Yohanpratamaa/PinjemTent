<?php

namespace Database\Seeders;

use App\Models\Notification;
use App\Models\User;
use App\Models\Peminjaman;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('role', 'user')->get();
        $admins = User::where('role', 'admin')->get();
        $peminjamans = Peminjaman::with('unit')->get();

        if ($users->isEmpty() || $peminjamans->isEmpty()) {
            return;
        }

        $notifications = [];

        // Notifications for regular users based on actual rentals
        foreach ($users->take(5) as $user) { // Limit to first 5 users to avoid too much data
            $userRentals = $peminjamans->where('user_id', $user->id)->take(3);

            foreach ($userRentals as $rental) {
                // Add rental-specific notifications
                $notifications = array_merge($notifications, [
                    [
                        'user_id' => $user->id,
                        'peminjaman_id' => $rental->id,
                        'type' => 'rental_approved',
                        'title' => 'Peminjaman Disetujui',
                        'message' => "Peminjaman {$rental->unit->nama_unit} telah disetujui. Silakan ambil barang sesuai jadwal.",
                        'data' => json_encode(['rental_id' => $rental->id, 'unit_name' => $rental->unit->nama_unit]),
                        'read_at' => $rental->status === 'dikembalikan' ? Carbon::now()->subDays(rand(1, 10)) : null,
                        'is_admin_notification' => false,
                        'created_at' => $rental->created_at->addHours(rand(1, 6)),
                        'updated_at' => $rental->created_at->addHours(rand(1, 6)),
                    ],
                ]);

                if ($rental->status === 'dikembalikan') {
                    $notifications[] = [
                        'user_id' => $user->id,
                        'peminjaman_id' => $rental->id,
                        'type' => 'rental_returned',
                        'title' => 'Barang Berhasil Dikembalikan',
                        'message' => "{$rental->unit->nama_unit} telah berhasil dikembalikan. Terima kasih atas kepercayaan Anda.",
                        'data' => json_encode(['rental_id' => $rental->id, 'return_condition' => 'good']),
                        'read_at' => null,
                        'is_admin_notification' => false,
                        'created_at' => $rental->tanggal_kembali_aktual ?? Carbon::now()->subDays(1),
                        'updated_at' => $rental->tanggal_kembali_aktual ?? Carbon::now()->subDays(1),
                    ];
                }

                if ($rental->status === 'terlambat') {
                    $notifications[] = [
                        'user_id' => $user->id,
                        'peminjaman_id' => $rental->id,
                        'type' => 'overdue_notice',
                        'title' => 'Peminjaman Terlambat',
                        'message' => "Peminjaman {$rental->unit->nama_unit} sudah melewati batas waktu pengembalian. Mohon segera kembalikan.",
                        'data' => json_encode(['rental_id' => $rental->id, 'days_overdue' => $rental->hari_terlambat, 'fine_amount' => $rental->denda_total]),
                        'read_at' => rand(0, 1) ? Carbon::now()->subHours(rand(1, 24)) : null,
                        'is_admin_notification' => false,
                        'created_at' => $rental->tanggal_kembali_rencana->addDay(),
                        'updated_at' => $rental->tanggal_kembali_rencana->addDay(),
                    ];
                }

                if ($rental->status === 'dipinjam') {
                    $notifications[] = [
                        'user_id' => $user->id,
                        'peminjaman_id' => $rental->id,
                        'type' => 'rental_reminder',
                        'title' => 'Reminder Pengembalian',
                        'message' => "Jangan lupa mengembalikan {$rental->unit->nama_unit} besok sebelum jam 17:00.",
                        'data' => json_encode(['rental_id' => $rental->id, 'return_date' => $rental->tanggal_kembali_rencana->format('Y-m-d')]),
                        'read_at' => null,
                        'is_admin_notification' => false,
                        'created_at' => $rental->tanggal_kembali_rencana->subDay(),
                        'updated_at' => $rental->tanggal_kembali_rencana->subDay(),
                    ];
                }
            }

            // Add welcome notification for new users
            $notifications[] = [
                'user_id' => $user->id,
                'peminjaman_id' => $userRentals->first()?->id ?? $peminjamans->first()->id,
                'type' => 'welcome',
                'title' => 'Selamat Datang!',
                'message' => 'Terima kasih telah bergabung dengan PinjemTent. Mulai jelajahi koleksi peralatan camping kami.',
                'data' => json_encode(['welcome_bonus' => true]),
                'read_at' => Carbon::now()->subDays(2),
                'is_admin_notification' => false,
                'created_at' => $user->created_at->addHours(1),
                'updated_at' => Carbon::now()->subDays(2),
            ];
        }

        // Notifications for admin users
        foreach ($admins->take(2) as $admin) { // Limit to first 2 admins
            $recentRentals = $peminjamans->where('status', 'pending')->take(3);
            $overdueRentals = $peminjamans->where('status', 'terlambat')->take(2);
            $returnedRentals = $peminjamans->where('status', 'dikembalikan')->take(2);

            // Create rental request notifications (for pending rentals)
            foreach ($recentRentals as $rental) {
                $notifications[] = [
                    'user_id' => $admin->id,
                    'peminjaman_id' => $rental->id,
                    'type' => 'rental_request',
                    'title' => 'Permintaan Penyewaan Baru',
                    'message' => "Pengguna {$rental->user->name} meminta untuk menyewa {$rental->unit->nama_unit}",
                    'data' => json_encode([
                        'unit_name' => $rental->unit->nama_unit,
                        'user_name' => $rental->user->name,
                        'rental_period' => $rental->tanggal_pinjam . ' - ' . $rental->tanggal_kembali_rencana,
                        'quantity' => $rental->jumlah,
                        'total_price' => $rental->harga_sewa_total
                    ]),
                    'read_at' => rand(0, 1) ? Carbon::now()->subMinutes(rand(10, 120)) : null,
                    'is_admin_notification' => true,
                    'created_at' => $rental->created_at->addMinutes(rand(15, 60)),
                    'updated_at' => $rental->created_at->addMinutes(rand(15, 60)),
                ];
            }

            // Create return request notifications (for returned rentals)
            foreach ($returnedRentals as $rental) {
                $notifications[] = [
                    'user_id' => $admin->id,
                    'peminjaman_id' => $rental->id,
                    'type' => 'return_request',
                    'title' => 'Permintaan Pengembalian',
                    'message' => "Pengguna {$rental->user->name} meminta untuk mengembalikan {$rental->unit->nama_unit}",
                    'data' => json_encode([
                        'unit_name' => $rental->unit->nama_unit,
                        'user_name' => $rental->user->name,
                        'rental_period' => $rental->tanggal_pinjam . ' - ' . $rental->tanggal_kembali_rencana
                    ]),
                    'read_at' => Carbon::now()->subHours(rand(1, 12)),
                    'is_admin_notification' => true,
                    'created_at' => $rental->tanggal_kembali_aktual ? $rental->tanggal_kembali_aktual->subHours(1) : Carbon::now()->subDays(1),
                    'updated_at' => $rental->tanggal_kembali_aktual ? $rental->tanggal_kembali_aktual->subHours(1) : Carbon::now()->subDays(1),
                ];
            }

            // Create overdue notifications (for overdue rentals)
            foreach ($overdueRentals as $rental) {
                $notifications[] = [
                    'user_id' => $admin->id,
                    'peminjaman_id' => $rental->id,
                    'type' => 'overdue_notification',
                    'title' => 'Peminjaman Terlambat',
                    'message' => "Peminjaman {$rental->unit->nama_unit} oleh {$rental->user->name} sudah terlambat {$rental->hari_terlambat} hari.",
                    'data' => json_encode(['rental_id' => $rental->id, 'days_overdue' => $rental->hari_terlambat, 'customer_name' => $rental->user->name]),
                    'read_at' => null,
                    'is_admin_notification' => true,
                    'created_at' => $rental->tanggal_kembali_rencana->addDays($rental->hari_terlambat),
                    'updated_at' => $rental->tanggal_kembali_rencana->addDays($rental->hari_terlambat),
                ];
            }

            // Add daily report notification
            $notifications[] = [
                'user_id' => $admin->id,
                'peminjaman_id' => $peminjamans->first()->id,
                'type' => 'daily_report',
                'title' => 'Laporan Harian',
                'message' => 'Laporan aktivitas hari ini: ' . $peminjamans->where('status', 'pending')->count() . ' peminjaman pending, ' . $peminjamans->where('status', 'dikembalikan')->count() . ' pengembalian.',
                'data' => json_encode([
                    'pending_rentals' => $peminjamans->where('status', 'pending')->count(),
                    'returned_rentals' => $peminjamans->where('status', 'dikembalikan')->count(),
                    'overdue_rentals' => $peminjamans->where('status', 'terlambat')->count()
                ]),
                'read_at' => Carbon::now()->subMinutes(15),
                'is_admin_notification' => true,
                'created_at' => Carbon::now()->subHours(8),
                'updated_at' => Carbon::now()->subMinutes(15),
            ];
        }

        // Insert all notifications
        foreach ($notifications as $notification) {
            Notification::create($notification);
        }
    }
}
