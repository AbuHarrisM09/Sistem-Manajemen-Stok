<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bahan;

class DashboardController extends Controller
{
    public function index()
    {
        $bahans = Bahan::all();

        $totalBahan = $bahans->count();
        $stokAman = $bahans->filter(fn($b) => $b->status_stok === 'normal')->count();
        $stokMenipis = $bahans->filter(fn($b) => $b->status_stok === 'menipis')->count(); // fixed name
        $stokHabis = $bahans->filter(fn($b) => $b->status_stok === 'habis')->count();

        return view('admin.dashboard', compact(
            'bahans',
            'totalBahan',
            'stokAman',
            'stokMenipis',   // fixed name
            'stokHabis'
        ));
    }
}