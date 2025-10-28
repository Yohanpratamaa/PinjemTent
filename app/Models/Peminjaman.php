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
        'kode_peminjaman',
        'tanggal_pinjam',
        'tanggal_kembali_rencana',
        'tanggal_kembali_aktual',
        'status',
        'harga_sewa_total',
        'denda_total',
        'total_bayar',
        'catatan_peminjam',
        'catatan_admin'
    ];

    protected $casts = [
        'tanggal_pinjam' => 'date',
        'tanggal_kembali_rencana' => 'date',
        'tanggal_kembali_aktual' => 'date',
        'harga_sewa_total' => 'decimal:2',
        'denda_total' => 'decimal:2',
        'total_bayar' => 'decimal:2'
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

    /**
     * Calculate rental days from tanggal_pinjam to tanggal_kembali_rencana
     */
    public function calculateRentalDays(): int
    {
        return $this->tanggal_pinjam->diffInDays($this->tanggal_kembali_rencana) + 1;
    }

    /**
     * Calculate late days if returned late
     */
    public function calculateLateDays(): int
    {
        if (!$this->tanggal_kembali_aktual || $this->tanggal_kembali_aktual <= $this->tanggal_kembali_rencana) {
            return 0;
        }
        return $this->tanggal_kembali_rencana->diffInDays($this->tanggal_kembali_aktual);
    }

    /**
     * Calculate total rental cost based on unit price and rental days
     */
    public function calculateHargaSewaTotal(): float
    {
        $hargaPerHari = $this->unit->harga_sewa_per_hari ?? 50000;
        $jumlahHari = $this->calculateRentalDays();
        return $hargaPerHari * $jumlahHari;
    }

    /**
     * Calculate late fee based on unit late fee and late days
     */
    public function calculateDendaTotal(): float
    {
        if ($this->status !== 'terlambat' && !$this->tanggal_kembali_aktual) {
            return 0;
        }

        $dendaPerHari = $this->unit->denda_per_hari ?? 10000;
        $hariTerlambat = $this->calculateLateDays();
        return $dendaPerHari * $hariTerlambat;
    }

    /**
     * Calculate total amount to pay (rental + late fees)
     */
    public function calculateTotalBayar(): float
    {
        return $this->calculateHargaSewaTotal() + $this->calculateDendaTotal();
    }

    /**
     * Format currency to IDR
     */
    public function getFormattedHargaSewaTotal(): string
    {
        return 'Rp ' . number_format($this->harga_sewa_total ?? $this->calculateHargaSewaTotal(), 0, ',', '.');
    }

    /**
     * Format denda to IDR
     */
    public function getFormattedDendaTotal(): string
    {
        return 'Rp ' . number_format($this->denda_total ?? $this->calculateDendaTotal(), 0, ',', '.');
    }

    /**
     * Format total bayar to IDR
     */
    public function getFormattedTotalBayar(): string
    {
        return 'Rp ' . number_format($this->total_bayar ?? $this->calculateTotalBayar(), 0, ',', '.');
    }
}
