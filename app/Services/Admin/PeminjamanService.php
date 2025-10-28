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

        // Generate kode peminjaman
        $kodePeminjaman = $this->generateKodePeminjaman();

        // Hitung nilai finansial berdasarkan unit dan durasi
        $tanggalPinjam = \Carbon\Carbon::parse($data['tanggal_pinjam']);
        $tanggalKembaliRencana = \Carbon\Carbon::parse($data['tanggal_kembali_rencana']);
        $jumlahHari = $tanggalPinjam->diffInDays($tanggalKembaliRencana) + 1;

        $hargaSewaTotal = $unit->harga_sewa_per_hari * $jumlahHari;
        $dendaTotal = 0; // Awal belum ada denda
        $totalBayar = $hargaSewaTotal + $dendaTotal;

        // Buat peminjaman dengan perhitungan finansial
        $peminjaman = $this->peminjamanRepository->create([
            'kode_peminjaman' => $kodePeminjaman,
            'user_id' => $data['user_id'],
            'unit_id' => $data['unit_id'],
            'tanggal_pinjam' => $data['tanggal_pinjam'],
            'tanggal_kembali_rencana' => $data['tanggal_kembali_rencana'],
            'harga_sewa_total' => $hargaSewaTotal,
            'denda_total' => $dendaTotal,
            'total_bayar' => $totalBayar,
            'status' => 'dipinjam',
            'catatan_peminjam' => $data['catatan'] ?? null,
            'catatan_admin' => null
        ]);

        // Update status unit menjadi dipinjam dan kurangi stok
        $this->unitRepository->update($unit->id, [
            'status' => 'dipinjam',
            'stok' => $unit->stok - 1
        ]);

        return $peminjaman;
    }

    /**
     * Generate kode peminjaman unik
     */
    private function generateKodePeminjaman(): string
    {
        $prefix = 'PJM';
        $date = now()->format('Ymd');
        $count = $this->peminjamanRepository->getAll()->where('created_at', '>=', now()->startOfDay())->count() + 1;
        $sequence = str_pad($count, 3, '0', STR_PAD_LEFT);

        return $prefix . $date . $sequence;
    }

    /**
     * Proses pengembalian unit oleh admin dengan perhitungan denda
     */
    public function prosesKembalikan(int $id, array $data = []): bool
    {
        $peminjaman = $this->peminjamanRepository->findById($id);
        if (!$peminjaman) {
            throw new Exception('Peminjaman tidak ditemukan');
        }

        if ($peminjaman->status !== 'dipinjam' && $peminjaman->status !== 'terlambat') {
            throw new Exception('Peminjaman sudah dikembalikan atau status tidak valid');
        }

        $tanggalKembaliAktual = now();
        $unit = $peminjaman->unit;

        // Hitung denda jika terlambat
        $dendaTotal = 0;
        if ($tanggalKembaliAktual > $peminjaman->tanggal_kembali_rencana) {
            $hariTerlambat = $peminjaman->tanggal_kembali_rencana->diffInDays($tanggalKembaliAktual);
            $dendaTotal = $unit->denda_per_hari * $hariTerlambat;
        }

        // Update total bayar dengan denda
        $totalBayar = $peminjaman->harga_sewa_total + $dendaTotal;

        // Data untuk update
        $updateData = [
            'tanggal_kembali_aktual' => $tanggalKembaliAktual,
            'denda_total' => $dendaTotal,
            'total_bayar' => $totalBayar,
            'status' => 'dikembalikan',
            'catatan_admin' => $data['catatan_admin'] ?? null
        ];

        // Proses pengembalian
        $result = $this->peminjamanRepository->update($id, $updateData);

        if ($result) {
            // Update status unit menjadi tersedia dan tambah stok
            $this->unitRepository->update($unit->id, [
                'status' => 'tersedia',
                'stok' => $unit->stok + 1
            ]);
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
