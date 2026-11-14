<header class="main-header py-2 px-3 px-xl-4 bg-white border-bottom sticky-top">
    <div class="d-flex justify-content-between align-items-center">
        <!-- Sisi Kiri: Tombol Garis 3 + Badge Role Dinamis -->
        <div class="d-flex align-items-center gap-2 gap-md-3">
            <!-- Tombol Garis 3 (Buka/Tutup Sidebar) -->
            <button class="btn btn-sm btn-light border" type="button" id="btnToggleSidebar" title="Buka/Tutup Sidebar">
                <i class="bi bi-list fs-5"></i>
            </button>

            <!-- Lencana Role Dinamis -->
            @if(auth()->user()->role === 'petugas')
                <span class="badge bg-success text-white px-3 py-2 fw-semibold shadow-sm" style="font-size: 0.82rem; border-radius: 6px;">
                    Role Petugas
                </span>
            @elseif(auth()->user()->role === 'admin')
                <span class="badge bg-danger text-white px-3 py-2 fw-semibold shadow-sm" style="font-size: 0.82rem; border-radius: 6px;">
                    Admin
                </span>
            @else
                <span class="badge bg-primary text-white px-3 py-2 fw-semibold shadow-sm" style="font-size: 0.82rem; border-radius: 6px;">
                    Role Siswa
                </span>
            @endif
        </div>

        <!-- Sisi Kanan: Aksi & Profil Akun Dinamis -->
        <div class="d-flex align-items-center gap-2">
            {{-- 1. Tombol Cetak Laporan (HANYA MUNCUL UNTUK ADMIN) --}}
            @if(auth()->user()->role === 'admin')
                <button type="button" class="btn btn-sm btn-outline-danger fw-semibold d-none d-sm-inline-flex align-items-center gap-1" onclick="window.print()">
                    <i class="bi bi-printer"></i> Cetak Laporan
                </button>
            @endif

            {{-- 2. Tombol Lapor Kerusakan (HANYA MUNCUL UNTUK SISWA) --}}
            @if(auth()->user()->role === 'siswa')
                <a href="{{ route('siswa.complaints.create') }}" class="btn btn-primary btn-sm rounded-pill px-3 fw-semibold">
                    <i class="bi bi-plus-lg me-1"></i> Lapor Kerusakan
                </a>
            @endif

            <!-- Dropdown Profil -->
            <div class="dropdown ms-1">
                <button class="btn btn-sm btn-light border dropdown-toggle d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown">
                    <div class="rounded-circle d-flex align-items-center justify-content-center 
                        @if(auth()->user()->role === 'admin') bg-danger bg-opacity-10 text-danger
                        @elseif(auth()->user()->role === 'petugas') bg-success bg-opacity-10 text-success
                        @else bg-primary bg-opacity-10 text-primary @endif" 
                        style="width: 26px; height: 26px;">
                        <i class="bi 
                            @if(auth()->user()->role === 'admin') bi-shield-check
                            @elseif(auth()->user()->role === 'petugas') bi-tools
                            @else bi-person @endif"></i>
                    </div>
                    <span class="small fw-semibold d-none d-sm-inline">{{ auth()->user()->name }}</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 py-2" style="font-size: 0.85rem;">
                    <li class="px-3 py-1 small">
                        Role: 
                        @if(auth()->user()->role === 'admin')
                            <strong class="text-danger">Admin</strong>
                        @elseif(auth()->user()->role === 'petugas')
                            <strong class="text-success">Petugas</strong>
                        @else
                            <strong class="text-primary">Role Siswa</strong>
                        @endif
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger d-flex align-items-center gap-2">
                                <i class="bi bi-box-arrow-right"></i> Keluar (Logout)
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>
