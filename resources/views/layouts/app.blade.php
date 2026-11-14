<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Sarpras SMK RPL' }} - UKK Paket 3</title>
    
    <!-- CSS Bootstrap 5.3 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --bs-primary: #1d4ed8;
            --sidebar-width: 260px;
            --bg-page: #f8fafc;
            --card-border: #e2e8f0;
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background-color: var(--bg-page);
            color: #1e293b;
            min-height: 100vh;
            margin: 0;
            overflow-x: hidden;
        }

        /* Struktur Pembagian Sidebar & Konten Utama */
        .app-wrapper {
            display: flex;
            min-height: 100vh;
            width: 100%;
        }

        .app-sidebar {
            width: var(--sidebar-width);
            min-width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1030;
            transition: all 0.25s ease-in-out;
            background-color: #ffffff;
            border-right: 1px solid var(--card-border);
        }

        .app-main {
            flex: 1;
            margin-left: var(--sidebar-width);
            display: flex;
            flex-direction: column;
            min-width: 0;
            transition: all 0.25s ease-in-out;
            width: calc(100% - var(--sidebar-width));
        }

        /* Saat Sidebar Ditutup di Layar Laptop / Komputer */
        body.sidebar-closed .app-sidebar {
            transform: translateX(-100%);
        }
        body.sidebar-closed .app-main {
            margin-left: 0;
            width: 100%;
        }

        /* Logo Brand Kotak */
        .brand-logo-box {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 1.15rem;
        }

        /* Link Navigasi Persis Foto 1 */
        .sidebar-link {
            font-weight: 500;
            font-size: 0.88rem;
            color: #475569;
            padding: 0.6rem 0.85rem;
            border-radius: 8px;
            text-decoration: none;
            display: flex;
            align-items: center;
            transition: all 0.15s ease-in-out;
        }

        .sidebar-link:hover {
            color: #1e293b;
            background-color: #f1f5f9;
        }

        /* Active Item Admin Sesuai Foto 1 (Background Lembut Merah Muda & Teks Merah) */
        .sidebar-link.active-admin {
            background-color: #fef2f2;
            color: #dc2626;
            font-weight: 600;
        }

        .sidebar-link.active-siswa {
            background-color: #eff6ff;
            color: #1d4ed8;
            font-weight: 600;
        }

        .box-card {
            background: #ffffff;
            border: 1px solid var(--card-border);
            border-radius: 14px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
        }

        /* Backdrop Gelap untuk Layar Mobile */
        .sidebar-backdrop {
            display: none;
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(15, 23, 42, 0.4);
            z-index: 1025;
        }

        @media (max-width: 991.98px) {
            .app-sidebar {
                transform: translateX(-100%);
            }
            .app-main {
                margin-left: 0;
                width: 100%;
            }
            body.sidebar-open-mobile .app-sidebar {
                transform: translateX(0);
            }
            body.sidebar-open-mobile .sidebar-backdrop {
                display: block;
            }
        }
    </style>
</head>
<body>

    @auth
        <div class="app-wrapper">
            <!-- Panggil Sidebar Persis Foto 1 -->
            @include('layouts.sidebar')

            <!-- Backdrop Mobile -->
            <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

            <!-- Konten Utama -->
            <div class="app-main">
                <!-- Topbar Navbar dengan Tombol Garis 3 -->
                @include('layouts.navbar')

                <!-- Isi Konten Halaman Blade -->
                <main class="container-fluid px-3 px-xl-4 py-4 flex-grow-1">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @yield('content')
                </main>
            </div>
        </div>
    @else
        @yield('content')
    @endauth

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Logika Toggle Garis 3 Buka-Tutup Sidebar -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const btnToggle = document.getElementById('btnToggleSidebar');
            const backdrop = document.getElementById('sidebarBackdrop');

            if (btnToggle) {
                btnToggle.addEventListener('click', function () {
                    if (window.innerWidth >= 992) {
                        // Desktop: Sembunyikan atau tampilkan sidebar
                        document.body.classList.toggle('sidebar-closed');
                    } else {
                        // Mobile: Buka overlay sidebar
                        document.body.classList.toggle('sidebar-open-mobile');
                    }
                });
            }

            if (backdrop) {
                backdrop.addEventListener('click', function () {
                    document.body.classList.remove('sidebar-open-mobile');
                });
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
