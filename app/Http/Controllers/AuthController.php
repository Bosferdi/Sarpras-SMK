<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * 1. Menampilkan Halaman Form Login
     * Fungsi: Membuka berkas tampilan view login yang berada di folder resources/views/auth/login.blade.php
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * 2. Memproses Aksi Login Pengguna
     * Fungsi: Melakukan validasi input, memeriksa kecocokan akun di database,
     *         dan mengarahkan pengguna ke dashboard yang sesuai dengan perannya (Role-Based Redirect).
     */
    public function login(Request $request)
    {
        // A. Validasi inputan form login dari pengguna
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // B. Melakukan percobaan autentikasi (mencocokkan email & password ke database)
        if (Auth::attempt($credentials)) {
            // Mengamankan sesi (session) untuk menghindari serangan session fixation
            $request->session()->regenerate();

            // C. LOGIKA MULTI-ROLE REDIRECT (Langsung ke dashboard masing-masing)
            $user = Auth::user();

            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role === 'petugas') {
                return redirect()->route('petugas.dashboard');
            }

            // Jalur default: dashboard siswa
            return redirect()->route('siswa.dashboard');
        } // <--- KURUNG TUTUP INI YANG SEBELUMNYA HILANG

        // D. Jika proses login gagal (email atau password salah)
        return back()->withErrors([
            'email' => 'Email atau kata sandi tidak cocok dengan data terdaftar.',
        ])->onlyInput('email');
    }

    /**
     * 3. Memproses Aksi Registrasi Akun Siswa Baru
     * Fungsi: Menerima data input pendaftaran siswa, menyimpannya ke database dengan role default 'siswa',
     *         lalu otomatis melakukan login dan mengarahkannya ke portal dashboard siswa.
     */
    public function register(Request $request)
    {
        // A. Validasi aturan input data form registrasi siswa
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'nisn'     => 'required|string|max:20|unique:users,nisn',
            'kelas'    => 'required|string|max:50',
            'email'    => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:6',
        ]);

        // B. Membuat baris data pengguna baru di dalam tabel database 'users'
        $user = User::create([
            'name'     => $validated['name'],
            'nisn'     => $validated['nisn'],
            'kelas'    => $validated['kelas'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']), // Mengamankan sandi menggunakan Bcrypt
            'role'     => 'siswa', // Hak akses dikunci otomatis sebagai siswa
        ]);

        // C. Otomatis login menggunakan akun yang baru saja dibuat
        Auth::login($user);
        
        return redirect()->route('siswa.dashboard')
            ->with('success', 'Akun berhasil terdaftar dan Anda telah login.');
    }

    /**
     * 4. Memproses Aksi Keluar Sistem (Logout)
     * Fungsi: Menghapus sesi aktif pengguna, membatalkan token keamanan csrf saat ini,
     *         dan melempar balik pengguna ke halaman login luar.
     */
    public function logout(Request $request)
    {
        Auth::logout(); // Mengeluarkan status login auth
        
        $request->session()->invalidate(); // Menghapus data session tersimpan
        $request->session()->regenerateToken(); // Mengubah ulang token CSRF agar tidak bisa dibajak

        return redirect()->route('login');
    }
}