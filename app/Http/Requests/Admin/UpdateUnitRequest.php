<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

/**
 * Request class untuk validasi input saat mengupdate unit
 * Layer ini bertanggung jawab untuk memvalidasi data yang masuk
 */
class UpdateUnitRequest extends FormRequest
{
    /**
     * Menentukan apakah user memiliki otorisasi untuk request ini
     * Hanya admin yang dapat mengupdate unit
     */
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->role === 'admin';
    }

    /**
     * Aturan validasi yang diterapkan pada request
     */
    public function rules(): array
    {
        $unitId = $this->route('unit'); // Mengambil ID unit dari route parameter

        return [
            'kode_unit' => [
                'required',
                'string',
                'max:20',
                Rule::unique('units', 'kode_unit')->ignore($unitId) // Kecuali unit yang sedang diupdate
            ],
            'nama_unit' => [
                'required',
                'string',
                'max:255'
            ],
            'deskripsi' => [
                'nullable',
                'string',
                'max:1000'
            ],
            'status' => [
                'required',
                'in:tersedia,dipinjam,maintenance'
            ],
            'stok' => [
                'required',
                'integer',
                'min:0'
            ],
            'kategori_ids' => [
                'nullable',
                'array'
            ],
            'kategori_ids.*' => [
                'exists:kategoris,id'
            ]
        ];
    }

    /**
     * Pesan error custom untuk validasi
     */
    public function messages(): array
    {
        return [
            'kode_unit.required' => 'Kode unit wajib diisi',
            'kode_unit.unique' => 'Kode unit sudah digunakan',
            'nama_unit.required' => 'Nama unit wajib diisi',
            'status.in' => 'Status harus berupa: tersedia, dipinjam, atau maintenance',
            'stok.min' => 'Stok tidak boleh kurang dari 0',
            'kategori_ids.*.exists' => 'Kategori yang dipilih tidak valid'
        ];
    }
}
