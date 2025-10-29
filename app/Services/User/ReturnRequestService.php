<?php

namespace App\Services\User;

use App\Models\Peminjaman;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReturnRequestService
{
    /**
     * Request return for a rental
     */
    public function requestReturn($rentalId, $userId, $message = null)
    {
        try {
            DB::beginTransaction();

            $rental = Peminjaman::where('id', $rentalId)
                               ->where('user_id', $userId)
                               ->first();

            if (!$rental) {
                return [
                    'success' => false,
                    'message' => 'Penyewaan tidak ditemukan.'
                ];
            }

            if (!$rental->can_request_return) {
                if ($rental->status !== 'dipinjam') {
                    return [
                        'success' => false,
                        'message' => 'Penyewaan tidak dalam status dipinjam.'
                    ];
                }

                if ($rental->return_status === 'requested') {
                    return [
                        'success' => false,
                        'message' => 'Permintaan pengembalian sudah diajukan sebelumnya.'
                    ];
                }

                if (now()->startOfDay() < $rental->tanggal_kembali_rencana->startOfDay()) {
                    $daysLeft = now()->startOfDay()->diffInDays($rental->tanggal_kembali_rencana->startOfDay());
                    return [
                        'success' => false,
                        'message' => "Belum mencapai jatuh tempo. Masih {$daysLeft} hari lagi bisa mengajukan pengembalian."
                    ];
                }
            }

            // Update rental status
            $rental->update([
                'return_status' => 'requested',
                'return_requested_at' => now(),
                'return_message' => $message
            ]);

            // Create notification for admin
            Notification::createReturnRequest($rental, $message);

            DB::commit();

            return [
                'success' => true,
                'message' => 'Permintaan pengembalian berhasil dikirim ke admin. Silakan tunggu konfirmasi.'
            ];

        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengajukan permintaan pengembalian.'
            ];
        }
    }

    /**
     * Get rental details with return status
     */
    public function getRentalWithReturnInfo($rentalId, $userId)
    {
        return Peminjaman::with(['unit.kategoris', 'user', 'approvedBy'])
                        ->where('id', $rentalId)
                        ->where('user_id', $userId)
                        ->first();
    }

    /**
     * Check if rental can request return with detailed info
     */
    public function getReturnAvailabilityInfo($rental)
    {
        if ($rental->status !== 'dipinjam') {
            return [
                'can_request' => false,
                'reason' => 'Penyewaan tidak dalam status dipinjam.',
                'status_info' => 'Status saat ini: ' . ucfirst($rental->status)
            ];
        }

        if ($rental->return_status === 'requested') {
            return [
                'can_request' => false,
                'reason' => 'Permintaan pengembalian sudah diajukan.',
                'status_info' => 'Menunggu persetujuan admin sejak ' . $rental->return_requested_at->format('d/m/Y H:i')
            ];
        }

        if ($rental->return_status === 'approved') {
            return [
                'can_request' => false,
                'reason' => 'Pengembalian sudah disetujui.',
                'status_info' => 'Disetujui pada ' . $rental->approved_return_at->format('d/m/Y H:i')
            ];
        }

        $now = now()->startOfDay();
        $dueDate = $rental->tanggal_kembali_rencana->startOfDay();

        if ($now < $dueDate) {
            $daysLeft = $now->diffInDays($dueDate);
            return [
                'can_request' => false,
                'reason' => 'Belum mencapai jatuh tempo.',
                'status_info' => "Jatuh tempo: {$rental->tanggal_kembali_rencana->format('d/m/Y')} ({$daysLeft} hari lagi)",
                'due_date' => $rental->tanggal_kembali_rencana,
                'days_left' => $daysLeft
            ];
        }

        $daysOverdue = $dueDate->diffInDays($now);
        return [
            'can_request' => true,
            'reason' => 'Sudah mencapai jatuh tempo.',
            'status_info' => $daysOverdue > 0 ?
                "Terlambat {$daysOverdue} hari dari jatuh tempo" :
                "Hari ini adalah jatuh tempo pengembalian",
            'due_date' => $rental->tanggal_kembali_rencana,
            'days_overdue' => $daysOverdue
        ];
    }
}
