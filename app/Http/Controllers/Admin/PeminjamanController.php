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

        // Get statistics
        $stats = [
            'active' => Peminjaman::where('status', 'active')->count(),
            'returned' => Peminjaman::where('status', 'returned')->count(),
            'overdue' => Peminjaman::where('status', 'overdue')->count(),
            'monthly_revenue' => 0, // TODO: calculate based on total_biaya
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
            'jumlah' => 'required|integer|min:1',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali_rencana' => 'required|date|after:tanggal_pinjam',
            'total_biaya' => 'nullable|numeric|min:0',
        ]);

        try {
            $peminjaman = $this->peminjamanService->createPeminjaman($validated);

            return redirect()
                ->route('admin.peminjamans.show', $peminjaman)
                ->with('success', 'Rental created successfully.');
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
            'jumlah' => 'required|integer|min:1',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali_rencana' => 'required|date|after:tanggal_pinjam',
            'total_biaya' => 'nullable|numeric|min:0',
            'denda' => 'nullable|numeric|min:0',
        ]);

        try {
            // For now, we'll use a simple approach since updatePeminjaman doesn't exist
            $peminjaman->update($validated);

            return redirect()
                ->route('admin.peminjamans.show', $peminjaman)
                ->with('success', 'Rental updated successfully.');
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
    public function returnRental(Peminjaman $peminjaman): RedirectResponse
    {
        try {
            $this->peminjamanService->prosesKembalikan($peminjaman->id, [
                'tanggal_kembali' => now(),
                'status' => 'dikembalikan'
            ]);

            return redirect()
                ->route('admin.peminjamans.show', $peminjaman)
                ->with('success', 'Rental marked as returned successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Failed to return rental: ' . $e->getMessage());
        }
    }
}
