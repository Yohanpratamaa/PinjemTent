<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Repository untuk menangani operasi database User
 * Layer ini berinteraksi langsung dengan database menggunakan Eloquent
 */
class UserRepository
{
    protected User $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * Mengambil semua user dengan paginasi dan pencarian
     */
    public function getAll(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = $this->model->withCount('peminjamans');

        // Filter pencarian berdasarkan nama atau email
        if (!empty($filters['search'])) {
            $query->search($filters['search']);
        }

        // Filter berdasarkan role
        if (!empty($filters['role'])) {
            $query->byRole($filters['role']);
        }

        return $query->paginate($perPage);
    }

    /**
     * Mengambil user berdasarkan ID
     */
    public function findById(int $id): ?User
    {
        return $this->model->with(['peminjamans.unit'])->find($id);
    }

    /**
     * Membuat user baru
     */
    public function create(array $data): User
    {
        return $this->model->create($data);
    }

    /**
     * Mengupdate user
     */
    public function update(int $id, array $data): bool
    {
        $user = $this->model->find($id);
        if (!$user) {
            return false;
        }

        return $user->update($data);
    }

    /**
     * Menghapus user
     */
    public function delete(int $id): bool
    {
        $user = $this->model->find($id);
        if (!$user) {
            return false;
        }

        return $user->delete();
    }

    /**
     * Mengambil user dengan role tertentu
     */
    public function getUsersByRole(string $role): Collection
    {
        return $this->model->byRole($role)->get();
    }

    /**
     * Mengambil user yang memiliki peminjaman aktif
     */
    public function getUsersWithActivePeminjaman(): Collection
    {
        return $this->model->with(['peminjamans' => function($query) {
            $query->where('status', 'dipinjam')->with('unit');
        }])
        ->whereHas('peminjamans', function($query) {
            $query->where('status', 'dipinjam');
        })
        ->get();
    }

    /**
     * Mengecek apakah email sudah ada
     */
    public function isEmailExists(string $email, ?int $excludeId = null): bool
    {
        $query = $this->model->where('email', $email);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }
}
