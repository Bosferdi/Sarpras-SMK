<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\ComplaintFeedback;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ComplaintController extends Controller
{
    /**
     * Menampilkan daftar aduan sarpras yang perlu ditangani teknisi
     */
    public function index(Request $request)
    {
        // Memuat aduan beserta data pembuat (user) dan kategorinya menggunakan Eager Loading
        $query = Complaint::with(['user', 'category'])->latest();

        // Fitur Filter Status (Menunggu, Proses, Selesai)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Fitur Filter Kategori Fasilitas
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Ambil data dengan paginasi 10 baris per halaman
        $complaints = $query->paginate(10)->withQueryString();
        $categories = Category::all();

        // Hitung statistik untuk indikator kartu dashboard petugas
        $stats = [
            'total'    => Complaint::count(),
            'menunggu' => Complaint::whereIn('status', ['pending', 'Menunggu'])->count(),
            'proses'   => Complaint::whereIn('status', ['in_progress', 'Proses', 'Diproses'])->count(),
            'selesai'  => Complaint::whereIn('status', ['resolved', 'Selesai', 'Diperbaiki'])->count(),
        ];

        return view('petugas.complaints.index', compact('complaints', 'categories', 'stats'));
    }

    /**
     * Menampilkan lembar rincian aduan sarpras
     */
    public function show($id)
    {
        $complaint = Complaint::with(['user', 'category', 'feedbacks.responder'])->findOrFail($id);
        return view('petugas.complaints.show', compact('complaint'));
    }

    /**
     * Memperbarui status pengerjaan sarana dan menyimpan catatan respon teknisi
     */
    public function updateStatus(Request $request, $id)
    {
        // Validasi input form penanganan pengaduan
        $request->validate([
            'status'         => 'required|in:Menunggu,Proses,Selesai,pending,in_progress,resolved,Diproses,Diperbaiki',
            'feedback_notes' => 'required|string|min:5|max:1000',
        ], [
            'status.required'         => 'Status penanganan wajib dipilih.',
            'feedback_notes.required' => 'Catatan teknis hasil pengecekan wajib diisi.',
            'feedback_notes.min'      => 'Catatan teknisi minimal 5 karakter.',
        ]);

        $complaint = Complaint::findOrFail($id);

                // Menggunakan Database Transaction menjamin atomisitas penyimpanan data
        DB::transaction(function () use ($request, $complaint) {
            // 1. Update status pada tabel tiket aduan utama
            $complaint->update([
                'status' => $request->status,
            ]);

            // 2. Simpan respon ke tabel complaint_feedbacks
            ComplaintFeedback::create([
                'complaint_id'  => $complaint->id,
                'user_id'       => Auth::id(),
                'feedback'      => $request->feedback_notes,
            ]);
        });

        return redirect()->route('petugas.complaints.show', $complaint->id)
                         ->with('success', 'Status sarana dan catatan respon berhasil disimpan!');
    }
}
