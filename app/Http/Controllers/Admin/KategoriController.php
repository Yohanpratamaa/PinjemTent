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
use Illuminate\Support\Facades\DB;

class KategoriController extends Controller
{
    public function __construct(
        private KategoriService $kategoriService
    ) {}

    public function index(Request $request): View
    {
        $filters = [
            'search' => $request->get('search'),
            'sort' => $request->get('sort', 'name_asc'),
        ];

        $kategoris = $this->kategoriService->getAllKategoris($filters, 12);

        $stats = [
            'total_kategoris' => Kategori::count(),
            'total_units' => Unit::count(),
            'avg_units' => round(Unit::count() / max(Kategori::count(), 1), 1),
            'empty_categories' => Kategori::doesntHave('units')->count(),
        ];

        return view('admin.kategoris.index', compact('kategoris', 'stats'));
    }

    public function create(): View
    {
        $availableUnits = Unit::doesntHave('kategoris')->get();
        return view('admin.kategoris.create', compact('availableUnits'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategoris,nama_kategori',
            'deskripsi_kategori' => 'nullable|string',
            'units' => 'nullable|array',
            'units.*' => 'exists:units,id'
        ]);

        try {
            DB::beginTransaction();

            $data = [
                'nama_kategori' => $validated['nama_kategori'],
                'deskripsi_kategori' => $validated['deskripsi_kategori'] ?? null,
            ];

            $kategori = $this->kategoriService->createKategori($data);

            if (isset($validated['units']) && !empty($validated['units'])) {
                $kategori->units()->attach($validated['units']);
            }

            DB::commit();

            return redirect()
                ->route('admin.kategoris.index')
                ->with('success', 'Category created successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to create category: ' . $e->getMessage());
        }
    }

    public function show(Kategori $kategori): View
    {
        $kategori->load(['units']);
        return view('admin.kategoris.show', compact('kategori'));
    }

    public function edit(Kategori $kategori): View
    {
        $availableUnits = Unit::all();
        $allUnits = $availableUnits;
        $kategori->load('units');
        return view('admin.kategoris.edit', compact('kategori', 'availableUnits', 'allUnits'));
    }

    public function update(Request $request, Kategori $kategori): RedirectResponse
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategoris,nama_kategori,' . $kategori->id,
            'deskripsi_kategori' => 'nullable|string',
            'units' => 'nullable|array',
            'units.*' => 'exists:units,id'
        ]);

        try {
            DB::beginTransaction();

            $data = [
                'nama_kategori' => $validated['nama_kategori'],
                'deskripsi_kategori' => $validated['deskripsi_kategori'] ?? null,
            ];

            $updatedKategori = $this->kategoriService->updateKategori($kategori->id, $data);

            if (isset($validated['units'])) {
                $updatedKategori->units()->sync($validated['units']);
            } else {
                $updatedKategori->units()->detach();
            }

            DB::commit();

            return redirect()
                ->route('admin.kategoris.show', $updatedKategori)
                ->with('success', 'Category updated successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to update category: ' . $e->getMessage());
        }
    }

    public function destroy(Kategori $kategori): RedirectResponse
    {
        try {
            DB::beginTransaction();
            
            $kategori->units()->detach();
            $this->kategoriService->deleteKategori($kategori->id);
            
            DB::commit();

            return redirect()
                ->route('admin.kategoris.index')
                ->with('success', 'Category deleted successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()
                ->back()
                ->with('error', 'Failed to delete category: ' . $e->getMessage());
        }
    }
}