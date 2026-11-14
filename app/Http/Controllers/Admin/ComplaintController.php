<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Complaint;
use App\Models\ComplaintFeedback;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ComplaintController extends Controller
{
    public function index(Request $request)
    {
        $query = Complaint::with(['category', 'user']);

        if ($request->filled('keyword')) {
            $kw = $request->keyword;
            $query->where(function ($q) use ($kw) {
                $q->where('title', 'like', "%{$kw}%")
                  ->orWhere('location', 'like', "%{$kw}%")
                  ->orWhere('ticket_code', 'like', "%{$kw}%")
                  ->orWhereHas('user', function ($qu) use ($kw) {
                      $qu->where('name', 'like', "%{$kw}%");
                  });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('month')) {
            $query->whereYear('created_at', substr($request->month, 0, 4))
                  ->whereMonth('created_at', substr($request->month, 5, 2));
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $complaints = $query->latest()->paginate(10)->withQueryString();
        $categories = Category::all();
        $students = User::where('role', 'siswa')->get();

        return view('admin.complaints.index', compact('complaints', 'categories', 'students'));
    }

    public function show($id)
    {
        $complaint = Complaint::with(['category', 'user', 'feedbacks.user'])->findOrFail($id);
        return view('admin.complaints.show', compact('complaint'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Menunggu,Diproses,Diperbaiki,Selesai,Ditolak',
            'progress' => 'required|integer|min:0|max:100',
            'feedback' => 'nullable|string',
        ]);

        $complaint = Complaint::findOrFail($id);
        $complaint->update([
            'status' => $request->status,
            'progress' => $request->progress,
        ]);

        if ($request->filled('feedback')) {
            ComplaintFeedback::create([
                'complaint_id' => $complaint->id,
                'user_id' => Auth::id(),
                'feedback' => $request->feedback,
            ]);
        }

        return back()->with('success', 'Status pengaduan, tingkat progres, dan catatan feedback berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $complaint = Complaint::findOrFail($id);

        if ($complaint->image && Storage::disk('public')->exists($complaint->image)) {
            Storage::disk('public')->delete($complaint->image);
        }

        $complaint->delete();
        return redirect()->route('admin.complaints.index')->with('success', 'Data pengaduan berhasil dihapus permanen.');
    }
}