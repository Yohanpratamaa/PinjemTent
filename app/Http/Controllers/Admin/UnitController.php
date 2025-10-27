<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\UnitResource;
use App\Http\Requests\Admin\UpdateUnitStockRequest;
use App\Models\Kategori;
use App\Models\Unit;
use App\Services\Admin\UnitService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class UnitController extends Controller
{
    public function __construct(
        private UnitService $unitService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $filters = [
            'search' => $request->get('search'),
            'status' => $request->get('status'),
            'category' => $request->get('category'),
        ];

        $units = $this->unitService->getAllUnits($filters, 15);
        $categories = Kategori::all();

        // Get statistics
        $stats = [
            'tersedia' => Unit::where('status', 'tersedia')->count(),
            'disewa' => Unit::where('status', 'disewa')->count(),
            'maintenance' => Unit::where('status', 'maintenance')->count(),
        ];

        return view('admin.units.index', compact('units', 'categories', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $categories = Kategori::all();
        return view('admin.units.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'kode_unit' => 'required|string|max:255|unique:units,kode_unit',
            'nama_unit' => 'required|string|max:255',
            'merk' => 'nullable|string|max:100',
            'kapasitas' => 'nullable|string|max:100',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:tersedia,maintenance',
            'stok' => 'required|integer|min:0',
            'harga_sewa_per_hari' => 'nullable|numeric|min:0',
            'denda_per_hari' => 'nullable|numeric|min:0',
            'harga_beli' => 'nullable|numeric|min:0',
            'kategoris' => 'nullable|array',
            'kategoris.*' => 'exists:kategoris,id'
        ]);

        try {
            $data = [
                'kode_unit' => $validated['kode_unit'],
                'nama_unit' => $validated['nama_unit'],
                'merk' => $validated['merk'] ?? null,
                'kapasitas' => $validated['kapasitas'] ?? null,
                'deskripsi' => $validated['deskripsi'] ?? null,
                'status' => $validated['status'],
                'stok' => $validated['stok'],
                'harga_sewa_per_hari' => $validated['harga_sewa_per_hari'] ?? null,
                'denda_per_hari' => $validated['denda_per_hari'] ?? null,
                'harga_beli' => $validated['harga_beli'] ?? null,
                'kategori_ids' => $validated['kategoris'] ?? []
            ];

            $unit = $this->unitService->createUnit($data);

            return redirect()
                ->route('admin.units.show', $unit)
                ->with('success', 'Unit created successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to create unit: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Unit $unit): View
    {
        $unit->load(['kategoris', 'peminjamans.user']);
        return view('admin.units.show', compact('unit'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Unit $unit): View
    {
        $categories = Kategori::all();
        $unit->load('kategoris');
        return view('admin.units.edit', compact('unit', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUnitStockRequest $request, Unit $unit): RedirectResponse
    {
        // Data sudah tervalidasi oleh UpdateUnitStockRequest
        $validated = $request->validated();

        // Log data yang akan diupdate untuk debugging
        Log::info('🔄 Unit UPDATE Operation Started (NOT DELETE)', [
            'operation' => 'UPDATE',
            'unit_id' => $unit->id,
            'unit_code' => $unit->kode_unit,
            'route_method' => $request->method(),
            'route_action' => $request->route()->getActionName(),
            'old_data' => [
                'kode_unit' => $unit->kode_unit,
                'nama_unit' => $unit->nama_unit,
                'merk' => $unit->merk,
                'kapasitas' => $unit->kapasitas,
                'deskripsi' => $unit->deskripsi,
                'status' => $unit->status,
                'stok' => $unit->stok,
                'harga_sewa_per_hari' => $unit->harga_sewa_per_hari,
                'denda_per_hari' => $unit->denda_per_hari,
                'harga_beli' => $unit->harga_beli,
            ],
            'validated_data' => $validated,
            'raw_request' => $request->all(),
            'user_id' => Auth::id()
        ]);

        try {
            $data = [
                'kode_unit' => $validated['kode_unit'],
                'nama_unit' => $validated['nama_unit'],
                'merk' => $validated['merk'] ?? $unit->merk,
                'kapasitas' => $validated['kapasitas'] ?? $unit->kapasitas,
                'deskripsi' => $validated['deskripsi'] ?? $unit->deskripsi, // Fallback ke nilai lama
                'status' => $validated['status'],
                'stok' => $validated['stok'], // Pastikan tidak null dan sudah tervalidasi
                'harga_sewa_per_hari' => $validated['harga_sewa_per_hari'] ?? $unit->harga_sewa_per_hari,
                'denda_per_hari' => $validated['denda_per_hari'] ?? $unit->denda_per_hari,
                'harga_beli' => $validated['harga_beli'] ?? $unit->harga_beli,
                'kategori_ids' => $validated['kategoris'] ?? []
            ];

            Log::info('Unit Update - Final Data to Service', [
                'unit_id' => $unit->id,
                'final_data' => $data
            ]);

            $updatedUnit = $this->unitService->updateUnit($unit->id, $data);

            Log::info('✅ Unit UPDATE Successful (NOT DELETE)', [
                'operation' => 'UPDATE_SUCCESS',
                'unit_id' => $unit->id,
                'updated_unit' => $updatedUnit->toArray()
            ]);

            return redirect()
                ->route('admin.units.show', $updatedUnit)
                ->with('success', 'Unit updated successfully.');
        } catch (\Exception $e) {
            Log::error('❌ Unit UPDATE Failed (NOT DELETE)', [
                'operation' => 'UPDATE_FAILED',
                'unit_id' => $unit->id,
                'error_message' => $e->getMessage(),
                'error_trace' => $e->getTraceAsString(),
                'validated_data' => $validated
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to update unit: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unit $unit): RedirectResponse
    {
        Log::info('🗑️ Unit DELETE Operation Started (NOT UPDATE)', [
            'operation' => 'DELETE',
            'unit_id' => $unit->id,
            'unit_code' => $unit->kode_unit,
            'unit_name' => $unit->nama_unit,
            'current_status' => $unit->status,
            'current_stock' => $unit->stok,
            'user_id' => Auth::id()
        ]);

        try {
            // Cek apakah unit sedang dipinjam
            $activeRentals = $unit->peminjamans()->where('status', 'dipinjam')->count();
            if ($activeRentals > 0) {
                Log::warning('Unit Delete Blocked - Active Rentals', [
                    'unit_id' => $unit->id,
                    'active_rentals' => $activeRentals
                ]);

                return redirect()
                    ->back()
                    ->with('error', "Cannot delete unit '{$unit->nama_unit}'. It has {$activeRentals} active rental(s).");
            }

            $unitData = $unit->toArray(); // Backup data untuk log
            $this->unitService->deleteUnit($unit->id);

            Log::info('🗑️ Unit DELETE Successful (NOT UPDATE)', [
                'operation' => 'DELETE_SUCCESS',
                'deleted_unit' => $unitData,
                'user_id' => Auth::id()
            ]);

            return redirect()
                ->route('admin.units.index')
                ->with('success', "Unit '{$unit->nama_unit}' deleted successfully.");
        } catch (\Exception $e) {
            Log::error('❌ Unit DELETE Failed (NOT UPDATE)', [
                'operation' => 'DELETE_FAILED',
                'unit_id' => $unit->id,
                'unit_code' => $unit->kode_unit,
                'error_message' => $e->getMessage(),
                'error_trace' => $e->getTraceAsString(),
                'user_id' => Auth::id()
            ]);

            return redirect()
                ->back()
                ->with('error', 'Failed to delete unit: ' . $e->getMessage());
        }
    }
}
