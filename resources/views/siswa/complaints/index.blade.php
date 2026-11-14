@extends('layouts.app', ['title' => 'Histori Aspirasi Saya'])

@section('content')
<div class="box-card p-4 mb-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div>
            <h5 class="fw-bold mb-1">Histori Aspirasi Saya</h5>
            <p class="text-muted mb-0 small">Daftar seluruh laporan kerusakan sarana yang telah Anda kirimkan ke pihak sekolah.</p>
        </div>
        <a href="{{ route('siswa.complaints.create') }}" class="btn btn-primary btn-sm px-3 py-2 fw-semibold">
            <i class="bi bi-plus-lg me-1"></i> Kirim Aspirasi Baru
        </a>
    </div>
</div>

<div class="box-card p-3 mb-4">
    <form action="{{ route('siswa.complaints.index') }}" method="GET" class="row g-2 align-items-center">
        <div class="col-md-9">
            <div class="input-group input-group-sm">
                <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search"></i></span>
                <input type="text" name="keyword" value="{{ request('keyword') }}" class="form-control border-start-0 ps-0" placeholder="Cari judul, kategori, atau lokasi...">
            </div>
        </div>
        <div class="col-md-3">
            <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="">Semua Status ({{ $totalCount }})</option>
                <option value="Menunggu" {{ request('status') === 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                <option value="Diproses" {{ request('status') === 'Diproses' ? 'selected' : '' }}>Diproses</option>
                <option value="Diperbaiki" {{ request('status') === 'Diperbaiki' ? 'selected' : '' }}>Diperbaiki</option>
                <option value="Selesai" {{ request('status') === 'Selesai' ? 'selected' : '' }}>Selesai</option>
                <option value="Ditolak" {{ request('status') === 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
            </select>
        </div>
    </form>
</div>

<div class="box-card overflow-hidden">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" style="font-size: 0.84rem;">
            <thead class="table-light">
                <tr class="text-uppercase fw-bold text-muted" style="font-size: 0.72rem;">
                    <th class="py-3 ps-3">No</th>
                    <th>Judul Pengaduan</th>
                    <th>Kategori</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th style="min-width: 180px;">Progres</th>
                    <th class="text-end pe-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($complaints as $index => $c)
                    <tr>
                        <td class="ps-3 text-muted">{{ $complaints->firstItem() + $index }}</td>
                        <td>
                            <div class="fw-semibold text-dark">{{ $c->title }}</div>
                            <small class="text-muted">{{ $c->location }}</small>
                        </td>
                        <td><span class="status-category">{{ $c->category->name }}</span></td>
                        <td class="text-muted">{{ $c->created_at->format('Y-m-d') }}</td>
                        <td><span class="status-pill status-{{ strtolower($c->status) }}">{{ $c->status }}</span></td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <span class="small fw-semibold text-muted" style="width: 30px;">{{ $c->progress }}%</span>
                                <div class="custom-prog-track flex-grow-1">
                                    <div class="custom-prog-bar bg-primary" style="width: {{ $c->progress }}%;"></div>
                                </div>
                            </div>
                        </td>
                        <td class="text-end pe-3">
                            <a href="{{ route('siswa.complaints.show', $c->id) }}" class="btn btn-outline-primary btn-sm py-1 px-2" style="font-size: 0.78rem;">
                                <i class="bi bi-eye me-1"></i> Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted small">Tidak ada data aspirasi ditemukan.</td>
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