<?php

namespace App\Repositories;

use App\Models\Kategori;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Repository untuk menangani operasi database Kategori
 * Layer ini berinteraksi langsung dengan database menggunakan Eloquent
 */
class KategoriRepository
{
    protected Kategori $model;

    public function __construct(Kategori $model)
    {
        $this->model = $model;
    }

    /**
     * Mengambil semua kategori dengan paginasi dan pencarian
     */
    public function getAll(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = $this->model->withCount('units');

        // Filter pencarian berdasarkan nama kategori
        if (!empty($filters['search'])) {
            $query->search($filters['search']);
        }

        return $query->paginate($perPage);
    }

    /**
     * Mengambil kategori berdasarkan ID
     */
    public function findById(int $id): ?Kategori
    {
        return $this->model->with(['units'])->find($id);
    }

    /**
     * Membuat kategori baru
     */
    public function create(array $data): Kategori
    {
        return $this->model->create($data);
    }

    /**
     * Mengupdate kategori
     */
    public function update(int $id, array $data): bool
    {
        $kategori = $this->model->find($id);
        if (!$kategori) {
            return false;
        }

        return $kategori->update($data);
    }

    /**
     * Menghapus kategori
     */
    public function delete(int $id): bool
    {
        $kategori = $this->model->find($id);
        if (!$kategori) {
            return false;
        }

        // Detach dari semua unit terlebih dahulu
        $kategori->units()->detach();

        return $kategori->delete();
    }

    /**
     * Mengambil semua kategori tanpa paginasi (untuk dropdown)
     */
    public function getAllForDropdown(): Collection
    {
        return $this->model->select('id', 'nama_kategori')
            ->orderBy('nama_kategori')
            ->get();
    }

    /**
     * Mengecek apakah nama kategori sudah ada
     */
    public function isNamaKategoriExists(string $namaKategori, ?int $excludeId = null): bool
    {
        $query = $this->model->where('nama_kategori', $namaKategori);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }
}
