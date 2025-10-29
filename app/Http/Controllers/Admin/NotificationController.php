<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    /**
     * Display a listing of return request notifications.
     */
    public function index(Request $request)
    {
        // Get filter parameters
        $filter = $request->get('filter', 'all'); // all, unread, read

        $query = Notification::with(['user', 'peminjaman.unit'])
                             ->forAdmin()
                             ->returnRequests()
                             ->orderBy('created_at', 'desc');

        // Apply filters
        if ($filter === 'unread') {
            $query->unread();
        } elseif ($filter === 'read') {
            $query->whereNotNull('read_at');
        }

        $notifications = $query->paginate(15)->withQueryString();

        // Get statistics
        $stats = [
            'total' => Notification::forAdmin()->returnRequests()->count(),
            'unread' => Notification::forAdmin()->returnRequests()->unread()->count(),
            'today' => Notification::forAdmin()->returnRequests()
                                  ->whereDate('created_at', today())->count(),
        ];

        return view('admin.notifications.index', compact('notifications', 'stats', 'filter'));
    }

    /**
     * Display the specified notification.
     */
    public function show($id)
    {
        $notification = Notification::with(['user', 'peminjaman.unit.kategoris'])
                                   ->forAdmin()
                                   ->findOrFail($id);

        // Mark as read
        $notification->markAsRead();

        return view('admin.notifications.show', compact('notification'));
    }

    /**
     * Approve return request.
     */
    public function approve($id)
    {
        try {
            DB::beginTransaction();

            $notification = Notification::forAdmin()->findOrFail($id);
            $peminjaman = $notification->peminjaman;

            if ($peminjaman->return_status !== 'requested') {
                return redirect()->back()
                               ->with('error', 'Permintaan pengembalian tidak valid atau sudah diproses.');
            }

            // Approve the return
            $success = $peminjaman->approveReturn(Auth::id());

            if (!$success) {
                return redirect()->back()
                               ->with('error', 'Gagal menyetujui pengembalian.');
            }

            // Mark notification as read
            $notification->markAsRead();

            DB::commit();

            return redirect()->route('admin.notifications.show', $notification->id)
                           ->with('success', 'Pengembalian berhasil disetujui. Stock unit telah dikembalikan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                           ->with('error', 'Terjadi kesalahan saat menyetujui pengembalian.');
        }
    }

    /**
     * Reject return request.
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500'
        ]);

        try {
            DB::beginTransaction();

            $notification = Notification::forAdmin()->findOrFail($id);
            $peminjaman = $notification->peminjaman;

            if ($peminjaman->return_status !== 'requested') {
                return redirect()->back()
                               ->with('error', 'Permintaan pengembalian tidak valid atau sudah diproses.');
            }

            // Update return status to rejected
            $peminjaman->update([
                'return_status' => 'rejected',
                'approved_return_at' => now(),
                'approved_by' => Auth::id()
            ]);

            // Create notification for user about rejection
            Notification::create([
                'type' => 'return_rejected',
                'user_id' => $peminjaman->user_id,
                'peminjaman_id' => $peminjaman->id,
                'title' => 'Pengembalian Ditolak',
                'message' => "Permintaan pengembalian {$peminjaman->unit->nama_unit} ditolak. Alasan: {$request->rejection_reason}",
                'is_admin_notification' => false,
                'data' => [
                    'unit_name' => $peminjaman->unit->nama_unit,
                    'rejection_reason' => $request->rejection_reason,
                    'rejected_at' => now()->format('d/m/Y H:i')
                ]
            ]);

            // Mark notification as read
            $notification->markAsRead();

            DB::commit();

            return redirect()->route('admin.notifications.show', $notification->id)
                           ->with('success', 'Permintaan pengembalian berhasil ditolak.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                           ->with('error', 'Terjadi kesalahan saat menolak pengembalian.');
        }
    }

    /**
     * Mark notification as read.
     */
    public function markAsRead($id)
    {
        $notification = Notification::forAdmin()->findOrFail($id);
        $notification->markAsRead();

        return response()->json(['success' => true]);
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead()
    {
        Notification::forAdmin()->unread()->update(['read_at' => now()]);

        return redirect()->back()->with('success', 'Semua notifikasi telah ditandai sebagai dibaca.');
    }
}
