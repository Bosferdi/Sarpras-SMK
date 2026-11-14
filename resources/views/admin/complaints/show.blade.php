@extends('layouts.app', ['title' => 'Tindak Lanjut Pengaduan'])

@section('content')
<div class="row">
    <div class="col-lg-7">
        <div class="box-card p-4 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                <div>
                    <small class="text-muted font-monospace">{{ $complaint->ticket_code }}</small>
                    <h5 class="fw-bold mb-0 text-dark">{{ $complaint->title }}</h5>
                </div>
                <a href="{{ route('admin.complaints.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
            </div>

            <div class="d-flex align-items-center gap-2 mb-3">
                <span class="status-category">{{ $complaint->category->name }}</span>
                <span class="status-pill status-{{ strtolower($complaint->status) }}">{{ $complaint->status }}</span>
            </div>

            <p class="text-muted small mb-1"><i class="bi bi-person me-1"></i> Pelapor: <strong>{{ $complaint->user->name }} ({{ $complaint->user->kelas }})</strong></p>
            <p class="text-muted small mb-1"><i class="bi bi-geo-alt text-danger me-1"></i> Lokasi: <strong>{{ $complaint->location }}</strong></p>
            <p class="text-muted small mb-3"><i class="bi bi-calendar3 me-1"></i> Tanggal: {{ $complaint->created_at->format('d M Y, H:i') }} WIB</p>

            <h6 class="fw-bold small mb-1">Deskripsi Kerusakan:</h6>
            <p class="p-3 bg-light rounded text-secondary small" style="white-space: pre-line;">{{ $complaint->description }}</p>

            @if($complaint->image)
                <h6 class="fw-bold small mb-1">Foto Bukti Fisik:</h6>
                <img src="{{ asset('storage/' . $complaint->image) }}" class="img-fluid rounded border mb-3" style="max-height: 250px;" alt="Bukti Foto">
            @endif

            <hr>
            <h6 class="fw-bold small mb-2">Riwayat Umpan Balik Petugas:</h6>
            @forelse($complaint->feedbacks as $fb)
                <div class="p-2 mb-2 bg-light border rounded small">
                    <div class="d-flex justify-content-between">
                        <strong class="text-primary">{{ $fb->user->name }}</strong>
                        <small class="text-muted">{{ $fb->created_at->diffForHumans() }}</small>
                    </div>
                    <div class="text-secondary">{{ $fb->feedback }}</div>
                </div>
            @empty
                <small class="text-muted">Belum ada umpan balik yang diberikan.</small>
            @endforelse
        </div>
    </div>

    <!-- Form Tindak Lanjut Admin -->
    <div class="col-lg-5">
        <div class="box-card p-4">
            <h6 class="fw-bold text-primary mb-3"><i class="bi bi-sliders me-1"></i> Perbarui Status & Tanggapan</h6>
            <form action="{{ route('admin.complaints.update', $complaint->id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label small fw-semibold">Status Tindak Lanjut</label>
                    <select name="status" class="form-select form-select-sm" required>
                        @foreach(['Menunggu', 'Diproses', 'Diperbaiki', 'Selesai', 'Ditolak'] as $st)
                            <option value="{{ $st }}" {{ $complaint->status === $st ? 'selected' : '' }}>{{ $st }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold">Tingkat Progres (%)</label>
                    <select name="progress" class="form-select form-select-sm" required>
                        <option value="0" {{ $complaint->progress == 0 ? 'selected' : '' }}>0% (Menunggu)</option>
                        <option value="25" {{ $complaint->progress == 25 ? 'selected' : '' }}>25% (Diverifikasi)</option>
                        <option value="50" {{ $complaint->progress == 50 ? 'selected' : '' }}>50% (Sedang Diperbaiki)</option>
                        <option value="75" {{ $complaint->progress == 75 ? 'selected' : '' }}>75% (Hampir Selesai)</option>
                        <option value="100" {{ $complaint->progress == 100 ? 'selected' : '' }}>100% (Selesai)</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-semibold">Beri Catatan / Umpan Balik</label>
                    <textarea name="feedback" rows="4" class="form-control form-control-sm" placeholder="Tuliskan catatan tindak lanjut untuk siswa..."></textarea>
                </div>

                <button type="submit" class="btn btn-primary btn-sm w-100 fw-semibold">
                    <i class="bi bi-check2-circle me-1"></i> Simpan Pembaruan
                </button>
            </form>
        </div>
    </div>
</div>
@endsection