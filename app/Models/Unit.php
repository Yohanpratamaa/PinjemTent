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
        'deskripsi',
        'status',
        'stok'
    ];

    protected $casts = [
        'stok' => 'integer'
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
        return $this->hasMany(Peminjaman::class);
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
}
