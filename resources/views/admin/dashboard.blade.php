@extends('layouts.app', ['title' => 'Dashboard Manajemen Sarpras'])

@section('content')
<div class="box-card p-4 mb-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div>
            <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-2" style="background: #eff6ff; color: #1d4ed8; font-size: 0.78rem; font-weight: 600;">
                Panel Pengelola Sarpras <span class="text-muted fw-normal">· UKK Paket 3</span>
            </div>
            <h4 class="fw-bold mb-1 text-dark">Dashboard Manajemen Sarana Sekolah</h4>
            <p class="text-muted mb-0 small">Pantau seluruh laporan aspirasi kerusakan sarana, tindak lanjut perbaikan, dan umpan balik siswa.</p>
        </div>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-outline-secondary btn-sm px-3 py-2 fw-semibold" onclick="window.print()">
                <i class="bi bi-printer me-1"></i> Cetak Rekapitulasi
            </button>
            <a href="{{ route('admin.complaints.index') }}" class="btn btn-primary btn-sm px-3 py-2 fw-semibold">
                <i class="bi bi-inbox-fill me-1"></i> Kelola Seluruh Pengaduan
            </a>
        </div>
    </div>
</div>

<!-- 6 Kartu Statistik Admin Sesuai Tangkapan Layar -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-lg-2">
        <div class="box-card p-3 h-100" style="border-left: 3px solid #64748b;">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <small class="fw-semibold text-secondary">Total Masuk</small>
                <i class="bi bi-inbox text-secondary fs-5"></i>
            </div>
            <h3 class="fw-bold mb-1 text-dark">{{ $totalMasuk }}</h3>
            <small class="text-muted" style="font-size: 0.72rem;">Seluruh laporan</small>
        </div>
    </div>
    <div class="col-sm-6 col-lg-2">
        <div class="box-card p-3 h-100" style="border-left: 3px solid #f59e0b;">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <small class="fw-semibold text-warning">Menunggu</small>
                <i class="bi bi-clock text-warning fs-5"></i>
            </div>
            <h3 class="fw-bold mb-1 text-dark">{{ $menunggu }}</h3>
            <small class="text-muted" style="font-size: 0.72rem;">Perlu diverifikasi</small>
        </div>
    </div>
    <div class="col-sm-6 col-lg-2">
        <div class="box-card p-3 h-100" style="border-left: 3px solid #3b82f6;">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <small class="fw-semibold text-primary">Diproses</small>
                <i class="bi bi-arrow-repeat text-primary fs-5"></i>
            </div>
            <h3 class="fw-bold mb-1 text-dark">{{ $diproses }}</h3>
            <small class="text-muted" style="font-size: 0.72rem;">Ditugaskan ke teknisi</small>
        </div>
    </div>
    <div class="col-sm-6 col-lg-2">
        <div class="box-card p-3 h-100" style="border-left: 3px solid #8b5cf6;">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <small class="fw-semibold" style="color: #7c3aed;">Diperbaiki</small>
                <i class="bi bi-wrench fs-5" style="color: #7c3aed;"></i>
            </div>
            <h3 class="fw-bold mb-1 text-dark">{{ $diperbaiki }}</h3>
            <small class="text-muted" style="font-size: 0.72rem;">Pengerjaan fisik</small>
        </div>
    </div>
    <div class="col-sm-6 col-lg-2">
        <div class="box-card p-3 h-100" style="border-left: 3px solid #10b981;">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <small class="fw-semibold text-success">Selesai</small>
                <i class="bi bi-check-circle text-success fs-5"></i>
            </div>
            <h3 class="fw-bold mb-1 text-dark">{{ $selesai }}</h3>
            <small class="text-muted" style="font-size: 0.72rem;">{{ $persenSelesai }}% terselesaikan</small>
        </div>
    </div>
    <div class="col-sm-6 col-lg-2">
        <div class="box-card p-3 h-100" style="border-left: 3px solid #ef4444;">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <small class="fw-semibold text-danger">Ditolak</small>
                <i class="bi bi-x-circle text-danger fs-5"></i>
            </div>
            <h3 class="fw-bold mb-1 text-dark">{{ $ditolak }}</h3>
            <small class="text-muted" style="font-size: 0.72rem;">Di luar wewenang</small>
        </div>
    </div>
</div>

<!-- Distribusi Kategori & Menu Cepat -->
<div class="row g-3 mb-4">
    <div class="col-lg-7">
        <div class="box-card p-4 h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h6 class="fw-bold mb-0">Distribusi Pengaduan per Kategori Sarana</h6>
                    <small class="text-muted">Kategori dengan frekuensi kerusakan tertinggi</small>
                </div>
                <a href="{{ route('admin.categories.index') }}" class="text-decoration-none small fw-semibold">Kelola Kategori &rarr;</a>
            </div>
            @foreach($categoryDistributions as $cat)
                @php
                    $pct = $totalMasuk > 0 ? round(($cat->complaints_count / $totalMasuk) * 100) : 0;
                @endphp
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="small fw-semibold text-dark">{{ $cat->name }}</span>
                        <span class="small text-muted">{{ $cat->complaints_count }} laporan ({{ $pct }}%)</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-primary" style="width: {{ $pct }}%;"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="col-lg-5">
        <div class="box-card p-4 h-100">
            <h6 class="fw-bold mb-3 d-flex align-items-center gap-2"><i class="bi bi-grid text-primary"></i> Menu Cepat Sarpras</h6>
            <div class="d-flex flex-column gap-2">
                <a href="{{ route('admin.complaints.index') }}" class="p-3 border rounded-3 d-flex justify-content-between align-items-center text-decoration-none">
                    <div>
                        <div class="fw-bold text-dark small">Daftar Pengaduan Siswa</div>
                        <small class="text-muted">Filter tanggal, bulan, kategori & status</small>
                    </div>
                    <i class="bi bi-arrow-right text-muted"></i>
                </a>
                <a href="{{ route('admin.categories.index') }}" class="p-3 border rounded-3 d-flex justify-content-between align-items-center text-decoration-none">
                    <div>
                        <div class="fw-bold text-dark small">Manajemen Kategori Sarana</div>
                        <small class="text-muted">{{ $totalCategories }} kategori terdaftar</small>
                    </div>
                    <i class="bi bi-arrow-right text-muted"></i>
                </a>
                <a href="{{ route('admin.students.index') }}" class="p-3 border rounded-3 d-flex justify-content-between align-items-center text-decoration-none">
                    <div>
                        <div class="fw-bold text-dark small">Data Siswa Terdaftar</div>
                        <small class="text-muted">Lihat daftar siswa pelapor</small>
                    </div>
                    <i class="bi bi-arrow-right text-muted"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Tabel Pengaduan Masuk Terbaru -->
<div class="box-card overflow-hidden">
    <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
        <div>
            <h6 class="fw-bold mb-0">Pengaduan Masuk Terbaru</h6>
            <small class="text-muted">Laporan terbaru yang membutuhkan tindakan tim sarpras</small>
        </div>
        <a href="{{ route('admin.complaints.index') }}" class="text-decoration-none small fw-semibold">Buka Tabel Lengkap &rarr;</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" style="font-size: 0.84rem;">
            <thead class="table-light">
                <tr class="text-uppercase fw-bold text-muted" style="font-size: 0.72rem;">
                    <th class="py-3 ps-3">No</th>
                    <th>Siswa Pelapor</th>
                    <th>Judul Pengaduan</th>
                    <th>Kategori</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th style="min-width: 180px;">Progres</th>
                    <th class="text-end pe-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentComplaints as $index => $item)
                    <tr>
                        <td class="ps-3 text-muted">{{ $index + 1 }}</td>
                        <td>
                            <div class="fw-bold text-dark">{{ $item->user->name }}</div>
                            <small class="text-muted">{{ $item->user->kelas }}</small>
                        </td>
                        <td>
                            <div class="fw-semibold text-dark text-truncate" style="max-width: 300px;">{{ $item->title }}</div>
                            <small class="text-muted">{{ $item->location }}</small>
                        </td>
                        <td><span class="status-category">{{ $item->category->name }}</span></td>
                        <td class="text-muted">{{ $item->created_at->format('Y-m-d') }}</td>
                        <td><span class="status-pill status-{{ strtolower($item->status) }}">{{ $item->status }}</span></td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <span class="small fw-semibold text-muted" style="width: 30px;">{{ $item->progress }}%</span>
                                <div class="custom-prog-track flex-grow-1">
                                    <div class="custom-prog-bar bg-primary" style="width: {{ $item->progress }}%;"></div>
                                </div>
                            </div>
                        </td>
                        <td class="text-end pe-3">
                            <a href="{{ route('admin.complaints.show', $item->id) }}" class="btn btn-outline-primary btn-sm py-1 px-2" style="font-size: 0.78rem;">
                                <i class="bi bi-eye me-1"></i> Detail
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection