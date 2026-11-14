@extends('layouts.app', ['title' => 'Detail Pengaduan #' . $complaint->ticket_code])

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="box-card p-4 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                <div>
                    <small class="text-muted font-monospace">{{ $complaint->ticket_code }}</small>
                    <h5 class="fw-bold mb-0 text-dark">{{ $complaint->title }}</h5>
                </div>
                <a href="{{ route('siswa.complaints.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
            </div>

            <div class="d-flex align-items-center gap-2 mb-3">
                <span class="status-category">{{ $complaint->category->name }}</span>
                <span class="status-pill status-{{ strtolower($complaint->status) }}">{{ $complaint->status }}</span>
            </div>

            <p class="text-muted small mb-1"><i class="bi bi-geo-alt text-danger me-1"></i> Lokasi: <strong>{{ $complaint->location }}</strong></p>
            <p class="text-muted small mb-3"><i class="bi bi-calendar3 me-1"></i> Dilaporkan: {{ $complaint->created_at->format('d M Y, H:i') }} WIB</p>

            <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="small fw-semibold">Progres Penanganan</span>
                    <span class="small fw-bold text-primary">{{ $complaint->progress }}%</span>
                </div>
                <div class="progress" style="height: 8px;">
                    <div class="progress-bar bg-primary" style="width: {{ $complaint->progress }}%;"></div>
                </div>
            </div>

            <h6 class="fw-bold small mb-1">Deskripsi Kerusakan:</h6>
            <p class="p-3 bg-light rounded text-secondary small" style="white-space: pre-line;">{{ $complaint->description }}</p>

            @if($complaint->image)
                <h6 class="fw-bold small mb-1">Foto Bukti Fisik:</h6>
                <img src="{{ asset('storage/' . $complaint->image) }}" class="img-fluid rounded border mb-3" style="max-height: 250px;" alt="Bukti Foto">
            @endif

            <hr>
            <h6 class="fw-bold small mb-2"><i class="bi bi-chat-left-text-fill text-primary me-1"></i> Catatan Tanggapan Petugas Sarpras:</h6>
            @forelse($complaint->feedbacks as $fb)
                <div class="p-3 mb-2 bg-light border rounded small">
                    <div class="d-flex justify-content-between mb-1">
                        <strong class="text-primary">{{ $fb->user->name ?? 'Petugas' }} (Sarpras)</strong>
                        <small class="text-muted">{{ $fb->created_at->diffForHumans() }}</small>
                    </div>
                    <div class="text-secondary">{{ $fb->feedback }}</div>
                </div>
            @empty
                <small class="text-muted d-block">Belum ada umpan balik dari tim teknisi sarpras.</small>
            @endforelse
        </div>
    </div>
</div>
@endsection