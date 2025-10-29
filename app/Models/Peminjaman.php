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
        'jumlah',
        'tanggal_pinjam',
        'tanggal_kembali_rencana',
        'tanggal_kembali_aktual',
        'status',
        'return_status',
        'return_requested_at',
        'return_message',
        'approved_return_at',
        'approved_by',
        'harga_sewa_total',
        'denda_total',
        'total_bayar',
        'catatan_peminjam',
        'catatan_admin'
    ];

    protected $casts = [
        'jumlah' => 'integer',
        'tanggal_pinjam' => 'date',
        'tanggal_kembali_rencana' => 'date',
        'tanggal_kembali_aktual' => 'date',
        'return_requested_at' => 'datetime',
        'approved_return_at' => 'datetime',
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
     * Relasi dengan admin yang menyetujui pengembalian
     */
    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Relasi dengan notifications
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class);
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
     * Accessor untuk mengecek apakah sudah jatuh tempo dan bisa request return
     */
    public function getCanRequestReturnAttribute(): bool
    {
        // Bisa request return jika:
        // 1. Status adalah 'dipinjam'
        // 2. Belum pernah request return atau request sebelumnya ditolak
        // 3. Sudah mencapai atau melewati tanggal jatuh tempo (tanggal_kembali_rencana)
        return $this->status === 'dipinjam' &&
               in_array($this->return_status, ['not_requested', 'rejected']) &&
               now()->startOfDay() >= $this->tanggal_kembali_rencana->startOfDay();
    }

    /**
     * Accessor untuk mengecek apakah sedang menunggu persetujuan return
     */
    public function getIsPendingReturnAttribute(): bool
    {
        return $this->return_status === 'requested';
    }

    /**
     * Method untuk request pengembalian
     */
    public function requestReturn($message = null): bool
    {
        if (!$this->can_request_return) {
            return false;
        }

        $this->update([
            'return_status' => 'requested',
            'return_requested_at' => now(),
            'return_message' => $message
        ]);

        // Create notification for admin
        Notification::createReturnRequest($this, $message);

        return true;
    }

    /**
     * Method untuk approve pengembalian oleh admin
     */
    public function approveReturn($adminId): bool
    {
        if ($this->return_status !== 'requested') {
            return false;
        }

        $this->update([
            'status' => 'dikembalikan',
            'return_status' => 'approved',
            'approved_return_at' => now(),
            'approved_by' => $adminId,
            'tanggal_kembali_aktual' => now()
        ]);

        // Return stock to unit
        $this->unit->increment('stok', $this->jumlah);

        // Create notification for user
        Notification::createReturnApproved($this);

        return true;
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
     * Calculate total rental cost based on unit price, rental days, and quantity
     */
    public function calculateHargaSewaTotal(): float
    {
        $hargaPerHari = $this->unit->harga_sewa_per_hari ?? 50000;
        $jumlahHari = $this->calculateRentalDays();
        $jumlahUnit = $this->jumlah ?? 1;
        return $hargaPerHari * $jumlahHari * $jumlahUnit;
    }

    /**
     * Calculate late fee based on unit late fee, late days, and quantity
     */
    public function calculateDendaTotal(): float
    {
        if ($this->status !== 'terlambat' && !$this->tanggal_kembali_aktual) {
            return 0;
        }

        $dendaPerHari = $this->unit->denda_per_hari ?? 10000;
        $hariTerlambat = $this->calculateLateDays();
        $jumlahUnit = $this->jumlah ?? 1;
        return $dendaPerHari * $hariTerlambat * $jumlahUnit;
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
