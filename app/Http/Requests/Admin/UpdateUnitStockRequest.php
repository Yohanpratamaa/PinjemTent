<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

/**
 * Request class untuk validasi input saat mengupdate stock unit
 * Layer ini bertanggung jawab untuk memvalidasi data stock dengan aturan bisnis
 */
class UpdateUnitStockRequest extends FormRequest
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
        $unit = $this->route('unit');
        $activeRentals = $unit ? $unit->peminjamans()->where('status', 'dipinjam')->count() : 0;

        return [
            'kode_unit' => [
                'required',
                'string',
                'max:20',
                'regex:/^[A-Z0-9\-]{3,20}$/', // Allow uppercase letters, numbers, and hyphens
                Rule::unique('units', 'kode_unit')->ignore($unit?->id)
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
                'min:0', // Allow 0 stock
                'max:9999' // Maksimal untuk mencegah input yang tidak masuk akal
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
        $unit = $this->route('unit');
        $activeRentals = $unit ? $unit->peminjamans()->where('status', 'dipinjam')->count() : 0;

        return [
            'kode_unit.required' => 'Kode unit wajib diisi',
            'kode_unit.unique' => 'Kode unit sudah digunakan',
            'kode_unit.regex' => 'Kode unit harus berupa 3-20 karakter huruf besar, angka, dan tanda minus saja',
            'nama_unit.required' => 'Nama unit wajib diisi',
            'merk.max' => 'Merk maksimal 100 karakter',
            'kapasitas.max' => 'Kapasitas maksimal 100 karakter',
            'status.in' => 'Status harus berupa: tersedia, dipinjam, atau maintenance',
            'stok.required' => 'Stock unit wajib diisi',
            'stok.integer' => 'Stock harus berupa angka',
            'stok.min' => 'Stock tidak boleh negatif',
            'stok.max' => 'Stock maksimal adalah 9999',
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

    /**
     * Mempersiapkan data untuk validasi
     */
    protected function prepareForValidation(): void
    {
        // Ambil unit yang sedang diedit untuk fallback
        $unit = $this->route('unit');
        $fallbackStock = $unit ? $unit->stok : 0;

        // Pastikan stok selalu integer dan tidak null, minimal 0
        if ($this->has('stok')) {
            $stok = $this->input('stok');
            $stok = trim($stok); // Hapus whitespace

            if (is_numeric($stok) && !empty($stok)) {
                $processedStok = (int) $stok;
                // Pastikan minimal 0 (boleh 0)
                $processedStok = max(0, $processedStok);
            } else {
                // Jika kosong atau tidak valid, gunakan stock lama dari database
                $processedStok = $fallbackStock;
            }

            $this->merge([
                'stok' => $processedStok
            ]);

            // Log untuk debugging
            Log::info('Stock preprocessing', [
                'original' => $this->input('stok'),
                'processed' => $processedStok,
                'fallback_used' => !is_numeric($stok) || empty($stok),
                'unit_id' => $unit?->id
            ]);
        } else {
            // Jika tidak ada field stok, gunakan stock lama
            $this->merge([
                'stok' => $fallbackStock
            ]);
        }
    }

    /**
     * Validasi setelah semua rules terpenuhi
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $unit = $this->route('unit');
            $newStock = $this->input('stok');
            $activeRentals = $unit ? $unit->peminjamans()->where('status', 'dipinjam')->count() : 0;

            if ($unit && $newStock !== null) {
                // Warning jika stock kurang dari rental aktif (tapi masih boleh)
                if ($activeRentals > 0 && $newStock < $activeRentals) {
                    $validator->errors()->add('stok',
                        "Warning: Stock ({$newStock}) kurang dari rental aktif ({$activeRentals}). " .
                        "Pastikan ini sesuai dengan kondisi yang diinginkan."
                    );
                }

                // Cek apakah stock yang diinput masuk akal
                if ($newStock > 1000) {
                    $validator->errors()->add('stok', 'Stock yang dimasukkan terlalu besar. Harap periksa kembali.');
                }

                // Log attempt to change stock
                Log::info('Stock update attempt', [
                    'unit_id' => $unit->id,
                    'unit_code' => $unit->kode_unit,
                    'old_stock' => $unit->stok,
                    'new_stock' => $newStock,
                    'active_rentals' => $activeRentals,
                    'user_id' => Auth::id()
                ]);
            }
        });
    }
}
