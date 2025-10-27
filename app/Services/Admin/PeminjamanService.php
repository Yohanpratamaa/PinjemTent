<?php

namespace App\Services\Admin;

use App\Repositories\PeminjamanRepository;
use App\Repositories\UnitRepository;
use App\Repositories\UserRepository;
use App\Models\Peminjaman;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Exception;

/**
 * Service class untuk menangani logika bisnis Peminjaman
 * Layer ini berisi business logic dan orkestrasi antar repository
 */
class PeminjamanService
{
    protected PeminjamanRepository $peminjamanRepository;
    protected UnitRepository $unitRepository;
    protected UserRepository $userRepository;

    public function __construct(
        PeminjamanRepository $peminjamanRepository,
        UnitRepository $unitRepository,
        UserRepository $userRepository
    ) {
        $this->peminjamanRepository = $peminjamanRepository;
        $this->unitRepository = $unitRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Mengambil semua peminjaman dengan filter dan paginasi
     */
    public function getAllPeminjaman(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return $this->peminjamanRepository->getAll($filters, $perPage);
    }

    /**
     * Mengambil detail peminjaman berdasarkan ID
     */
    public function getPeminjamanById(int $id): ?Peminjaman
    {
        return $this->peminjamanRepository->findById($id);
    }

    /**
     * Membuat peminjaman baru dengan validasi bisnis
     */
    public function createPeminjaman(array $data): Peminjaman
    {
        // Validasi user ada
        $user = $this->userRepository->findById($data['user_id']);
        if (!$user) {
            throw new Exception('User tidak ditemukan');
        }

        // Validasi unit ada
        $unit = $this->unitRepository->findById($data['unit_id']);
        if (!$unit) {
            throw new Exception('Unit tidak ditemukan');
        }

        // Validasi unit tersedia
        if ($unit->status !== 'tersedia' || $unit->stok <= 0) {
            throw new Exception('Unit tidak tersedia untuk dipinjam');
        }

        // Validasi user belum meminjam unit yang sama
        if ($this->peminjamanRepository->isUserHasPinjamUnit($data['user_id'], $data['unit_id'])) {
            throw new Exception('User sudah meminjam unit ini dan belum mengembalikan');
        }

        // Buat peminjaman
        $peminjaman = $this->peminjamanRepository->create([
            'user_id' => $data['user_id'],
            'unit_id' => $data['unit_id'],
            'tanggal_pinjam' => $data['tanggal_pinjam'],
            'tanggal_kembali_rencana' => $data['tanggal_kembali_rencana'],
            'status' => 'dipinjam',
            'catatan' => $data['catatan'] ?? null
        ]);

        // Update status unit menjadi dipinjam
        $this->unitRepository->updateStatus($data['unit_id'], 'dipinjam');

        return $peminjaman;
    }

    /**
     * Proses pengembalian unit oleh admin
     */
    public function prosesKembalikan(int $id, array $data = []): bool
    {
        $peminjaman = $this->peminjamanRepository->findById($id);
        if (!$peminjaman) {
            throw new Exception('Peminjaman tidak ditemukan');
        }

        if ($peminjaman->status !== 'dipinjam') {
            throw new Exception('Peminjaman sudah dikembalikan atau status tidak valid');
        }

        // Proses pengembalian
        $result = $this->peminjamanRepository->prosesKembalikan($id, $data);

        if ($result) {
            // Update status unit menjadi tersedia
            $this->unitRepository->updateStatus($peminjaman->unit_id, 'tersedia');
        }

        return $result;
    }

    /**
     * Mengambil peminjaman yang masih aktif
     */
    public function getActivePeminjaman(): Collection
    {
        return $this->peminjamanRepository->getActivePeminjaman();
    }

    /**
     * Mengambil peminjaman yang terlambat
     */
    public function getTerlambatPeminjaman(): Collection
    {
        return $this->peminjamanRepository->getTerlambatPeminjaman();
    }

    /**
     * Mengambil riwayat peminjaman berdasarkan user
     */
    public function getRiwayatByUser(int $userId): Collection
    {
        // Validasi user ada
        $user = $this->userRepository->findById($userId);
        if (!$user) {
            throw new Exception('User tidak ditemukan');
        }

        return $this->peminjamanRepository->getRiwayatByUser($userId);
    }

    /**
     * Mengambil riwayat peminjaman berdasarkan unit
     */
    public function getRiwayatByUnit(int $unitId): Collection
    {
        // Validasi unit ada
        $unit = $this->unitRepository->findById($unitId);
        if (!$unit) {
            throw new Exception('Unit tidak ditemukan');
        }

        return $this->peminjamanRepository->getRiwayatByUnit($unitId);
    }

    /**
     * Mengambil statistik peminjaman
     */
    public function getStatistikPeminjaman(): array
    {
        $totalPeminjaman = $this->peminjamanRepository->getAll()->total();
        $aktivePeminjaman = $this->peminjamanRepository->getActivePeminjaman()->count();
        $terlambatPeminjaman = $this->peminjamanRepository->getTerlambatPeminjaman()->count();
        $dikembalikanPeminjaman = $totalPeminjaman - $aktivePeminjaman;

        return [
            'total_peminjaman' => $totalPeminjaman,
            'aktif_peminjaman' => $aktivePeminjaman,
            'terlambat_peminjaman' => $terlambatPeminjaman,
            'dikembalikan_peminjaman' => $dikembalikanPeminjaman
        ];
    }

    /**
     * Mengupdate status peminjaman menjadi terlambat (untuk cron job)
     */
    public function updateStatusTerlambat(): void
    {
        $peminjamans = $this->peminjamanRepository->getActivePeminjaman();

        foreach ($peminjamans as $peminjaman) {
            if ($peminjaman->tanggal_kembali_rencana < now()) {
                $this->peminjamanRepository->update($peminjaman->id, ['status' => 'terlambat']);
            }
        }
    }
}
