<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'user_id',
        'peminjaman_id',
        'title',
        'message',
        'data',
        'read_at',
        'is_admin_notification'
    ];

    protected $casts = [
        'data' => 'array',
        'read_at' => 'datetime',
        'is_admin_notification' => 'boolean'
    ];

    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class);
    }

    /**
     * Scopes
     */
    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }

    public function scopeForAdmin($query)
    {
        return $query->where('is_admin_notification', true);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId)->where('is_admin_notification', false);
    }

    public function scopeReturnRequests($query)
    {
        return $query->where('type', 'return_request');
    }

    public function scopeRentalRequests($query)
    {
        return $query->where('type', 'rental_request');
    }

    /**
     * Accessors & Mutators
     */
    public function getIsReadAttribute()
    {
        return !is_null($this->read_at);
    }

    public function getTimeAgoAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    /**
     * Methods
     */
    public function markAsRead()
    {
        if (is_null($this->read_at)) {
            $this->update(['read_at' => now()]);
        }
    }

    /**
     * Static methods for creating notifications
     */
    public static function createReturnRequest($peminjaman, $message = null)
    {
        return static::create([
            'type' => 'return_request',
            'user_id' => $peminjaman->user_id,
            'peminjaman_id' => $peminjaman->id,
            'title' => 'Permintaan Pengembalian',
            'message' => $message ?? "Pengguna {$peminjaman->user->name} meminta untuk mengembalikan {$peminjaman->unit->nama_unit}",
            'is_admin_notification' => true,
            'data' => [
                'unit_name' => $peminjaman->unit->nama_unit,
                'user_name' => $peminjaman->user->name,
                'rental_period' => $peminjaman->tanggal_pinjam . ' - ' . $peminjaman->tanggal_kembali_rencana
            ]
        ]);
    }

    public static function createReturnApproved($peminjaman)
    {
        return static::create([
            'type' => 'return_approved',
            'user_id' => $peminjaman->user_id,
            'peminjaman_id' => $peminjaman->id,
            'title' => 'Pengembalian Disetujui',
            'message' => "Pengembalian {$peminjaman->unit->nama_unit} telah disetujui oleh admin",
            'is_admin_notification' => false,
            'data' => [
                'unit_name' => $peminjaman->unit->nama_unit,
                'returned_at' => now()->format('d/m/Y H:i')
            ]
        ]);
    }

    /**
     * Create notification for new rental request (for admin)
     */
    public static function createRentalRequest($peminjaman)
    {
        return static::create([
            'type' => 'rental_request',
            'user_id' => $peminjaman->user_id,
            'peminjaman_id' => $peminjaman->id,
            'title' => 'Permintaan Penyewaan Baru',
            'message' => "Pengguna {$peminjaman->user->name} meminta untuk menyewa {$peminjaman->unit->nama_unit}",
            'is_admin_notification' => true,
            'data' => [
                'unit_name' => $peminjaman->unit->nama_unit,
                'user_name' => $peminjaman->user->name,
                'rental_period' => $peminjaman->tanggal_pinjam . ' - ' . $peminjaman->tanggal_kembali_rencana,
                'quantity' => $peminjaman->jumlah,
                'total_price' => $peminjaman->harga_sewa_total
            ]
        ]);
    }

    /**
     * Create notification for rental approved (for user)
     */
    public static function createRentalApproved($peminjaman)
    {
        return static::create([
            'type' => 'rental_approved',
            'user_id' => $peminjaman->user_id,
            'peminjaman_id' => $peminjaman->id,
            'title' => 'Penyewaan Disetujui',
            'message' => "Penyewaan {$peminjaman->unit->nama_unit} telah disetujui oleh admin",
            'is_admin_notification' => false,
            'data' => [
                'unit_name' => $peminjaman->unit->nama_unit,
                'approved_at' => now()->format('d/m/Y H:i'),
                'rental_period' => $peminjaman->tanggal_pinjam . ' - ' . $peminjaman->tanggal_kembali_rencana
            ]
        ]);
    }

    /**
     * Create notification for rental rejected (for user)
     */
    public static function createRentalRejected($peminjaman, $reason = null)
    {
        return static::create([
            'type' => 'rental_rejected',
            'user_id' => $peminjaman->user_id,
            'peminjaman_id' => $peminjaman->id,
            'title' => 'Penyewaan Ditolak',
            'message' => "Penyewaan {$peminjaman->unit->nama_unit} ditolak oleh admin" . ($reason ? ": {$reason}" : ''),
            'is_admin_notification' => false,
            'data' => [
                'unit_name' => $peminjaman->unit->nama_unit,
                'rejected_at' => now()->format('d/m/Y H:i'),
                'reason' => $reason
            ]
        ]);
    }
}
