<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/**
 * Request class untuk validasi input saat membuat kategori baru
 * Layer ini bertanggung jawab untuk memvalidasi data yang masuk
 */
class StoreKategoriRequest extends FormRequest
{
    /**
     * Menentukan apakah user memiliki otorisasi untuk request ini
     * Hanya admin yang dapat membuat kategori
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
        return [
            'nama_kategori' => [
                'required',
                'string',
                'max:255',
                'unique:kategoris,nama_kategori'
            ],
            'deskripsi' => [
                'nullable',
                'string',
                'max:1000'
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
            'nama_kategori.max' => 'Nama kategori maksimal 255 karakter'
        ];
    }
}
