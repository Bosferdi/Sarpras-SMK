<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $totalAspirasi = Complaint::where('user_id', $userId)->count();
        $menunggu = Complaint::where('user_id', $userId)->where('status', 'Menunggu')->count();
        $diproses = Complaint::where('user_id', $userId)->whereIn('status', ['Diproses', 'Diperbaiki'])->count();
        $selesai = Complaint::where('user_id', $userId)->where('status', 'Selesai')->count();

        $recentComplaints = Complaint::with('category')
            ->where('user_id', $userId)
            ->latest()
            ->take(5)
            ->get();

        return view('siswa.dashboard', compact(
            'totalAspirasi',
            'menunggu',
            'diproses',
            'selesai',
            'recentComplaints'
        ));
    }
}