<aside id="layoutSidebar" class="app-sidebar bg-white border-end d-flex flex-column justify-content-between">
    <div>
        <!-- Brand Header Sidebar -->
        <div class="sidebar-brand-box d-flex align-items-center gap-2 px-3 py-3 border-bottom">
            <div
                class="brand-logo-box flex-shrink-0 
                @if (auth()->user()->role === 'admin') bg-danger 
                @elseif(auth()->user()->role === 'petugas') bg-success 
                @else bg-primary @endif">
                <i class="bi bi-building"></i>
            </div>
            <div class="overflow-hidden">
                <h6 class="fw-bold mb-0 text-dark text-truncate" style="font-size: 0.95rem;">Sarpras SMK RPL</h6>
                <small class="text-muted text-truncate d-block" style="font-size: 0.72rem;">UKK Paket 3 ·
                    2025/2026</small>
            </div>
        </div>

        <!-- Profil Ringkas Pengguna -->
        <div class="p-3 border-bottom bg-light bg-opacity-50">
            <div class="d-flex align-items-center gap-2">
                <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 
                    @if (auth()->user()->role === 'admin') bg-danger bg-opacity-10 text-danger
                    @elseif(auth()->user()->role === 'petugas') bg-success bg-opacity-10 text-success
                    @else bg-primary bg-opacity-10 text-primary @endif"
                    style="width: 38px; height: 38px;">
                    <i
                        class="bi 
                        @if (auth()->user()->role === 'admin') bi-shield-lock-fill
                        @elseif(auth()->user()->role === 'petugas') bi-tools
                        @else bi-mortarboard-fill @endif fs-5"></i>
                </div>
                <div class="overflow-hidden">
                    <!-- Nama User -->
                    <span class="fw-bold text-dark d-block text-truncate"
                        style="font-size: 0.85rem;">{{ auth()->user()->name }}</span>

                    <!-- Badge Role Dinamis -->
                    @if (auth()->user()->role === 'petugas')
                        <span class="badge bg-success text-white px-2 py-1 fw-semibold" style="font-size: 0.72rem;">Role
                            Petugas</span>
                    @elseif(auth()->user()->role === 'admin')
                        <span class="badge bg-danger text-white px-2 py-1 fw-semibold" style="font-size: 0.72rem;">Role
                            Admin</span>
                    @else
                        <span class="badge bg-primary text-white px-2 py-1 fw-semibold" style="font-size: 0.72rem;">Role
                            Siswa</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Menu Navigasi Sidebar Berdasarkan Role -->
        <div class="p-2">
            {{-- 1. MENU UNTUK ADMIN --}}
            @if (auth()->user()->role === 'admin')
                <div class="text-uppercase text-danger px-3 pt-2 pb-1 fw-bold"
                    style="font-size: 0.68rem; letter-spacing: 0.5px;">
                    MENU PENGELOLA SARPRAS
                </div>
                <nav class="nav nav-pills flex-column gap-1">
                    <a href="{{ route('admin.dashboard') }}"
                        class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active-admin' : '' }}">
                        <i class="bi bi-speedometer2 me-2 fs-6"></i> Dashboard
                    </a>
                    <a href="{{ route('admin.complaints.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.complaints.*') ? 'active-admin' : '' }}">
                        <i class="bi bi-inbox-fill me-2 fs-6"></i> Daftar Pengaduan
                    </a>
                    <a href="{{ route('admin.categories.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.categories.*') ? 'active-admin' : '' }}">
                        <i class="bi bi-grid-fill me-2 fs-6"></i> Kategori Sarana
                    </a>
                    <a href="{{ route('admin.students.index') }}"
                        class="sidebar-link {{ request()->routeIs('admin.students.*') ? 'active-admin' : '' }}">
                        <i class="bi bi-people-fill me-2 fs-6"></i> Data Siswa
                    </a>
                </nav>

                {{-- 2. MENU UNTUK PETUGAS / TEKNISI --}}
            @elseif(auth()->user()->role === 'petugas')
                <div class="text-uppercase text-success px-3 pt-2 pb-1 fw-bold"
                    style="font-size: 0.68rem; letter-spacing: 0.5px;">
                    PORTAL KERJA PETUGAS
                </div>
                <nav class="nav nav-pills flex-column gap-1">
                    <a href="{{ route('petugas.complaints.index') }}"
                        class="sidebar-link {{ request()->routeIs('petugas.complaints.*') ? 'active-petugas' : '' }}">
                        <i class="bi bi-wrench-adjustable me-2 fs-6"></i> Antrean Tugas Sarpras
                    </a>
                </nav>

                {{-- 3. MENU UNTUK SISWA --}}
            @else
                <div class="text-uppercase text-primary px-3 pt-2 pb-1 fw-bold"
                    style="font-size: 0.68rem; letter-spacing: 0.5px;">
                    PORTAL LAYANAN SISWA
                </div>
                <nav class="nav nav-pills flex-column gap-1">
                    <a href="{{ route('siswa.dashboard') }}"
                        class="sidebar-link {{ request()->routeIs('siswa.dashboard') ? 'active-siswa' : '' }}">
                        <i class="bi bi-speedometer2 me-2 fs-6"></i> Dashboard
                    </a>
                    <a href="{{ route('siswa.complaints.create') }}"
                        class="sidebar-link {{ request()->routeIs('siswa.complaints.create') ? 'active-siswa' : '' }}">
                        <i class="bi bi-plus-circle-fill me-2 fs-6"></i> Buat Pengaduan
                    </a>
                    <a href="{{ route('siswa.complaints.index') }}"
                        class="sidebar-link {{ request()->routeIs('siswa.complaints.index') ? 'active-siswa' : '' }}">
                        <i class="bi bi-clock-history me-2 fs-6"></i> Histori Aspirasi
                    </a>
                </nav>
            @endif
        </div>
    </div>

    <!-- Tombol Keluar -->
    <div class="p-3 border-top bg-light bg-opacity-25">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                class="btn btn-outline-danger btn-sm w-100 fw-semibold d-flex align-items-center justify-content-center gap-2"
                style="border-radius: 6px;">
                <i class="bi bi-box-arrow-right"></i> Keluar Aplikasi
            </button>
        </form>
    </div>
</aside>
