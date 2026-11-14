@extends('layouts.app', ['title' => 'Dashboard Siswa'])

@section('content')
<!-- Hero Banner Siswa Sesuai Tangkapan Layar -->
<div class="p-4 p-md-5 mb-4 text-white rounded-3" style="background: linear-gradient(135deg, #1e3a8a 0%, #2e3894 50%, #283593 100%);">
    <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-3" style="background: rgba(255, 255, 255, 0.15); font-size: 0.78rem;">
        <i class="bi bi-shield-check"></i> Portal Layanan Sarana & Prasarana Sekolah
    </div>
    <h3 class="fw-bold mb-2">Selamat Datang, {{ auth()->user()->name }}!</h3>
    <p class="mb-4 opacity-75" style="max-width: 820px; font-size: 0.92rem;">
        Laporkan kerusakan sarana belajar, proyektor, meja kursi, atau fasilitas laboratorium di lingkungan sekolah. Laporan Anda langsung diteruskan ke tim Sarpras untuk segera ditindaklanjuti.
    </p>
    <div class="d-flex flex-wrap gap-2">
        <a href="{{ route('siswa.complaints.create') }}" class="btn btn-light fw-semibold text-primary px-3 py-2">
            <i class="bi bi-plus-circle me-1"></i> Sampaikan Pengaduan Baru
        </a>
        <a href="{{ route('siswa.complaints.index') }}" class="btn btn-outline-light fw-semibold px-3 py-2">
            <i class="bi bi-list-task me-1"></i> Lihat Histori Aspirasi ({{ $totalAspirasi }})
        </a>
    </div>
</div>

<!-- 4 Kartu Statistik -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-lg-3">
        <div class="box-card p-3 h-100">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <small class="text-muted fw-semibold">Total Aspirasi</small>
                <i class="bi bi-list-task text-primary fs-5"></i>
            </div>
            <h3 class="fw-bold mb-1">{{ $totalAspirasi }}</h3>
            <small class="text-muted" style="font-size: 0.72rem;">Laporan yang Anda kirim</small>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="box-card p-3 h-100">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <small class="fw-semibold text-warning">Menunggu Respon</small>
                <i class="bi bi-clock text-warning fs-5"></i>
            </div>
            <h3 class="fw-bold mb-1">{{ $menunggu }}</h3>
            <small class="text-muted" style="font-size: 0.72rem;">Antrean verifikasi sarpras</small>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="box-card p-3 h-100">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <small class="fw-semibold text-primary">Sedang Diproses</small>
                <i class="bi bi-arrow-repeat text-primary fs-5"></i>
            </div>
            <h3 class="fw-bold mb-1">{{ $diproses }}</h3>
            <small class="text-muted" style="font-size: 0.72rem;">Pengerjaan & perbaikan aktif</small>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="box-card p-3 h-100">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <small class="fw-semibold text-success">Telah Selesai</small>
                <i class="bi bi-check-circle text-success fs-5"></i>
            </div>
            <h3 class="fw-bold mb-1">{{ $selesai }}</h3>
            <small class="text-muted" style="font-size: 0.72rem;">Fasilitas berhasil diperbaiki</small>
        </div>
    </div>
</div>

<!-- Aspirasi Terkini Saya -->
<div class="box-card p-4 mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
        <div>
            <h6 class="fw-bold mb-0">Aspirasi Terkini Saya</h6>
            <small class="text-muted">Pantau status dan umpan balik admin secara real-time</small>
        </div>
        <a href="{{ route('siswa.complaints.index') }}" class="text-decoration-none small fw-semibold">Lihat Semua &rarr;</a>
    </div>

    @forelse($recentComplaints as $item)
        <div class="p-3 border rounded-3 mb-3 bg-white">
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-2 gap-2">
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <span class="text-muted font-monospace small">{{ $item->ticket_code }}</span>
                    <span class="status-category">{{ $item->category->name }}</span>
                    <span class="text-muted small">&bull; {{ $item->location }}</span>
                </div>
                <div>
                    <span class="status-pill status-{{ strtolower($item->status) }}">{{ $item->status }}</span>
                </div>
            </div>
            <h6 class="fw-bold mb-1"><a href="{{ route('siswa.complaints.show', $item->id) }}" class="text-dark text-decoration-none">{{ $item->title }}</a></h6>
            <p class="text-muted small mb-2 text-truncate" style="max-width: 90%;">{{ $item->description }}</p>
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2" style="max-width: 320px; width: 100%;">
                    <span class="small fw-semibold text-muted" style="width: 35px;">{{ $item->progress }}%</span>
                    <div class="custom-prog-track flex-grow-1">
                        <div class="custom-prog-bar bg-primary" style="width: {{ $item->progress }}%;"></div>
                    </div>
                </div>
                <a href="{{ route('siswa.complaints.show', $item->id) }}" class="text-decoration-none small fw-semibold">Detail &rarr;</a>
            </div>
        </div>
    @empty
        <div class="text-center py-4 text-muted small">Belum ada aspirasi yang Anda kirimkan.</div>
    @endforelse
</div>

<!-- Ketentuan -->
<div class="p-3 rounded-3" style="background-color: #fefce8; border: 1px solid #fef08a; font-size: 0.83rem;">
    <div class="fw-bold text-dark mb-1 d-flex align-items-center gap-2">
        <i class="bi bi-exclamation-triangle text-warning fs-6"></i> Ketentuan Penyampaian Aspirasi Siswa:
    </div>
    <ol class="mb-0 ps-3 text-muted" style="line-height: 1.6;">
        <li>Tuliskan deskripsi kerusakan secara objektif dan sebutkan nomor ruangan atau laboratorium yang jelas.</li>
        <li>Unggah foto kerusakan sarana jika memungkinkan untuk mempercepat analisis teknisi.</li>
        <li>Pengaduan yang telah selesai akan otomatis berstatus Selesai (100%) dan diberi catatan penyelesaian oleh admin.</li>
    </ol>
</div>
@endsection