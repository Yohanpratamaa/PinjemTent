<?php

namespace App\Services\Admin;

use App\Repositories\UserRepository;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;
use Exception;

/**
 * Service class untuk menangani logika bisnis User
 * Layer ini berisi business logic dan orkestrasi antar repository
 */
class UserService
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Mengambil semua user dengan filter dan paginasi
     */
    public function getAllUsers(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return $this->userRepository->getAll($filters, $perPage);
    }

    /**
     * Mengambil detail user berdasarkan ID
     */
    public function getUserById(int $id): ?User
    {
        return $this->userRepository->findById($id);
    }

    /**
     * Membuat user baru dengan validasi bisnis
     */
    public function createUser(array $data): User
    {
        // Validasi email tidak duplikat
        if ($this->userRepository->isEmailExists($data['email'])) {
            throw new Exception('Email sudah digunakan');
        }

        // Password sudah di-hash di controller, jangan hash lagi
        // Hash password hanya jika belum di-hash
        if (!empty($data['password']) && !Hash::needsRehash($data['password'])) {
            // Password sudah di-hash, biarkan apa adanya
        } else if (!empty($data['password'])) {
            // Password belum di-hash, hash sekarang
            $data['password'] = Hash::make($data['password']);
        }

        // Set default role jika tidak ada
        if (!isset($data['role'])) {
            $data['role'] = 'user';
        }

        return $this->userRepository->create($data);
    }

    /**
     * Mengupdate user dengan validasi bisnis
     */
    public function updateUser(int $id, array $data): User
    {
        $user = $this->userRepository->findById($id);
        if (!$user) {
            throw new Exception('User tidak ditemukan');
        }

        // Validasi email tidak duplikat (kecuali user ini sendiri)
        if ($this->userRepository->isEmailExists($data['email'], $id)) {
            throw new Exception('Email sudah digunakan');
        }

        // Hash password jika ada perubahan
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']); // Jangan update password jika kosong
        }

        $this->userRepository->update($id, $data);

        return $this->userRepository->findById($id);
    }

    /**
     * Menghapus user dengan validasi bisnis
     */
    public function deleteUser(int $id): bool
    {
        $user = $this->userRepository->findById($id);
        if (!$user) {
            throw new Exception('User tidak ditemukan');
        }

        // Validasi user tidak memiliki peminjaman aktif
        if ($user->peminjamans()->where('status', 'dipinjam')->exists()) {
            throw new Exception('User tidak dapat dihapus karena masih memiliki peminjaman aktif');
        }

        // Validasi bukan admin utama (opsional, sesuai kebutuhan)
        if ($user->role === 'admin' && $user->email === 'admin@pinjemtent.com') {
            throw new Exception('Admin utama tidak dapat dihapus');
        }

        return $this->userRepository->delete($id);
    }

    /**
     * Mengambil user berdasarkan role
     */
    public function getUsersByRole(string $role): Collection
    {
        return $this->userRepository->getUsersByRole($role);
    }

    /**
     * Mengambil user yang memiliki peminjaman aktif
     */
    public function getUsersWithActivePeminjaman(): Collection
    {
        return $this->userRepository->getUsersWithActivePeminjaman();
    }

    /**
     * Mencari user berdasarkan nama atau email
     */
    public function searchUser(string $search, int $perPage = 15): LengthAwarePaginator
    {
        return $this->userRepository->getAll(['search' => $search], $perPage);
    }

    /**
     * Mengambil semua anggota (user dengan role 'user')
     */
    public function getAllAnggota(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $filters['role'] = 'user';
        return $this->userRepository->getAll($filters, $perPage);
    }

    /**
     * Update role user
     */
    public function updateRole(int $id, string $role): bool
    {
        $user = $this->userRepository->findById($id);
        if (!$user) {
            throw new Exception('User tidak ditemukan');
        }

        // Validasi role yang valid
        $validRoles = ['admin', 'user'];
        if (!in_array($role, $validRoles)) {
            throw new Exception('Role tidak valid');
        }

        return $this->userRepository->update($id, ['role' => $role]);
    }
}
