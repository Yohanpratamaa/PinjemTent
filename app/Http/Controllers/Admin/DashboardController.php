<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use App\Models\Peminjaman;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Show the admin dashboard.
     */
    public function index()
    {
        // Summary Cards Data
        $totalUnits = Unit::count();
        $unitsAvailable = Unit::tersedia()->sum('stok');
        $unitsRented = Unit::dipinjam()->sum('stok');

        // Chart Data - Peminjaman per bulan (12 bulan terakhir)
        $monthlyRentals = $this->getMonthlyRentalsData();

        // Chart Data - Kategori paling banyak disewa
        $categoryRentals = $this->getCategoryRentalsData();

        return view('admin.dashboard', compact(
            'totalUnits',
            'unitsAvailable',
            'unitsRented',
            'monthlyRentals',
            'categoryRentals'
        ));
    }

    /**
     * Get monthly rentals data for the last 12 months
     */
    private function getMonthlyRentalsData()
    {
        $data = [];
        $months = [];

        // Get data for last 12 months
        for ($i = 11; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $monthName = $month->format('M Y');
            $months[] = $monthName;

            $count = Peminjaman::whereYear('tanggal_pinjam', $month->year)
                              ->whereMonth('tanggal_pinjam', $month->month)
                              ->count();
            $data[] = $count;
        }

        return [
            'labels' => $months,
            'data' => $data
        ];
    }

    /**
     * Get category rentals data for pie chart
     */
    private function getCategoryRentalsData()
    {
        $categoryData = DB::table('peminjamans')
            ->join('units', 'peminjamans.unit_id', '=', 'units.id')
            ->join('unit_kategori', 'units.id', '=', 'unit_kategori.unit_id')
            ->join('kategoris', 'unit_kategori.kategori_id', '=', 'kategoris.id')
            ->select('kategoris.nama_kategori', DB::raw('COUNT(*) as total'))
            ->groupBy('kategoris.id', 'kategoris.nama_kategori')
            ->orderBy('total', 'desc')
            ->limit(10) // Top 10 categories
            ->get();

        $labels = $categoryData->pluck('nama_kategori')->toArray();
        $data = $categoryData->pluck('total')->toArray();

        // Generate colors for pie chart
        $colors = [
            '#3B82F6', '#EF4444', '#10B981', '#F59E0B', '#8B5CF6',
            '#06B6D4', '#F97316', '#84CC16', '#EC4899', '#6B7280'
        ];

        return [
            'labels' => $labels,
            'data' => $data,
            'colors' => array_slice($colors, 0, count($labels))
        ];
    }
}
