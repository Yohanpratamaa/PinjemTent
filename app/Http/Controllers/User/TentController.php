<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use App\Models\Kategori;
use Illuminate\Http\Request;

class TentController extends Controller
{
    /**
     * Display a listing of available tents for rent.
     */
    public function index(Request $request)
    {
        $query = Unit::with('kategoris')->tersedia();
        $selectedKategori = null;

        // Filter by category if requested
        if ($request->has('kategori') && $request->kategori != '') {
            $selectedKategori = Kategori::find($request->kategori);
            if ($selectedKategori) {
                $query->whereHas('kategoris', function($q) use ($request) {
                    $q->where('kategoris.id', $request->kategori);
                });
            }
        }

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $query->search($request->search);
        }

        $tents = $query->orderBy('nama_unit')->paginate(12);

        // Get all categories (not filtered)
        $kategoris = Kategori::orderBy('nama_kategori')->get();

        // Debug: Log categories for troubleshooting
        \Log::info('TentController: Total categories loaded for user', [
            'count' => $kategoris->count(),
            'categories' => $kategoris->pluck('nama_kategori')->toArray()
        ]);

        return view('user.tents.index', compact('tents', 'kategoris', 'selectedKategori'));
    }

    /**
     * Display the specified tent details.
     */
    public function show(Unit $tent)
    {
        $tent->load('kategoris');
        return view('user.tents.show', compact('tent'));
    }

    /**
     * Show the rental form for a specific tent.
     */
    public function rent(Unit $tent)
    {
        // Check if tent is available
        if (!$tent->is_available) {
            return redirect()->route('user.tents.show', $tent)
                ->with('error', 'Tenda ini sedang tidak tersedia untuk disewa.');
        }

        $tent->load('kategoris');
        return view('user.tents.rent', compact('tent'));
    }

    /**
     * Store the rental request.
     */
    public function storeRental(Request $request, Unit $tent)
    {
        // For now, just show a success message
        // Later this will be connected to the peminjaman system

        $validated = $request->validate([
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'jumlah' => 'required|integer|min:1|max:' . $tent->available_stock,
            'catatan' => 'nullable|string|max:500'
        ]);

        // For demonstration purposes, just redirect with success message
        return redirect()->route('user.tents.show', $tent)
            ->with('success', 'Permintaan sewa tenda berhasil dikirim! Kami akan menghubungi Anda segera.');
    }
}
