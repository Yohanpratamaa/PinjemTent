<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/**
 * Request class untuk validasi input saat membuat unit baru
 * Layer ini bertanggung jawab untuk memvalidasi data yang masuk
 */
class StoreUnitRequest extends FormRequest
{
    /**
     * Menentukan apakah user memiliki otorisasi untuk request ini
     * Hanya admin yang dapat membuat unit
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
            'kode_unit' => [
                'required',
                'string',
                'max:20',
                'unique:units,kode_unit' // Kode unit harus unik
            ],
            'nama_unit' => [
                'required',
                'string',
                'max:255'
            ],
            'merk' => [
                'nullable',
                'string',
                'max:100'
            ],
            'kapasitas' => [
                'nullable',
                'string',
                'max:100'
            ],
            'deskripsi' => [
                'nullable',
                'string',
                'max:1000'
            ],
            'foto' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif',
                'max:2048' // Max 2MB
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
            'harga_sewa_per_hari' => [
                'nullable',
                'numeric',
                'min:0',
                'max:99999999.99'
            ],
            'denda_per_hari' => [
                'nullable',
                'numeric',
                'min:0',
                'max:99999999.99'
            ],
            'harga_beli' => [
                'nullable',
                'numeric',
                'min:0',
                'max:999999999999.99'
            ],
            'kategoris' => [
                'nullable',
                'array'
            ],
            'kategoris.*' => [
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
            'merk.max' => 'Merk maksimal 100 karakter',
            'kapasitas.max' => 'Kapasitas maksimal 100 karakter',
            'status.in' => 'Status harus berupa: tersedia, dipinjam, atau maintenance',
            'stok.min' => 'Stok tidak boleh kurang dari 0',
            'harga_sewa_per_hari.numeric' => 'Harga sewa harus berupa angka',
            'harga_sewa_per_hari.min' => 'Harga sewa tidak boleh negatif',
            'denda_per_hari.numeric' => 'Denda harus berupa angka',
            'denda_per_hari.min' => 'Denda tidak boleh negatif',
            'harga_beli.numeric' => 'Harga beli harus berupa angka',
            'harga_beli.min' => 'Harga beli tidak boleh negatif',
            'foto.image' => 'File harus berupa gambar',
            'foto.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif',
            'foto.max' => 'Ukuran gambar maksimal 2MB',
            'kategoris.*.exists' => 'Kategori yang dipilih tidak valid'
        ];
    }
}
