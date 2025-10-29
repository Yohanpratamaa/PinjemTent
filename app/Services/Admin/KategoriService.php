<?php

namespace App\Services\Admin;

use App\Repositories\KategoriRepository;
use App\Models\Kategori;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Exception;

/**
 * Service class untuk menangani logika bisnis Kategori
 * Layer ini berisi business logic dan orkestrasi antar repository
 */
class KategoriService
{
    protected KategoriRepository $kategoriRepository;

    public function __construct(KategoriRepository $kategoriRepository)
    {
        $this->kategoriRepository = $kategoriRepository;
    }

    /**
     * Mengambil semua kategori dengan filter dan paginasi
     */
    public function getAllKategoris(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return $this->kategoriRepository->getAll($filters, $perPage);
    }

    /**
     * Mengambil detail kategori berdasarkan ID
     */
    public function getKategoriById(int $id): ?Kategori
    {
        return $this->kategoriRepository->findById($id);
    }

    /**
     * Membuat kategori baru dengan validasi bisnis
     */
    public function createKategori(array $data): Kategori
    {
        // Validasi nama kategori tidak duplikat
        if ($this->kategoriRepository->isNamaKategoriExists($data['nama_kategori'])) {
            throw new Exception('Nama kategori sudah digunakan');
        }

        return $this->kategoriRepository->create([
            'nama_kategori' => $data['nama_kategori'],
            'deskripsi_kategori' => $data['deskripsi_kategori'] ?? null
        ]);
    }

    /**
     * Mengupdate kategori dengan validasi bisnis
     */
    public function updateKategori(int $id, array $data): Kategori
    {
        $kategori = $this->kategoriRepository->findById($id);
        if (!$kategori) {
            throw new Exception('Kategori tidak ditemukan');
        }

        // Validasi nama kategori tidak duplikat (kecuali kategori ini sendiri)
        if ($this->kategoriRepository->isNamaKategoriExists($data['nama_kategori'], $id)) {
            throw new Exception('Nama kategori sudah digunakan');
        }

        $updatedKategori = $this->kategoriRepository->update($id, [
            'nama_kategori' => $data['nama_kategori'],
            'deskripsi_kategori' => $data['deskripsi_kategori'] ?? null
        ]);

        if (!$updatedKategori) {
            throw new Exception('Gagal mengupdate kategori');
        }

        return $updatedKategori;
    }

    /**
     * Menghapus kategori dengan validasi bisnis
     */
    public function deleteKategori(int $id): bool
    {
        $kategori = $this->kategoriRepository->findById($id);
        if (!$kategori) {
            throw new Exception('Kategori tidak ditemukan');
        }

        // Validasi kategori tidak digunakan oleh unit
        if ($kategori->units()->count() > 0) {
            throw new Exception('Kategori tidak dapat dihapus karena masih digunakan oleh unit');
        }

        return $this->kategoriRepository->delete($id);
    }

    /**
     * Mengambil semua kategori untuk dropdown
     */
    public function getKategorisForDropdown(): Collection
    {
        return $this->kategoriRepository->getAllForDropdown();
    }

    /**
     * Mencari kategori berdasarkan nama
     */
    public function searchKategori(string $search, int $perPage = 15): LengthAwarePaginator
    {
        return $this->kategoriRepository->getAll(['search' => $search], $perPage);
    }
}
