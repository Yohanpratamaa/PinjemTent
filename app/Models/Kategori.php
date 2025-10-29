<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Model Kategori - Mewakili kategori untuk unit
 *
 * @property string $nama_kategori Nama kategori
 * @property string $deskripsi Deskripsi kategori
 */
class Kategori extends Model
{
    protected $fillable = [
        'nama_kategori',
        'deskripsi_kategori'
    ];

    /**
     * Relasi many-to-many dengan Unit
     * Satu kategori dapat memiliki banyak unit
     */
    public function units(): BelongsToMany
    {
        return $this->belongsToMany(Unit::class, 'unit_kategori');
    }

    /**
     * Scope untuk pencarian berdasarkan nama kategori
     */
    public function scopeSearch($query, $search)
    {
        return $query->where('nama_kategori', 'like', '%' . $search . '%');
    }
}
