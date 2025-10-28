<?php

namespace App\Services\User;

use App\Models\Peminjaman;
use App\Models\Unit;
use App\Repositories\PeminjamanRepository;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RentalHistoryService
{
    protected $peminjamanRepository;

    public function __construct(PeminjamanRepository $peminjamanRepository)
    {
        $this->peminjamanRepository = $peminjamanRepository;
    }

    /**
     * Get user rental history with filters and pagination.
     */
    public function getUserRentalHistory($userId, $filters = [])
    {
        $query = Peminjaman::with(['unit.kategoris', 'user'])
                          ->where('user_id', $userId);

        // Apply filters
        if (!empty($filters['status'])) {
            if ($filters['status'] === 'terlambat') {
                $query->where(function($q) {
                    $q->where('status', 'terlambat')
                      ->orWhere(function($subQ) {
                          $subQ->where('status', 'dipinjam')
                               ->where('tanggal_kembali_rencana', '<', now());
                      });
                });
            } else {
                $query->where('status', $filters['status']);
            }
        }

        if (!empty($filters['start_date'])) {
            $query->whereDate('tanggal_pinjam', '>=', $filters['start_date']);
        }

        if (!empty($filters['end_date'])) {
            $query->whereDate('tanggal_kembali_rencana', '<=', $filters['end_date']);
        }

        if (!empty($filters['search'])) {
            $query->whereHas('unit', function ($q) use ($filters) {
                $q->where('nama_unit', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('merek', 'like', '%' . $filters['search'] . '%');
            });
        }

        // Order by latest
        $query->orderBy('created_at', 'desc');

        // Paginate
        $perPage = $filters['per_page'] ?? 10;
        return $query->paginate($perPage)->withQueryString();
    }

    /**
     * Get rental statistics for user.
     */
    public function getUserRentalStats($userId)
    {
        return [
            'total_rentals' => Peminjaman::where('user_id', $userId)->count(),
            'active_rentals' => Peminjaman::where('user_id', $userId)->whereIn('status', ['pending', 'disetujui', 'dipinjam'])->count(),
            'completed_rentals' => Peminjaman::where('user_id', $userId)->where('status', 'dikembalikan')->count(),
            'cancelled_rentals' => Peminjaman::where('user_id', $userId)->where('status', 'dibatalkan')->count(),
            'total_spent' => Peminjaman::where('user_id', $userId)->where('status', 'dikembalikan')->sum('harga_sewa_total'),
            'current_month_rentals' => Peminjaman::where('user_id', $userId)
                                                ->whereMonth('created_at', now()->month)
                                                ->whereYear('created_at', now()->year)
                                                ->count(),
            'most_rented_category' => $this->getMostRentedCategory($userId),
            'average_rental_duration' => $this->getAverageRentalDuration($userId)
        ];
    }

    /**
     * Get rental detail with authorization check.
     */
    public function getRentalDetail($rentalId, $userId)
    {
        return Peminjaman::with(['unit.kategoris', 'user'])
                        ->where('id', $rentalId)
                        ->where('user_id', $userId)
                        ->first();
    }

    /**
     * Cancel rental if allowed.
     */
    public function cancelRental($rentalId, $userId)
    {
        $rental = $this->getRentalDetail($rentalId, $userId);

        if (!$rental) {
            return [
                'success' => false,
                'message' => 'Penyewaan tidak ditemukan.'
            ];
        }

        // Check if cancellation is allowed
        if ($rental->status !== 'pending' && $rental->status !== 'disetujui') {
            return [
                'success' => false,
                'message' => 'Penyewaan tidak dapat dibatalkan pada status saat ini.'
            ];
        }

        // Check if within cancellation period (e.g., 24 hours before rental start)
        $rentalStart = Carbon::parse((string)$rental->tanggal_pinjam);
        $now = Carbon::now();

        if ($rentalStart->diffInHours($now) < 24) {
            return [
                'success' => false,
                'message' => 'Penyewaan tidak dapat dibatalkan kurang dari 24 jam sebelum waktu mulai.'
            ];
        }

        try {
            DB::beginTransaction();

            // Update rental status
            $rental->update([
                'status' => 'dibatalkan',
                'keterangan' => 'Dibatalkan oleh user pada ' . now()->format('d/m/Y H:i')
            ]);

            // Return stock if it was allocated
            if ($rental->status === 'disetujui') {
                $unit = $rental->unit;
                $unit->increment('stok', $rental->jumlah);
            }

            DB::commit();

            return [
                'success' => true,
                'message' => 'Penyewaan berhasil dibatalkan.'
            ];

        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan saat membatalkan penyewaan.'
            ];
        }
    }

    /**
     * Get most rented category for user.
     */
    private function getMostRentedCategory($userId)
    {
        $result = Peminjaman::join('units', 'peminjamans.unit_id', '=', 'units.id')
                           ->join('unit_kategori', 'units.id', '=', 'unit_kategori.unit_id')
                           ->join('kategoris', 'unit_kategori.kategori_id', '=', 'kategoris.id')
                           ->where('peminjamans.user_id', $userId)
                           ->where('peminjamans.status', '!=', 'dibatalkan')
                           ->select('kategoris.nama_kategori', DB::raw('COUNT(*) as total'))
                           ->groupBy('kategoris.nama_kategori')
                           ->orderBy('total', 'desc')
                           ->first();

        return $result ? $result->nama_kategori : 'Belum ada';
    }

    /**
     * Get average rental duration for user.
     */
    private function getAverageRentalDuration($userId)
    {
        $result = Peminjaman::where('user_id', $userId)
                           ->where('status', 'dikembalikan')
                           ->select(DB::raw('AVG(DATEDIFF(tanggal_kembali_rencana, tanggal_pinjam)) as avg_duration'))
                           ->first();

        return $result && $result->avg_duration ? round($result->avg_duration, 1) . ' hari' : 'Belum ada data';
    }

    /**
     * Get rental status counts for dashboard charts.
     */
    public function getRentalStatusCounts($userId)
    {
        return Peminjaman::where('user_id', $userId)
                        ->select('status', DB::raw('COUNT(*) as count'))
                        ->groupBy('status')
                        ->pluck('count', 'status')
                        ->toArray();
    }

    /**
     * Get rental status with late fee information.
     */
    public function getStatusWithLateFee($rental)
    {
        if ($rental->is_terlambat) {
            $lateDays = now()->diffInDays($rental->tanggal_kembali_rencana);
            $lateFee = $rental->calculateDendaTotal();

            return [
                'status' => 'terlambat',
                'display' => 'Terlambat (' . $lateDays . ' hari)',
                'late_fee' => $lateFee,
                'days_late' => $lateDays
            ];
        }

        return [
            'status' => $rental->status,
            'display' => ucfirst($rental->status),
            'late_fee' => 0
        ];
    }

    /**
     * Get monthly rental trends for charts.
     */
    public function getMonthlyRentalTrends($userId, $months = 6)
    {
        $startDate = now()->subMonths($months)->startOfMonth();

        return Peminjaman::where('user_id', $userId)
                        ->where('created_at', '>=', $startDate)
                        ->select(
                            DB::raw('YEAR(created_at) as year'),
                            DB::raw('MONTH(created_at) as month'),
                            DB::raw('COUNT(*) as count'),
                            DB::raw('SUM(harga_sewa_total) as total_amount')
                        )
                        ->groupBy('year', 'month')
                        ->orderBy('year', 'asc')
                        ->orderBy('month', 'asc')
                        ->get();
    }
}
