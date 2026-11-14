<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComplaintController extends Controller
{
    // 1. Menampilkan Semua Histori Aspirasi Milik Siswa yang Login
    public function index(Request $request)
    {
        $query = Complaint::with('category')->where('user_id', Auth::id());

        if ($request->filled('keyword')) {
            $kw = $request->keyword;
            $query->where(function ($q) use ($kw) {
                $q->where('title', 'like', "%{$kw}%")
                  ->orWhere('location', 'like', "%{$kw}%")
                  ->orWhere('ticket_code', 'like', "%{$kw}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $complaints = $query->latest()->paginate(10)->withQueryString();
        $totalCount = Complaint::where('user_id', Auth::id())->count();

        return view('siswa.complaints.index', compact('complaints', 'totalCount'));
    }

    // 2. Menampilkan Form Buat Pengaduan
    public function create()
    {
        $categories = Category::all();
        return view('siswa.complaints.create', compact('categories'));
    }

    // 3. Menyimpan Data Pengaduan ke Database MySQL dengan Logika Anti-Duplikat
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'location' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('complaints', 'public');
        }

        // FUNGSI UTAMA: Mencari kode tiket terbesar yang ada di database pada tahun berjalan
        $latestTicket = Complaint::whereYear('created_at', date('Y'))
            ->max('ticket_code');

        if ($latestTicket) {
            // Mengambil 3 digit angka terakhir dari string tiket (misal PENG-2026-008 diambil angka 8)
            $lastNumber = (int) substr($latestTicket, -3);
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1; // Jika data di database kosong, mulai dari nomor 001
        }

        // Menyusun kode tiket baru yang dijamin berurutan (misal PENG-2026-009)
        $ticketCode = 'PENG-' . date('Y') . '-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        Complaint::create([
            'ticket_code' => $ticketCode,
            'user_id' => Auth::id(),
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'location' => $validated['location'],
            'description' => $validated['description'],
            'image' => $imagePath,
            'status' => 'Menunggu',
            'progress' => 0,
        ]);

        return redirect()->route('siswa.complaints.index')->with('success', "Aspirasi Anda berhasil dikirim dengan kode tiket {$ticketCode}.");
    }

    // 4. Menampilkan Detail Pengaduan Spesifik
    public function show($id)
    {
        $complaint = Complaint::with(['category', 'user', 'feedbacks.user'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('siswa.complaints.show', compact('complaint'));
    }
}
