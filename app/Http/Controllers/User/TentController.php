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

        // Filter by category if requested
        if ($request->has('kategori') && $request->kategori != '') {
            $query->whereHas('kategoris', function($q) use ($request) {
                $q->where('kategoris.id', $request->kategori);
            });
        }

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $query->search($request->search);
        }

        $tents = $query->orderBy('nama_unit')->paginate(12);
        $kategoris = Kategori::orderBy('nama_kategori')->get();

        return view('user.tents.index', compact('tents', 'kategoris'));
    }

    /**
     * Display the specified tent details.
     */
    public function show(Unit $tent)
    {
        $tent->load('kategoris');
        return view('user.tents.show', compact('tent'));
    }
}
