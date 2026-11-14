<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'siswa')->withCount('complaints');

        if ($request->filled('keyword')) {
            $kw = $request->keyword;
            $query->where(function ($q) use ($kw) {
                $q->where('name', 'like', "%{$kw}%")
                  ->orWhere('nisn', 'like', "%{$kw}%")
                  ->orWhere('kelas', 'like', "%{$kw}%");
            });
        }

        $students = $query->latest()->get();
        return view('admin.students.index', compact('students'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nisn' => 'required|string|max:20|unique:users,nisn',
            'kelas' => 'required|string|max:50',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'nullable|min:6',
        ]);

        User::create([
            'name' => $validated['name'],
            'nisn' => $validated['nisn'],
            'kelas' => $validated['kelas'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password'] ?? 'password'),
            'role' => 'siswa',
        ]);

        return redirect()->route('admin.students.index')->with('success', 'Akun siswa berhasil ditambahkan.');
    }
}