@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="{{ route('petugas.complaints.index') }}" class="btn btn-sm btn-outline-secondary">
                &larr; Kembali ke Antrean
            </a>
            @if (session('success'))
                <div class="alert alert-success m-0 py-1 px-3 fs-7">{{ session('success') }}</div>
            @endif
        </div>

        <div class="row g-4">
            <!-- Kolom Detail Laporan & Riwayat Catatan -->
            <div class="col-lg-8">
                <!-- Card Detail Laporan -->
                <div class="card shadow-sm border-0 p-4 mb-4">
                    <div class="d-flex justify-content-between align-items-start border-b pb-3 mb-3">
                        <div>
                            <small class="text-muted d-block">ID Laporan: #{{ $complaint->id }}</small>
                            <h4 class="fw-bold text-dark mt-1">Fasilitas: {{ $complaint->category->name ?? 'Umum' }}</h4>
                        </div>
                        <span class="badge bg-info fs-7">{{ $complaint->status }}</span>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <small class="text-muted d-block">Siswa Pelapor:</small>
                            <strong class="text-dark">{{ $complaint->user->name ?? 'Siswa' }}</strong>
                        </div>
                        <div class="col-sm-6">
                            <small class="text-muted d-block">Lokasi:</small>
                            <strong class="text-dark">📍 {{ $complaint->location }}</strong>
                        </div>
                    </div>

                    <div class="bg-light p-3 rounded mb-3">
                        <small class="text-muted d-block mb-1">Deskripsi Kerusakan:</small>
                        <p class="text-dark mb-0">{{ $complaint->description }}</p>
                    </div>

                    @if ($complaint->image)
                        <div>
                            <small class="text-muted d-block mb-2">Foto Bukti:</small>
                            <img src="{{ asset('storage/' . $complaint->image) }}"
                                class="img-fluid rounded border max-h-300">
                        </div>
                    @endif
                </div>

                <!-- Card Riwayat Catatan Respon & Tindak Lanjut -->
                <div class="card border-0 shadow-sm rounded-3 mb-4">
                    <div class="card-header bg-white py-3">
                        <h6 class="fw-bold mb-0 text-dark">Riwayat Catatan Respon & Tindak Lanjut</h6>
                    </div>
                    <div class="card-body p-3">
                        @forelse($complaint->feedbacks as $fb)
                            <div class="p-3 mb-2 bg-light rounded border">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="fw-bold text-dark">
                                        {{ $fb->responder->name ?? ($fb->user->name ?? 'Petugas Lapangan') }}
                                    </span>
                                    <small class="text-muted">
                                        {{ $fb->created_at ? $fb->created_at->format('d/m/Y H:i') : '-' }}
                                    </small>
                                </div>
                                {{-- Membaca kolom feedback atau fallback ke notes --}}
                                <p class="mb-1 text-secondary">
                                    {{ $fb->feedback ?? $fb->notes }}
                                </p>
                                <span class="badge bg-success-subtle text-success border border-success-subtle">
                                    Status: {{ $fb->status_change ?? $complaint->status }}
                                </span>
                            </div>
                        @empty
                            <div class="text-center text-muted py-3 small">
                                Belum ada catatan riwayat penanganan untuk aduan ini.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Kolom Form Update Tindakan Petugas -->
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 p-4 bg-white">
                    <h5 class="fw-bold text-dark mb-3">Form Tindakan Petugas</h5>
                    <form action="{{ route('petugas.complaints.update-status', $complaint->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Pilih Status Penanganan</label>
                            <select name="status" class="form-select bg-light">
                                <option value="Menunggu" {{ $complaint->status == 'Menunggu' ? 'selected' : '' }}>Menunggu
                                    (Antrean)</option>
                                <option value="Proses" {{ $complaint->status == 'Proses' ? 'selected' : '' }}>Proses
                                    (Diperbaiki)</option>
                                <option value="Selesai" {{ $complaint->status == 'Selesai' ? 'selected' : '' }}>Selesai
                                    (Sudah Ok)</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Catatan Hasil Perbaikan</label>
                            <textarea name="feedback_notes" rows="4" class="form-control bg-light"
                                placeholder="Masukkan detail tindakan teknis..."></textarea>
                        </div>

                        <button type="submit" class="btn btn-success w-100 fw-bold shadow-sm">Simpan Catatan &
                            Status</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
