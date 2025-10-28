<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Model Unit - Mewakili entitas unit yang dapat dipinjam
 *
 * @property string $kode_unit Kode unik untuk setiap unit
 * @property string $nama_unit Nama unit (bisa sama)
 * @property string $deskripsi Deskripsi unit
 * @property string $status Status unit (tersedia, dipinjam, maintenance)
 * @property int $stok Jumlah stok unit
 */
class Unit extends Model
{
    protected $fillable = [
        'kode_unit',
        'nama_unit',
        'merk',
        'kapasitas',
        'deskripsi',
        'foto',
        'status',
        'stok',
        'harga_sewa_per_hari',
        'denda_per_hari',
        'harga_beli'
    ];

    protected $casts = [
        'stok' => 'integer',
        'harga_sewa_per_hari' => 'decimal:2',
        'denda_per_hari' => 'decimal:2',
        'harga_beli' => 'decimal:2'
    ];

    protected $attributes = [
        'status' => 'tersedia',
        'stok' => 1,
        'harga_sewa_per_hari' => 50000,
        'denda_per_hari' => 10000,
    ];

    /**
     * Relasi many-to-many dengan Kategori
     * Satu unit dapat memiliki banyak kategori
     */
    public function kategoris(): BelongsToMany
    {
        return $this->belongsToMany(Kategori::class, 'unit_kategori');
    }

    /**
     * Relasi one-to-many dengan Peminjaman
     * Satu unit dapat dipinjam berkali-kali (riwayat)
     */
    public function peminjamans(): HasMany
    {
        return $this->hasMany(\App\Models\Peminjaman::class);
    }

    /**
     * Format harga sewa per hari ke IDR
     */
    public function getFormattedHargaSewaPerHari(): string
    {
        return 'Rp ' . number_format($this->harga_sewa_per_hari, 0, ',', '.');
    }

    /**
     * Format denda per hari ke IDR
     */
    public function getFormattedDendaPerHari(): string
    {
        return 'Rp ' . number_format($this->denda_per_hari, 0, ',', '.');
    }

    /**
     * Format harga beli ke IDR
     */
    public function getFormattedHargaBeli(): string
    {
        return 'Rp ' . number_format($this->harga_beli ?? 0, 0, ',', '.');
    }

    /**
     * Scope untuk unit yang tersedia
     */
    public function scopeTersedia($query)
    {
        return $query->where('status', 'tersedia')->where('stok', '>', 0);
    }

    /**
     * Scope untuk unit yang sedang dipinjam
     */
    public function scopeDipinjam($query)
    {
        return $query->where('status', 'dipinjam');
    }

    /**
     * Scope untuk pencarian berdasarkan nama unit
     */
    public function scopeSearch($query, $search)
    {
        return $query->where('nama_unit', 'like', '%' . $search . '%')
                    ->orWhere('kode_unit', 'like', '%' . $search . '%');
    }

    /**
     * Get count of active rentals (currently being rented)
     */
    public function getActiveRentalsCountAttribute(): int
    {
        return $this->peminjamans()
                    ->where('status', 'dipinjam')
                    ->sum('jumlah');
    }

    /**
     * Get active rental records
     */
    public function getActiveRentalsAttribute()
    {
        return $this->peminjamans()
                    ->where('status', 'dipinjam')
                    ->with('user')
                    ->get();
    }

    /**
     * Get available stock (total stock - currently rented)
     */
    public function getAvailableStockAttribute(): int
    {
        return max(0, $this->stok - $this->active_rentals_count);
    }

    /**
     * Check if unit is available for rental
     */
    public function getIsAvailableAttribute(): bool
    {
        return $this->status === 'tersedia' && $this->available_stock > 0;
    }

    /**
     * Get photo URL for the unit
     */
    public function getFotoUrlAttribute(): string
    {
        if ($this->foto && file_exists(public_path('images/units/' . $this->foto))) {
            return asset('images/units/' . $this->foto);
        }
        return asset('images/no-image.jpg'); // Default image
    }

    /**
     * Get whether unit has photo
     */
    public function getHasFotoAttribute(): bool
    {
        return !empty($this->foto) && file_exists(public_path('images/units/' . $this->foto));
    }
}
