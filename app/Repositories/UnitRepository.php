<?php

namespace App\Repositories;

use App\Models\Unit;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Repository untuk menangani operasi database Unit
 * Layer ini berinteraksi langsung dengan database menggunakan Eloquent
 */
class UnitRepository
{
    protected Unit $model;

    public function __construct(Unit $model)
    {
        $this->model = $model;
    }

    /**
     * Mengambil semua unit dengan paginasi dan pencarian
     */
    public function getAll(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = $this->model->with(['kategoris']);

        // Filter pencarian berdasarkan nama unit
        if (!empty($filters['search'])) {
            $query->search($filters['search']);
        }

        // Filter berdasarkan status
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        // Filter berdasarkan kategori
        if (!empty($filters['kategori_id'])) {
            $query->whereHas('kategoris', function($q) use ($filters) {
                $q->where('kategoris.id', $filters['kategori_id']);
            });
        }

        return $query->paginate($perPage);
    }

    /**
     * Mengambil unit berdasarkan ID
     */
    public function findById(int $id): ?Unit
    {
        return $this->model->with(['kategoris', 'peminjamans.user'])->find($id);
    }

    /**
     * Membuat unit baru
     */
    public function create(array $data): Unit
    {
        return $this->model->create($data);
    }

    /**
     * Mengupdate unit
     */
    public function update(int $id, array $data): bool
    {
        $unit = $this->model->find($id);
        if (!$unit) {
            return false;
        }

        return $unit->update($data);
    }

    /**
     * Menghapus unit
     */
    public function delete(int $id): bool
    {
        $unit = $this->model->find($id);
        if (!$unit) {
            return false;
        }

        return $unit->delete();
    }

    /**
     * Mengambil unit yang sedang dipinjam
     */
    public function getUnitDipinjam(): Collection
    {
        return $this->model->with(['kategoris', 'peminjamans' => function($query) {
            $query->where('status', 'dipinjam')->with('user');
        }])
        ->whereHas('peminjamans', function($query) {
            $query->where('status', 'dipinjam');
        })
        ->get();
    }

    /**
     * Mengambil unit yang tersedia
     */
    public function getUnitTersedia(): Collection
    {
        return $this->model->with(['kategoris'])
            ->tersedia()
            ->get();
    }

    /**
     * Attach kategori ke unit
     */
    public function attachKategoris(Unit $unit, array $kategoriIds): void
    {
        $unit->kategoris()->sync($kategoriIds);
    }

    /**
     * Mengecek apakah kode unit sudah ada
     */
    public function isKodeUnitExists(string $kodeUnit, ?int $excludeId = null): bool
    {
        $query = $this->model->where('kode_unit', $kodeUnit);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }

    /**
     * Update status unit
     */
    public function updateStatus(int $id, string $status): bool
    {
        $unit = $this->model->find($id);
        if (!$unit) {
            return false;
        }

        return $unit->update(['status' => $status]);
    }
}
