<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Menangani permintaan masuk (incoming request).
     * Menerima parameter multi-role: role:petugas,admin
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Cek apakah pengguna sudah melakukan login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // 2. Ambil peran dari pengguna yang sedang aktif
        $userRole = Auth::user()->role;

        // 3. Periksa apakah peran pengguna termasuk dalam daftar yang diizinkan
        if (!in_array($userRole, $roles)) {
            // Jika role tidak cocok, lempar HTTP 403 Forbidden
            abort(403, 'Akses ditolak! Anda tidak memiliki izin untuk membuka halaman Petugas.');
        }

        return $next($request);
    }
}
