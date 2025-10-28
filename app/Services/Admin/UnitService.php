<?php

namespace App\Services\Admin;

use App\Repositories\UnitRepository;
use App\Repositories\KategoriRepository;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
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
            'merk' => $data['merk'] ?? null,
            'kapasitas' => $data['kapasitas'] ?? null,
            'deskripsi' => $data['deskripsi'] ?? null,
            'foto' => $data['foto'] ?? null,
            'status' => $data['status'] ?? 'tersedia',
            'stok' => $data['stok'] ?? 1,
            'harga_sewa_per_hari' => $data['harga_sewa_per_hari'] ?? null,
            'denda_per_hari' => $data['denda_per_hari'] ?? null,
            'harga_beli' => $data['harga_beli'] ?? null
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

        // Validasi stok tidak boleh kosong atau null - fallback ke stok lama jika perlu
        if (!isset($data['stok']) || $data['stok'] === null || $data['stok'] === '') {
            Log::warning('Empty stock detected in service, using fallback', [
                'unit_id' => $unit->id,
                'current_stock' => $unit->stok,
                'received_data' => $data
            ]);
            $data['stok'] = $unit->stok; // Gunakan stok lama sebagai fallback
        }

        // Validasi stok tidak boleh kurang dari jumlah unit yang sedang dipinjam
        $activeRentals = $unit->peminjamans()->where('status', 'dipinjam')->count();
        if ($data['stok'] < $activeRentals) {
            throw new Exception("Stok tidak boleh kurang dari {$activeRentals} karena masih ada unit yang dipinjam");
        }

        // Siapkan data update dengan fallback untuk mencegah data hilang
        $updateData = [
            'kode_unit' => $data['kode_unit'] ?? $unit->kode_unit,
            'nama_unit' => $data['nama_unit'] ?? $unit->nama_unit,
            'merk' => isset($data['merk']) ? $data['merk'] : $unit->merk,
            'kapasitas' => isset($data['kapasitas']) ? $data['kapasitas'] : $unit->kapasitas,
            'deskripsi' => isset($data['deskripsi']) ? $data['deskripsi'] : $unit->deskripsi,
            'foto' => isset($data['foto']) ? $data['foto'] : $unit->foto,
            'status' => $data['status'] ?? $unit->status,
            'stok' => (int) $data['stok'], // Force ke integer
            'harga_sewa_per_hari' => isset($data['harga_sewa_per_hari']) ? $data['harga_sewa_per_hari'] : $unit->harga_sewa_per_hari,
            'denda_per_hari' => isset($data['denda_per_hari']) ? $data['denda_per_hari'] : $unit->denda_per_hari,
            'harga_beli' => isset($data['harga_beli']) ? $data['harga_beli'] : $unit->harga_beli
        ];

        // Log perubahan stok
        if ($unit->stok != $updateData['stok']) {
            Log::info("Stock updated for unit {$unit->kode_unit}", [
                'unit_id' => $unit->id,
                'old_stock' => $unit->stok,
                'new_stock' => $updateData['stok'],
                'changed_by' => Auth::id() ?? 'system'
            ]);
        }

        // Update unit
        $this->unitRepository->update($id, $updateData);

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
