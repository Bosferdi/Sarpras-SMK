@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Header Halaman -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark">Portal Kerja Teknisi & Petugas</h3>
            <p class="text-muted mb-0">Kelola dan tindak lanjut laporan kerusakan fasilitas sekolah dari siswa.</p>
        </div>
        <div class="badge bg-white text-dark border p-2 shadow-sm fs-6">
            📅 Hari Ini: <strong>{{ date('d M Y') }}</strong>
        </div>
    </div>

    <!-- 📊 KARTU STATISTIK INDIKATOR (Bootstrap Cards) -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card shadow-sm border-0 h-100 p-3">
                <div class="d-flex align-items-center">
                    <div class="fs-2 me-3">📋</div>
                    <div>
                        <small class="text-muted d-block font-medium">Total Aduan</small>
                        <h4 class="fw-bold mb-0 text-dark">{{ $stats['total'] }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card shadow-sm border-0 h-100 p-3">
                <div class="d-flex align-items-center">
                    <div class="fs-2 me-3">⏳</div>
                    <div>
                        <small class="text-muted d-block font-medium">Menunggu (Antrean)</small>
                        <h4 class="fw-bold mb-0 text-warning">{{ $stats['menunggu'] }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card shadow-sm border-0 h-100 p-3">
                <div class="d-flex align-items-center">
                    <div class="fs-2 me-3">🛠️</div>
                    <div>
                        <small class="text-muted d-block font-medium">Sedang Dikerjakan</small>
                        <h4 class="fw-bold mb-0 text-primary">{{ $stats['proses'] }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card shadow-sm border-0 h-100 p-3">
                <div class="d-flex align-items-center">
                    <div class="fs-2 me-3">✅</div>
                    <div>
                        <small class="text-muted d-block font-medium">Selesai Ditangani</small>
                        <h4 class="fw-bold mb-0 text-success">{{ $stats['selesai'] }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 🔍 FILTER DATA -->
    <div class="card shadow-sm border-0 p-3 mb-4">
        <form action="{{ route('petugas.complaints.index') }}" method="GET" class="row g-3">
            <div class="col-md-5">
                <label class="form-label small fw-bold text-secondary">Filter Status</label>
                <select name="status" onchange="this.form.submit()" class="form-select form-select-sm bg-light">
                    <option value="">-- Semua Status --</option>
                    <option value="Menunggu" {{ request('status') == 'Menunggu' ? 'selected' : '' }}>Menunggu (Antrean)</option>
                    <option value="Proses" {{ request('status') == 'Proses' ? 'selected' : '' }}>Proses (Perbaikan)</option>
                    <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai (Solusi)</option>
                </select>
            </div>
            <div class="col-md-5">
                <label class="form-label small fw-bold text-secondary">Filter Kategori</label>
                <select name="category_id" onchange="this.form.submit()" class="form-select form-select-sm bg-light">
                    <option value="">-- Semua Kategori --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <a href="{{ route('petugas.complaints.index') }}" class="btn btn-sm btn-secondary w-full">🔄 Reset</a>
            </div>
        </form>
    </div>

    <!-- 📋 TABEL DATA ANTREAN -->
    <div class="card shadow-sm border-0 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-secondary text-uppercase fs-7">
                    <tr>
                        <th class="py-3 px-4">Pelapor</th>
                        <th class="py-3 px-4">Fasilitas / Kasus</th>
                        <th class="py-3 px-4">Lokasi</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($complaints as $complaint)
                        <tr>
                            <td class="py-3 px-4">
                                <small class="text-muted d-block">#{{ $complaint->id }}</small>
                                <strong class="text-dark">{{ $complaint->user->name ?? 'Siswa' }}</strong>
                            </td>
                            <td class="py-3 px-4">
                                <span class="d-block text-dark fw-bold">{{ $complaint->category->name ?? 'Umum' }}</span>
                                <small class="text-muted">{{ Str::limit($complaint->description, 50) }}</small>
                            </td>
                            <td class="py-3 px-4 text-secondary">📍 {{ $complaint->location }}</td>
                            <td class="py-3 px-4">
                                <span class="badge 
                                    @if(in_array(strtolower($complaint->status), ['pending', 'menunggu'])) bg-warning text-dark
                                    @elseif(in_array(strtolower($complaint->status), ['in_progress', 'proses'])) bg-primary
                                    @else bg-success @endif">
                                    {{ $complaint->status }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-center">
                                <a href="{{ route('petugas.complaints.show', $complaint->id) }}" class="btn btn-sm btn-success fw-bold shadow-sm">
                                    🛠️ Tangani
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">📭 Tidak ada data pengaduan yang masuk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($complaints->hasPages())
            <div class="card-footer bg-light p-3">
                {{ $complaints->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
