<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Unit;
use App\Services\Admin\KategoriService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class KategoriController extends Controller
{
    public function __construct(
        private KategoriService $kategoriService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $filters = [
            'search' => $request->get('search'),
            'sort' => $request->get('sort', 'name_asc'),
        ];

        $kategoris = $this->kategoriService->getAllKategoris($filters, 12);

        // Get statistics
        $stats = [
            'total_units' => Unit::count(),
            'avg_units' => round(Unit::count() / max(Kategori::count(), 1), 1),
            'empty_categories' => Kategori::doesntHave('units')->count(),
        ];

        return view('admin.kategoris.index', compact('kategoris', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $availableUnits = Unit::doesntHave('kategoris')->get();
        return view('admin.kategoris.create', compact('availableUnits'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategoris,nama_kategori',
            'deskripsi' => 'nullable|string',
            'units' => 'nullable|array',
            'units.*' => 'exists:units,id'
        ]);

        try {
            $data = [
                'nama_kategori' => $validated['nama_kategori'],
                'deskripsi' => $validated['deskripsi'] ?? null,
                'unit_ids' => $validated['units'] ?? []
            ];

            $kategori = $this->kategoriService->createKategori($data);

            return redirect()
                ->route('admin.kategoris.show', $kategori)
                ->with('success', 'Category created successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to create category: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Kategori $kategori): View
    {
        $kategori->load(['units']);
        return view('admin.kategoris.show', compact('kategori'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kategori $kategori): View
    {
        $availableUnits = Unit::all();
        $allUnits = $availableUnits;
        $kategori->load('units');
        return view('admin.kategoris.edit', compact('kategori', 'availableUnits', 'allUnits'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kategori $kategori): RedirectResponse
    {
        // Log data yang akan diupdate untuk debugging
        Log::info('🔄 Kategori UPDATE Operation Started (NOT DELETE)', [
            'operation' => 'UPDATE',
            'kategori_id' => $kategori->id,
            'kategori_name' => $kategori->nama_kategori,
            'route_method' => $request->method(),
            'route_action' => $request->route()->getActionName(),
            'old_data' => [
                'nama_kategori' => $kategori->nama_kategori,
                'deskripsi' => $kategori->deskripsi,
            ],
            'raw_request' => $request->all(),
            'user_id' => Auth::id()
        ]);

        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategoris,nama_kategori,' . $kategori->id,
            'deskripsi' => 'nullable|string',
            'units' => 'nullable|array',
            'units.*' => 'exists:units,id'
        ]);

        try {
            $data = [
                'nama_kategori' => $validated['nama_kategori'],
                'deskripsi' => $validated['deskripsi'] ?? null,
                'unit_ids' => $validated['units'] ?? []
            ];

            $updatedKategori = $this->kategoriService->updateKategori($kategori->id, $data);

            Log::info('✅ Kategori UPDATE Successful (NOT DELETE)', [
                'operation' => 'UPDATE_SUCCESS',
                'kategori_id' => $kategori->id,
                'updated_kategori' => $updatedKategori->toArray()
            ]);

            return redirect()
                ->route('admin.kategoris.show', $updatedKategori)
                ->with('success', 'Category updated successfully.');
        } catch (\Exception $e) {
            Log::error('❌ Kategori UPDATE Failed (NOT DELETE)', [
                'operation' => 'UPDATE_FAILED',
                'kategori_id' => $kategori->id,
                'error_message' => $e->getMessage(),
                'validated_data' => $validated,
                'user_id' => Auth::id()
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to update category: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kategori $kategori): RedirectResponse
    {
        Log::info('🗑️ Kategori DELETE Operation Started (NOT UPDATE)', [
            'operation' => 'DELETE',
            'kategori_id' => $kategori->id,
            'kategori_name' => $kategori->nama_kategori,
            'units_count' => $kategori->units->count(),
            'user_id' => Auth::id()
        ]);

        try {
            $kategoriData = $kategori->toArray(); // Backup data untuk log
            $this->kategoriService->deleteKategori($kategori->id);

            Log::info('🗑️ Kategori DELETE Successful (NOT UPDATE)', [
                'operation' => 'DELETE_SUCCESS',
                'deleted_kategori' => $kategoriData,
                'user_id' => Auth::id()
            ]);

            return redirect()
                ->route('admin.kategoris.index')
                ->with('success', 'Category deleted successfully.');
        } catch (\Exception $e) {
            Log::error('❌ Kategori DELETE Failed (NOT UPDATE)', [
                'operation' => 'DELETE_FAILED',
                'kategori_id' => $kategori->id,
                'error_message' => $e->getMessage(),
                'user_id' => Auth::id()
            ]);

            return redirect()
                ->back()
                ->with('error', 'Failed to delete category: ' . $e->getMessage());
        }
    }
}
