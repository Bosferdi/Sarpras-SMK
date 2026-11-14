@extends('layouts.app', ['title' => 'Buat Pengaduan Sarana'])

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="box-card p-4">
            <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                <div>
                    <h5 class="fw-bold mb-1">Form Pengaduan Kerusakan Sarana</h5>
                    <small class="text-muted">Isi formulir secara lengkap agar penanganan dapat dilakukan secara akurat</small>
                </div>
                <a href="{{ route('siswa.dashboard') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i> Batal</a>
            </div>

            <form action="{{ route('siswa.complaints.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold small">Judul Pengaduan <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="Contoh: Saklar Lampu Depan Lab RPL 2 Korslet" required>
                    @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small">Kategori Sarana <span class="text-danger">*</span></label>
                        <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small">Lokasi Spesifik Sarana <span class="text-danger">*</span></label>
                        <input type="text" name="location" class="form-control @error('location') is-invalid @enderror" value="{{ old('location') }}" placeholder="Contoh: Gedung B Lantai 2, Lab RPL 2" required>
                        @error('location') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold small">Deskripsi Kerusakan <span class="text-danger">*</span></label>
                    <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror" placeholder="Jelaskan secara jelas kronologi atau kondisi fisik fasilitas yang rusak..." required>{{ old('description') }}</textarea>
                    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold small">Foto Bukti Fisik Kerusakan (Opsional)</label>
                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                    <small class="text-muted" style="font-size: 0.74rem;">Format yang didukung: JPG, PNG, WEBP (Maksimal 2MB).</small>
                    @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('siswa.dashboard') }}" class="btn btn-secondary btn-sm px-3">Kembali</a>
                    <button type="submit" class="btn btn-primary btn-sm px-4 fw-semibold"><i class="bi bi-send-fill me-1"></i> Kirim Laporan Sekarang</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection