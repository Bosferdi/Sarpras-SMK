<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Complaint;

class DashboardController extends Controller
{
    public function index()
    {
        $totalMasuk = Complaint::count();
        $menunggu = Complaint::where('status', 'Menunggu')->count();
        $diproses = Complaint::where('status', 'Diproses')->count();
        $diperbaiki = Complaint::where('status', 'Diperbaiki')->count();
        $selesai = Complaint::where('status', 'Selesai')->count();
        $ditolak = Complaint::where('status', 'Ditolak')->count();

        $persenSelesai = $totalMasuk > 0 ? round(($selesai / $totalMasuk) * 100) : 0;

        $categoryDistributions = Category::withCount('complaints')
            ->orderByDesc('complaints_count')
            ->get();

        $recentComplaints = Complaint::with(['category', 'user'])
            ->latest()
            ->take(6)
            ->get();

        $totalCategories = Category::count();

        return view('admin.dashboard', compact(
            'totalMasuk', 'menunggu', 'diproses', 'diperbaiki', 
            'selesai', 'ditolak', 'persenSelesai', 
            'categoryDistributions', 'recentComplaints', 'totalCategories'
        ));
    }
}