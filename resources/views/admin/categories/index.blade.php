@extends('layouts.app', ['title' => 'Manajemen Kategori Sarana'])

@section('content')
<div class="box-card p-4 mb-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div>
            <h5 class="fw-bold mb-1">Manajemen Kategori Sarana & Prasarana</h5>
            <p class="text-muted mb-0 small">Kelola klasifikasi sarana sekolah (CRUD: Tambah, Ubah, Hapus Kategori) sesuai poin 6 & 120 UKK Paket 3.</p>
        </div>
        <button type="button" class="btn btn-primary btn-sm px-3 py-2 fw-semibold" data-bs-toggle="modal" data-bs-target="#modalTambahCategory">
            <i class="bi bi-plus-lg me-1"></i> Tambah Kategori Baru
        </button>
    </div>
</div>

<div class="row g-3">
    @foreach($categories as $cat)
        <div class="col-md-6 col-lg-4">
            <div class="box-card p-3 p-xl-4 h-100 d-flex flex-column justify-content-between">
                <div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="badge" style="background-color: #eff6ff; color: #2563eb; font-weight: 600; font-size: 0.75rem;">Kategori #{{ $cat->id }}</span>
                        <span class="text-muted small">{{ $cat->complaints_count }} laporan</span>
                    </div>
                    <h5 class="fw-bold mb-2 text-dark">{{ $cat->name }}</h5>
                    <p class="text-muted small mb-3" style="line-height: 1.5;">{{ $cat->description ?? '-' }}</p>
                </div>
                <div class="d-flex justify-content-end gap-2 pt-2 border-top">
                    <button type="button" class="btn btn-link text-decoration-none text-muted p-0 small fw-semibold" data-bs-toggle="modal" data-bs-target="#modalEditCategory{{ $cat->id }}">
                        <i class="bi bi-pencil me-1"></i> Edit
                    </button>
                    <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus kategori ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-link text-decoration-none text-danger p-0 small fw-semibold ms-2">
                            <i class="bi bi-trash me-1"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Edit -->
        <div class="modal fade" id="modalEditCategory{{ $cat->id }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header border-bottom py-3">
                        <h6 class="modal-title fw-bold">Ubah Kategori Sarana</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('admin.categories.update', $cat->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body p-4">
                            <div class="mb-3">
                                <label class="form-label small fw-semibold">Nama Kategori</label>
                                <input type="text" name="name" class="form-control form-control-sm" value="{{ $cat->name }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-semibold">Deskripsi Cakupan</label>
                                <textarea name="description" rows="3" class="form-control form-control-sm">{{ $cat->description }}</textarea>
                            </div>
                        </div>
                        <div class="modal-footer border-top py-2">
                            <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary btn-sm fw-semibold">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
</div>

<!-- Modal Tambah Kategori -->
<div class="modal fade" id="modalTambahCategory" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom py-3">
                <h6 class="modal-title fw-bold">Tambah Kategori Sarana</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control form-control-sm" placeholder="Contoh: Meja dan Kursi" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Deskripsi Cakupan</label>
                        <textarea name="description" rows="3" class="form-control form-control-sm" placeholder="Keterangan cakupan sarana dalam kategori ini..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-top py-2">
                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm fw-semibold">Simpan Kategori</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection