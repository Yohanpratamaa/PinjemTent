<?php

namespace App\Repositories;

use App\Models\Peminjaman;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Carbon\Carbon;

/**
 * Repository untuk menangani operasi database Peminjaman
 * Layer ini berinteraksi langsung dengan database menggunakan Eloquent
 */
class PeminjamanRepository
{
    protected Peminjaman $model;

    public function __construct(Peminjaman $model)
    {
        $this->model = $model;
    }

    /**
     * Mengambil semua peminjaman dengan paginasi dan filter
     */
    public function getAll(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = $this->model->with(['user', 'unit.kategoris']);

        // Search functionality - cari berdasarkan nama user, kode unit, atau kode peminjaman
        if (!empty($filters['search'])) {
            $searchTerm = $filters['search'];
            $query->where(function ($q) use ($searchTerm) {
                $q->where('kode_peminjaman', 'like', "%{$searchTerm}%")
                  ->orWhereHas('user', function ($userQuery) use ($searchTerm) {
                      $userQuery->where('name', 'like', "%{$searchTerm}%")
                               ->orWhere('email', 'like', "%{$searchTerm}%");
                  })
                  ->orWhereHas('unit', function ($unitQuery) use ($searchTerm) {
                      $unitQuery->where('kode_unit', 'like', "%{$searchTerm}%")
                               ->orWhere('nama_unit', 'like', "%{$searchTerm}%");
                  })
                  ->orWhere('id', 'like', "%{$searchTerm}%");
            });
        }

        // Filter berdasarkan status
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        // Filter berdasarkan user
        if (!empty($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }

        // Filter berdasarkan unit
        if (!empty($filters['unit_id'])) {
            $query->where('unit_id', $filters['unit_id']);
        }

        // Filter berdasarkan tanggal (memperbaiki mapping dari controller)
        if (!empty($filters['date_from'])) {
            $query->where('tanggal_pinjam', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->where('tanggal_pinjam', '<=', $filters['date_to']);
        }

        // Support untuk filter tanggal legacy
        if (!empty($filters['tanggal_mulai'])) {
            $query->where('tanggal_pinjam', '>=', $filters['tanggal_mulai']);
        }

        if (!empty($filters['tanggal_selesai'])) {
            $query->where('tanggal_pinjam', '<=', $filters['tanggal_selesai']);
        }

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    /**
     * Mengambil peminjaman berdasarkan ID
     */
    public function findById(int $id): ?Peminjaman
    {
        return $this->model->with(['user', 'unit.kategoris'])->find($id);
    }

    /**
     * Membuat peminjaman baru
     */
    public function create(array $data): Peminjaman
    {
        return $this->model->create($data);
    }

    /**
     * Mengupdate peminjaman
     */
    public function update(int $id, array $data): bool
    {
        $peminjaman = $this->model->find($id);
        if (!$peminjaman) {
            return false;
        }

        return $peminjaman->update($data);
    }

    /**
     * Menghapus peminjaman
     */
    public function delete(int $id): bool
    {
        $peminjaman = $this->model->find($id);
        if (!$peminjaman) {
            return false;
        }

        return $peminjaman->delete();
    }

    /**
     * Mengambil peminjaman yang masih aktif
     */
    public function getActivePeminjaman(): Collection
    {
        return $this->model->with(['user', 'unit.kategoris'])
            ->aktif()
            ->get();
    }

    /**
     * Mengambil peminjaman yang terlambat
     */
    public function getTerlambatPeminjaman(): Collection
    {
        return $this->model->with(['user', 'unit.kategoris'])
            ->terlambat()
            ->get();
    }

    /**
     * Mengambil riwayat peminjaman user
     */
    public function getRiwayatByUser(int $userId): Collection
    {
        return $this->model->with(['unit.kategoris'])
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Mengambil riwayat peminjaman unit
     */
    public function getRiwayatByUnit(int $unitId): Collection
    {
        return $this->model->with(['user'])
            ->where('unit_id', $unitId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Proses pengembalian unit
     */
    public function prosesKembalikan(int $id, array $data = []): bool
    {
        $peminjaman = $this->model->find($id);
        if (!$peminjaman || $peminjaman->status !== 'dipinjam') {
            return false;
        }

        $updateData = [
            'status' => 'dikembalikan',
            'tanggal_kembali_aktual' => now()->toDateString()
        ];

        if (!empty($data['catatan'])) {
            $updateData['catatan'] = $data['catatan'];
        }

        return $peminjaman->update($updateData);
    }

    /**
     * Mengecek apakah user sudah meminjam unit yang sama dan belum dikembalikan
     */
    public function isUserHasPinjamUnit(int $userId, int $unitId): bool
    {
        return $this->model->where('user_id', $userId)
            ->where('unit_id', $unitId)
            ->where('status', 'dipinjam')
            ->exists();
    }

    /**
     * Get user rental history with filters and pagination (untuk RentalHistoryService)
     */
    public function getUserRentals(int $userId, array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        $query = $this->model->with(['unit.kategoris', 'user'])
            ->where('user_id', $userId);

        // Apply filters
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['kategori'])) {
            $query->whereHas('unit.kategoris', function ($q) use ($filters) {
                $q->where('kategori_id', $filters['kategori']);
            });
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

        // Apply sorting
        $sortBy = $filters['sort_by'] ?? 'created_at';
        $sortOrder = $filters['sort_order'] ?? 'desc';
        $query->orderBy($sortBy, $sortOrder);

        return $query->paginate($perPage);
    }

    /**
     * Get rental statistics for a user (untuk RentalHistoryService)
     */
    public function getUserRentalStats(int $userId): array
    {
        return [
            'total_rentals' => $this->model->where('user_id', $userId)->count(),
            'active_rentals' => $this->model->where('user_id', $userId)->whereIn('status', ['pending', 'disetujui', 'dipinjam'])->count(),
            'completed_rentals' => $this->model->where('user_id', $userId)->where('status', 'dikembalikan')->count(),
            'cancelled_rentals' => $this->model->where('user_id', $userId)->where('status', 'dibatalkan')->count(),
            'total_spent' => $this->model->where('user_id', $userId)->where('status', 'dikembalikan')->sum('harga_sewa_total'),
            'pending_approval' => $this->model->where('user_id', $userId)->where('status', 'pending')->count(),
        ];
    }

    /**
     * Find rental by ID for specific user (untuk RentalHistoryService)
     */
    public function findUserRental(int $rentalId, int $userId): ?Peminjaman
    {
        return $this->model->with(['unit.kategoris', 'user'])
            ->where('id', $rentalId)
            ->where('user_id', $userId)
            ->first();
    }

    /**
     * Cancel a rental (untuk RentalHistoryService)
     */
    public function cancelRental(int $rentalId, int $userId): bool
    {
        $rental = $this->findUserRental($rentalId, $userId);

        if (!$rental) {
            return false;
        }

        // Check if rental can be cancelled
        if (!in_array($rental->status, ['pending', 'disetujui'])) {
            return false;
        }

        return $rental->update(['status' => 'dibatalkan']);
    }

    /**
     * Get user rentals for export (untuk RentalHistoryService)
     */
    public function getUserRentalsForExport(int $userId, array $filters = []): Collection
    {
        $query = $this->model->with(['unit.kategoris', 'user'])
            ->where('user_id', $userId);

        // Apply filters (same as getUserRentals but without pagination)
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['kategori'])) {
            $query->whereHas('unit.kategoris', function ($q) use ($filters) {
                $q->where('kategori_id', $filters['kategori']);
            });
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

        // Apply sorting
        $sortBy = $filters['sort_by'] ?? 'created_at';
        $sortOrder = $filters['sort_order'] ?? 'desc';

        return $query->orderBy($sortBy, $sortOrder)->get();
    }
}
