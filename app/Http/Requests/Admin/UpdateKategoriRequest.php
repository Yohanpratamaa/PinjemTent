<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

/**
 * Request class untuk validasi input saat mengupdate kategori
 * Layer ini bertanggung jawab untuk memvalidasi data yang masuk
 */
class UpdateKategoriRequest extends FormRequest
{
    /**
     * Menentukan apakah user memiliki otorisasi untuk request ini
     * Hanya admin yang dapat mengupdate kategori
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
        $kategoriId = $this->route('kategori'); // Mengambil ID kategori dari route parameter

        return [
            'nama_kategori' => [
                'required',
                'string',
                'max:255',
                Rule::unique('kategoris', 'nama_kategori')->ignore($kategoriId) // Kecuali kategori yang sedang diupdate
            ],
            'deskripsi' => [
                'nullable',
                'string',
                'max:1000'
            ],
            'units' => [
                'nullable',
                'array'
            ],
            'units.*' => [
                'exists:units,id'
            ]
        ];
    }

    /**
     * Pesan error custom untuk validasi
     */
    public function messages(): array
    {
        return [
            'nama_kategori.required' => 'Nama kategori wajib diisi',
            'nama_kategori.unique' => 'Nama kategori sudah digunakan',
            'nama_kategori.max' => 'Nama kategori maksimal 255 karakter',
            'deskripsi.max' => 'Deskripsi maksimal 1000 karakter',
            'units.*.exists' => 'Unit yang dipilih tidak valid'
        ];
    }
}
