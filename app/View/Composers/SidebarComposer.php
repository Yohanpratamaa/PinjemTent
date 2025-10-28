<?php

namespace App\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Kategori;

class SidebarComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        // Only load categories for user role
        if (Auth::check() && Auth::user()->role === 'user') {
            $kategoris = Kategori::select('id', 'nama_kategori')
                ->orderBy('nama_kategori')
                ->get();

            $view->with('sidebarKategoris', $kategoris);
        }
    }
}
