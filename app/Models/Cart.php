<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

/**
 * Model Cart - Mewakili keranjang belanja untuk penyewaan tenda
 *
 * @property int $user_id
 * @property int $unit_id
 * @property int $quantity
 * @property string $tanggal_mulai
 * @property string $tanggal_selesai
 * @property string $notes
 * @property float $harga_per_hari
 * @property float $total_harga
 */
class Cart extends Model
{
    protected $fillable = [
        'user_id',
        'unit_id',
        'quantity',
        'tanggal_mulai',
        'tanggal_selesai',
        'notes',
        'harga_per_hari',
        'total_harga'
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'quantity' => 'integer',
        'harga_per_hari' => 'decimal:2',
        'total_harga' => 'decimal:2'
    ];

    /**
     * Relasi ke User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Unit
     */
    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    /**
     * Hitung durasi sewa dalam hari
     */
    public function getDurationAttribute(): int
    {
        return $this->tanggal_mulai->diffInDays($this->tanggal_selesai) + 1;
    }

    /**
     * Hitung total harga berdasarkan quantity, durasi, dan harga per hari
     */
    public function calculateTotal(): float
    {
        return $this->quantity * $this->duration * $this->harga_per_hari;
    }

    /**
     * Update total harga sebelum save
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($cart) {
            $cart->total_harga = $cart->calculateTotal();
        });
    }

    /**
     * Format harga per hari ke IDR
     */
    public function getFormattedHargaPerHariAttribute(): string
    {
        return 'Rp ' . number_format((float) $this->harga_per_hari, 0, ',', '.');
    }

    /**
     * Format total harga ke IDR
     */
    public function getFormattedTotalHargaAttribute(): string
    {
        return 'Rp ' . number_format((float) $this->total_harga, 0, ',', '.');
    }

    /**
     * Hitung denda jika durasi sewa lebih dari 5 hari
     */
    public function calculatePenalty(): float
    {
        if ($this->duration > 5) {
            $excessDays = $this->duration - 5;
            $penaltyPerDay = $this->unit->denda_per_hari ?? 0;
            return $this->quantity * $excessDays * $penaltyPerDay;
        }
        return 0;
    }

    /**
     * Format denda ke IDR
     */
    public function getFormattedPenaltyAttribute(): string
    {
        $penalty = $this->calculatePenalty();
        return 'Rp ' . number_format($penalty, 0, ',', '.');
    }

    /**
     * Check apakah sewa akan dikenakan denda
     */
    public function getHasPenaltyAttribute(): bool
    {
        return $this->duration > 5;
    }

    /**
     * Get excess days beyond 5 days
     */
    public function getExcessDaysAttribute(): int
    {
        return max(0, $this->duration - 5);
    }

    /**
     * Scope untuk keranjang user tertentu
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Check apakah tanggal tersedia untuk unit ini
     */
    public function isDateAvailable(): bool
    {
        // Check jika ada peminjaman aktif pada tanggal tersebut
        $conflictingRentals = \App\Models\Peminjaman::where('unit_id', $this->unit_id)
            ->where('status', '!=', 'dibatalkan')
            ->where(function ($query) {
                $query->whereBetween('tanggal_pinjam', [$this->tanggal_mulai, $this->tanggal_selesai])
                    ->orWhereBetween('tanggal_kembali_rencana', [$this->tanggal_mulai, $this->tanggal_selesai])
                    ->orWhere(function ($q) {
                        $q->where('tanggal_pinjam', '<=', $this->tanggal_mulai)
                          ->where('tanggal_kembali_rencana', '>=', $this->tanggal_selesai);
                    });
            })
            ->sum('jumlah');

        return ($conflictingRentals + $this->quantity) <= $this->unit->stok;
    }
}
