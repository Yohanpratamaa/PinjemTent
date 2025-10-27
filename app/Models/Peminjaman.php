<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model Peminjaman - Mewakili transaksi peminjaman unit
 *
 * @property int $user_id ID user yang meminjam
 * @property int $unit_id ID unit yang dipinjam
 * @property date $tanggal_pinjam Tanggal peminjaman
 * @property date $tanggal_kembali_rencana Tanggal rencana pengembalian
 * @property date $tanggal_kembali_aktual Tanggal pengembalian aktual
 * @property string $status Status peminjaman
 * @property string $catatan Catatan tambahan
 */
class Peminjaman extends Model
{
    /**
     * Nama tabel dalam database
     */
    protected $table = 'peminjamans';

    protected $fillable = [
        'user_id',
        'unit_id',
        'tanggal_pinjam',
        'tanggal_kembali_rencana',
        'tanggal_kembali_aktual',
        'status',
        'catatan'
    ];

    protected $casts = [
        'tanggal_pinjam' => 'date',
        'tanggal_kembali_rencana' => 'date',
        'tanggal_kembali_aktual' => 'date'
    ];

    /**
     * Relasi dengan User yang meminjam
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi dengan Unit yang dipinjam
     */
    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    /**
     * Scope untuk peminjaman yang masih aktif
     */
    public function scopeAktif($query)
    {
        return $query->where('status', 'dipinjam');
    }

    /**
     * Scope untuk peminjaman yang sudah dikembalikan
     */
    public function scopeDikembalikan($query)
    {
        return $query->where('status', 'dikembalikan');
    }

    /**
     * Scope untuk peminjaman yang terlambat
     */
    public function scopeTerlambat($query)
    {
        return $query->where('status', 'terlambat')
                    ->orWhere(function($q) {
                        $q->where('status', 'dipinjam')
                          ->where('tanggal_kembali_rencana', '<', now());
                    });
    }

    /**
     * Accessor untuk mengecek apakah peminjaman terlambat
     */
    public function getIsTerlambatAttribute(): bool
    {
        return $this->status === 'dipinjam' &&
               $this->tanggal_kembali_rencana < now();
    }
}
