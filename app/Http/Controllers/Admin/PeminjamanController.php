<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Unit;
use App\Models\User;
use App\Services\Admin\PeminjamanService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class PeminjamanController extends Controller
{
    public function __construct(
        private PeminjamanService $peminjamanService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $filters = [
            'search' => $request->get('search'),
            'status' => $request->get('status'),
            'date_from' => $request->get('date_from'),
            'date_to' => $request->get('date_to'),
        ];

        $peminjamans = $this->peminjamanService->getAllPeminjaman($filters, 15);

        // Get statistics with Indonesian status values
        $stats = [
            'dipinjam' => Peminjaman::where('status', 'dipinjam')->count(),
            'dikembalikan' => Peminjaman::where('status', 'dikembalikan')->count(),
            'terlambat' => Peminjaman::where('status', 'terlambat')->count(),
            'monthly_revenue' => Peminjaman::whereMonth('created_at', now()->month)
                                         ->whereYear('created_at', now()->year)
                                         ->sum('total_bayar'),
            'monthly_revenue_formatted' => \App\Helpers\CurrencyHelper::formatIDR(
                Peminjaman::whereMonth('created_at', now()->month)
                          ->whereYear('created_at', now()->year)
                          ->sum('total_bayar')
            ),
        ];

        return view('admin.peminjamans.index', compact('peminjamans', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $users = User::where('role', 'user')->get();
        $units = Unit::where('status', 'tersedia')->get();
        return view('admin.peminjamans.create', compact('users', 'units'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'unit_id' => 'required|exists:units,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali_rencana' => 'required|date|after:tanggal_pinjam',
            'catatan' => 'nullable|string|max:500',
        ]);

        try {
            $peminjaman = $this->peminjamanService->createPeminjaman($validated);

            return redirect()
                ->route('admin.peminjamans.show', $peminjaman)
                ->with('success', 'Rental created successfully. Total amount: ' . $peminjaman->getFormattedTotalBayar());
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to create rental: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Peminjaman $peminjaman): View
    {
        $peminjaman->load(['user', 'unit']);
        return view('admin.peminjamans.show', compact('peminjaman'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Peminjaman $peminjaman): View
    {
        $users = User::where('role', 'user')->get();
        $units = Unit::all();
        return view('admin.peminjamans.edit', compact('peminjaman', 'users', 'units'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Peminjaman $peminjaman): RedirectResponse
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'unit_id' => 'required|exists:units,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali_rencana' => 'required|date|after:tanggal_pinjam',
            'catatan_peminjam' => 'nullable|string|max:500',
            'catatan_admin' => 'nullable|string|max:500',
        ]);

        try {
            // Recalculate amounts if dates changed
            if ($peminjaman->tanggal_pinjam != $validated['tanggal_pinjam'] ||
                $peminjaman->tanggal_kembali_rencana != $validated['tanggal_kembali_rencana']) {

                $tanggalPinjam = \Carbon\Carbon::parse($validated['tanggal_pinjam']);
                $tanggalKembaliRencana = \Carbon\Carbon::parse($validated['tanggal_kembali_rencana']);
                $jumlahHari = $tanggalPinjam->diffInDays($tanggalKembaliRencana) + 1;

                $validated['harga_sewa_total'] = $peminjaman->unit->harga_sewa_per_hari * $jumlahHari;
                $validated['total_bayar'] = $validated['harga_sewa_total'] + $peminjaman->denda_total;
            }

            $peminjaman->update($validated);

            return redirect()
                ->route('admin.peminjamans.show', $peminjaman)
                ->with('success', 'Rental updated successfully. Total amount: ' . $peminjaman->getFormattedTotalBayar());
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to update rental: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Peminjaman $peminjaman): RedirectResponse
    {
        try {
            // Simple deletion for now
            $peminjaman->delete();

            return redirect()
                ->route('admin.peminjamans.index')
                ->with('success', 'Rental deleted successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Failed to delete rental: ' . $e->getMessage());
        }
    }

    /**
     * Mark peminjaman as returned.
     */
    public function returnRental(Request $request, Peminjaman $peminjaman): RedirectResponse
    {
        $validated = $request->validate([
            'catatan_admin' => 'nullable|string|max:500',
        ]);

        try {
            $this->peminjamanService->prosesKembalikan($peminjaman->id, $validated);

            // Reload peminjaman to get updated data
            $peminjaman->refresh();

            $message = 'Rental marked as returned successfully.';
            if ($peminjaman->denda_total > 0) {
                $message .= ' Late fee applied: ' . $peminjaman->getFormattedDendaTotal();
            }
            $message .= ' Total amount: ' . $peminjaman->getFormattedTotalBayar();

            return redirect()
                ->route('admin.peminjamans.show', $peminjaman)
                ->with('success', $message);
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Failed to return rental: ' . $e->getMessage());
        }
    }
}
