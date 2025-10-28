<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show the user dashboard.
     */
    public function index()
    {
        // Get featured/popular tents (available tents, limit to 4)
        $featuredTents = Unit::with('kategoris')
            ->tersedia()
            ->orderBy('stok', 'desc')
            ->orderBy('harga_sewa_per_hari')
            ->take(4)
            ->get();

        // Get solo traveler gear (carrier bags, sleeping bags, navigation tools)
        $soloGear = [
            'carriers' => Unit::with('kategoris')
                ->tersedia()
                ->whereHas('kategoris', function($q) {
                    $q->where('nama_kategori', 'like', '%Carrier%')
                        ->orWhere('nama_kategori', 'like', '%Tas%');
                })
                ->take(3)
                ->get(),

            'sleeping' => Unit::with('kategoris')
                ->tersedia()
                ->whereHas('kategoris', function($q) {
                    $q->where('nama_kategori', 'like', '%Sleeping%');
                })
                ->take(3)
                ->get(),

            'navigation' => Unit::with('kategoris')
                ->tersedia()
                ->whereHas('kategoris', function($q) {
                    $q->where('nama_kategori', 'like', '%Navigasi%');
                })
                ->take(3)
                ->get(),
        ];

        return view('user.dashboard', compact('featuredTents', 'soloGear'));
    }
}
