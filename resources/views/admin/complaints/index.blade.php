@extends('layouts.app', ['title' => 'Daftar Seluruh Pengaduan Siswa'])

@section('content')
<div class="box-card p-3 p-xl-4 mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="fw-semibold text-primary small d-flex align-items-center gap-2">
            <i class="bi bi-funnel"></i> Filter & Pencarian Laporan:
        </div>
        <a href="{{ route('admin.complaints.index') }}" class="btn btn-link btn-sm text-decoration-none text-muted p-0">
            <i class="bi bi-arrow-counterclockwise"></i> Reset Filter
        </a>
    </div>

    <form action="{{ route('admin.complaints.index') }}" method="GET">
        <div class="row g-2 mb-2">
            <div class="col-lg-4 col-md-6">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search"></i></span>
                    <input type="text" name="keyword" value="{{ request('keyword') }}" class="form-control border-start-0 ps-0" placeholder="Cari siswa atau judul...">
                </div>
            </div>
            <div class="col-lg-2 col-md-3 col-6">
                <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    @foreach(['Menunggu', 'Diproses', 'Diperbaiki', 'Selesai', 'Ditolak'] as $st)
                        <option value="{{ $st }}" {{ request('status') === $st ? 'selected' : '' }}>{{ $st }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-2 col-md-3 col-6">
                <select name="category_id" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-2 col-md-6 col-6">
                <select name="user_id" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">Semua Siswa</option>
                    @foreach($students as $st)
                        <option value="{{ $st->id }}" {{ request('user_id') == $st->id ? 'selected' : '' }}>{{ $st->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-2 col-md-6 col-6">
                <select name="month" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">Semua Bulan</option>
                    <option value="2026-09" {{ request('month') === '2026-09' ? 'selected' : '' }}>September 2026</option>
                    <option value="2026-10" {{ request('month') === '2026-10' ? 'selected' : '' }}>Oktober 2026</option>
                </select>
            </div>
        </div>

        <div class="d-flex align-items-center gap-2 pt-2 border-top mt-2">
            <small class="text-muted" style="font-size: 0.78rem;">
                <i class="bi bi-calendar3 me-1"></i> Filter Tanggal Tertentu:
            </small>
            <input type="date" name="date" value="{{ request('date') }}" class="form-control form-control-sm" style="max-width: 170px;" onchange="this.form.submit()">
        </div>
    </form>
</div>

<div class="box-card overflow-hidden">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" style="font-size: 0.84rem;">
            <thead class="table-light">
                <tr class="text-uppercase fw-bold text-muted" style="font-size: 0.72rem;">
                    <th class="py-3 ps-3">No</th>
                    <th>Siswa Pelapor</th>
                    <th>Judul Pengaduan & Lokasi</th>
                    <th>Kategori</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th style="min-width: 180px;">Progres</th>
                    <th class="text-end pe-3">Aksi (Admin)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($complaints as $index => $item)
                    <tr>
                        <!-- 1. Nomor urut -->
                        <td class="ps-3 text-muted">{{ $complaints->firstItem() + $index }}</td>
                        
                        <!-- 2. Nama & Kelas Siswa -->
                        <td>
                            <div class="fw-bold text-dark">{{ $item->user->name }}</div>
                            <small class="text-muted">{{ $item->user->kelas }}</small>
                        </td>

                        <!-- 3. Judul & Lokasi Kerusakan -->
                        <td>
                            <div class="fw-semibold text-dark text-truncate" style="max-width: 320px;">{{ $item->title }}</div>
                            <small class="text-muted"><i class="bi bi-geo-alt text-danger me-1"></i>{{ $item->location }}</small>
                        </td>

                        <!-- 4. Nama Kategori -->
                        <td><span class="status-category">{{ $item->category->name }}</span></td>

                        <!-- 5. Tanggal Laporan -->
                        <td class="text-muted font-monospace small">{{ $item->created_at->format('Y-m-d') }}</td>

                        <!-- 6. Status Penanganan -->
                        <td><span class="status-pill status-{{ strtolower($item->status) }}">{{ $item->status }}</span></td>

                        <!-- 7. Progress Bar Dinamis -->
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <span class="small fw-semibold text-muted" style="width: 30px;">{{ $item->progress }}%</span>
                                <div class="custom-prog-track flex-grow-1">
                                    <div class="custom-prog-bar bg-primary" style="width: {{ $item->progress }}%;"></div>
                                </div>
                            </div>
                        </td>

                        <!-- 8. Kolom Aksi Lengkap 4 Tombol -->
                        <td class="text-end pe-3 text-nowrap">
                            <!-- Detail (Mata - Biru) -->
                            <a href="{{ route('admin.complaints.show', $item->id) }}" class="btn btn-link text-primary p-1" title="Lihat Detail">
                                <i class="bi bi-eye fs-5"></i>
                            </a>

                            <!-- Edit Status (Pensil - Ungu) -->
                            <a href="{{ route('admin.complaints.show', $item->id) }}" class="btn btn-link p-1" style="color: #6f42c1;" title="Ubah Status & Progres">
                                <i class="bi bi-pencil fs-5"></i>
                            </a>

                            <!-- Beri Tanggapan/Feedback (Gelembung - Hijau) -->
                            <a href="{{ route('admin.complaints.show', $item->id) }}" class="btn btn-link text-success p-1" title="Beri Catatan Tanggapan">
                                <i class="bi bi-chat-left text-success fs-5"></i>
                            </a>

                            <!-- Hapus (Tong Sampah - Merah) -->
                            <form action="{{ route('admin.complaints.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data laporan pengaduan ini secara permanen?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-link text-danger p-1" title="Hapus Permanen">
                                    <i class="bi bi-trash fs-5"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">Tidak ditemukan data pengaduan yang sesuai.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-3 border-top">
        {{ $complaints->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
