<?php

namespace App\Services\Admin;

use App\Repositories\UnitRepository;
use App\Repositories\KategoriRepository;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Exception;

/**
 * Service class untuk menangani logika bisnis Unit
 * Layer ini berisi business logic dan orkestrasi antar repository
 */
class UnitService
{
    protected UnitRepository $unitRepository;
    protected KategoriRepository $kategoriRepository;

    public function __construct(
        UnitRepository $unitRepository,
        KategoriRepository $kategoriRepository
    ) {
        $this->unitRepository = $unitRepository;
        $this->kategoriRepository = $kategoriRepository;
    }

    /**
     * Mengambil semua unit dengan filter dan paginasi
     */
    public function getAllUnits(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return $this->unitRepository->getAll($filters, $perPage);
    }

    /**
     * Mengambil detail unit berdasarkan ID
     */
    public function getUnitById(int $id): ?Unit
    {
        return $this->unitRepository->findById($id);
    }

    /**
     * Membuat unit baru dengan validasi bisnis
     */
    public function createUnit(array $data): Unit
    {
        // Validasi kode unit tidak duplikat
        if ($this->unitRepository->isKodeUnitExists($data['kode_unit'])) {
            throw new Exception('Kode unit sudah digunakan');
        }

        // Validasi kategori yang dipilih ada
        if (!empty($data['kategori_ids'])) {
            foreach ($data['kategori_ids'] as $kategoriId) {
                if (!$this->kategoriRepository->findById($kategoriId)) {
                    throw new Exception("Kategori dengan ID {$kategoriId} tidak ditemukan");
                }
            }
        }

        // Buat unit
        $unit = $this->unitRepository->create([
            'kode_unit' => $data['kode_unit'],
            'nama_unit' => $data['nama_unit'],
            'deskripsi' => $data['deskripsi'] ?? null,
            'status' => $data['status'] ?? 'tersedia',
            'stok' => $data['stok'] ?? 1
        ]);

        // Attach kategori jika ada
        if (!empty($data['kategori_ids'])) {
            $this->unitRepository->attachKategoris($unit, $data['kategori_ids']);
        }

        return $unit;
    }

    /**
     * Mengupdate unit dengan validasi bisnis
     */
    public function updateUnit(int $id, array $data): Unit
    {
        $unit = $this->unitRepository->findById($id);
        if (!$unit) {
            throw new Exception('Unit tidak ditemukan');
        }

        // Validasi kode unit tidak duplikat (kecuali unit ini sendiri)
        if ($this->unitRepository->isKodeUnitExists($data['kode_unit'], $id)) {
            throw new Exception('Kode unit sudah digunakan');
        }

        // Validasi kategori yang dipilih ada
        if (!empty($data['kategori_ids'])) {
            foreach ($data['kategori_ids'] as $kategoriId) {
                if (!$this->kategoriRepository->findById($kategoriId)) {
                    throw new Exception("Kategori dengan ID {$kategoriId} tidak ditemukan");
                }
            }
        }

        // Update unit
        $this->unitRepository->update($id, [
            'kode_unit' => $data['kode_unit'],
            'nama_unit' => $data['nama_unit'],
            'deskripsi' => $data['deskripsi'] ?? null,
            'status' => $data['status'],
            'stok' => $data['stok']
        ]);

        // Update kategori
        if (isset($data['kategori_ids'])) {
            $this->unitRepository->attachKategoris($unit, $data['kategori_ids']);
        }

        return $this->unitRepository->findById($id);
    }

    /**
     * Menghapus unit dengan validasi bisnis
     */
    public function deleteUnit(int $id): bool
    {
        $unit = $this->unitRepository->findById($id);
        if (!$unit) {
            throw new Exception('Unit tidak ditemukan');
        }

        // Validasi unit tidak sedang dipinjam
        if ($unit->peminjamans()->where('status', 'dipinjam')->exists()) {
            throw new Exception('Unit tidak dapat dihapus karena sedang dipinjam');
        }

        return $this->unitRepository->delete($id);
    }

    /**
     * Mengambil unit yang sedang dipinjam
     */
    public function getUnitDipinjam(): Collection
    {
        return $this->unitRepository->getUnitDipinjam();
    }

    /**
     * Mengambil unit yang tersedia
     */
    public function getUnitTersedia(): Collection
    {
        return $this->unitRepository->getUnitTersedia();
    }

    /**
     * Mencari unit berdasarkan nama
     */
    public function searchUnit(string $search, int $perPage = 15): LengthAwarePaginator
    {
        return $this->unitRepository->getAll(['search' => $search], $perPage);
    }

    /**
     * Update status unit
     */
    public function updateStatus(int $id, string $status): bool
    {
        $unit = $this->unitRepository->findById($id);
        if (!$unit) {
            throw new Exception('Unit tidak ditemukan');
        }

        // Validasi status yang valid
        $validStatuses = ['tersedia', 'dipinjam', 'maintenance'];
        if (!in_array($status, $validStatuses)) {
            throw new Exception('Status tidak valid');
        }

        return $this->unitRepository->updateStatus($id, $status);
    }
}
