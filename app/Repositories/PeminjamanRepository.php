<?php

namespace App\Repositories;

use App\Models\Peminjaman;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

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

        // Filter berdasarkan tanggal
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
}
