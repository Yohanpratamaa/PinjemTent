<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\UnitResource;
use App\Models\Kategori;
use App\Models\Unit;
use App\Services\Admin\UnitService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

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
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:tersedia,maintenance',
            'stok' => 'required|integer|min:0',
            'kategoris' => 'nullable|array',
            'kategoris.*' => 'exists:kategoris,id'
        ]);

        try {
            $data = [
                'kode_unit' => $validated['kode_unit'],
                'nama_unit' => $validated['nama_unit'],
                'deskripsi' => $validated['deskripsi'] ?? null,
                'status' => $validated['status'],
                'stok' => $validated['stok'],
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
    public function update(Request $request, Unit $unit): RedirectResponse
    {
        $validated = $request->validate([
            'kode_unit' => 'required|string|max:255|unique:units,kode_unit,' . $unit->id,
            'nama_unit' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:tersedia,disewa,maintenance',
            'stok' => 'required|integer|min:0',
            'kategoris' => 'nullable|array',
            'kategoris.*' => 'exists:kategoris,id'
        ]);

        try {
            $data = [
                'kode_unit' => $validated['kode_unit'],
                'nama_unit' => $validated['nama_unit'],
                'deskripsi' => $validated['deskripsi'] ?? null,
                'status' => $validated['status'],
                'stok' => $validated['stok'],
                'kategori_ids' => $validated['kategoris'] ?? []
            ];

            $updatedUnit = $this->unitService->updateUnit($unit->id, $data);

            return redirect()
                ->route('admin.units.show', $updatedUnit)
                ->with('success', 'Unit updated successfully.');
        } catch (\Exception $e) {
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
        try {
            $this->unitService->deleteUnit($unit->id);

            return redirect()
                ->route('admin.units.index')
                ->with('success', 'Unit deleted successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Failed to delete unit: ' . $e->getMessage());
        }
    }
}
