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
     * Relasi one-to-many dengan Cart
     * Satu unit dapat berada di banyak keranjang
     */
    public function carts(): HasMany
    {
        return $this->hasMany(\App\Models\Cart::class);
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
        // Check if it's a URL (starts with http)
        if ($this->foto && (str_starts_with($this->foto, 'http://') || str_starts_with($this->foto, 'https://'))) {
            return $this->foto;
        }

        // Check local file if not URL
        if ($this->foto && file_exists(public_path('images/units/' . $this->foto))) {
            return asset('images/units/' . $this->foto);
        }

        // Default placeholder from CDN
        return $this->getDefaultPhotoUrl();
    }

    /**
     * Get whether unit has photo
     */
    public function getHasFotoAttribute(): bool
    {
        // Check if it's a URL
        if (!empty($this->foto) && (str_starts_with($this->foto, 'http://') || str_starts_with($this->foto, 'https://'))) {
            return true;
        }

        // Check local file
        return !empty($this->foto) && file_exists(public_path('images/units/' . $this->foto));
    }

    /**
     * Get default photo URL based on unit category or type
     */
    public function getDefaultPhotoUrl(): string
    {
        $unitName = strtolower($this->nama_unit);

        // Default camping equipment images from Unsplash/CDN
        if (str_contains($unitName, 'tenda')) {
            return 'https://images.unsplash.com/photo-1504851149312-7a075b496cc7?w=300&h=200&fit=crop';
        } elseif (str_contains($unitName, 'sleeping') || str_contains($unitName, 'bag')) {
            return 'https://images.unsplash.com/photo-1551698618-1dfe5d97d256?w=300&h=200&fit=crop';
        } elseif (str_contains($unitName, 'kompor') || str_contains($unitName, 'stove')) {
            return 'https://images.unsplash.com/photo-1563299796-17596ed6b017?w=300&h=200&fit=crop';
        } elseif (str_contains($unitName, 'tas') || str_contains($unitName, 'carrier') || str_contains($unitName, 'backpack')) {
            return 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=300&h=200&fit=crop';
        } elseif (str_contains($unitName, 'headlamp') || str_contains($unitName, 'lantern') || str_contains($unitName, 'light')) {
            return 'https://images.unsplash.com/photo-1558618047-3c8c76ca7d13?w=300&h=200&fit=crop';
        } elseif (str_contains($unitName, 'cookset') || str_contains($unitName, 'alat masak')) {
            return 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=300&h=200&fit=crop';
        } elseif (str_contains($unitName, 'compass') || str_contains($unitName, 'gps')) {
            return 'https://images.unsplash.com/photo-1566471539559-eafe1badc42b?w=300&h=200&fit=crop';
        } elseif (str_contains($unitName, 'water') || str_contains($unitName, 'filter')) {
            return 'https://images.unsplash.com/photo-1523362628745-0c100150b504?w=300&h=200&fit=crop';
        } elseif (str_contains($unitName, 'trekking') || str_contains($unitName, 'pole')) {
            return 'https://images.unsplash.com/photo-1551524164-bcea769a30ce?w=300&h=200&fit=crop';
        } elseif (str_contains($unitName, 'mattress') || str_contains($unitName, 'pillow')) {
            return 'https://images.unsplash.com/photo-1586075010923-2dd4570fb338?w=300&h=200&fit=crop';
        } else {
            // Generic camping equipment
            return 'https://images.unsplash.com/photo-1487730116645-74489c95b41b?w=300&h=200&fit=crop';
        }
    }
}
