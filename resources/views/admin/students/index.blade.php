@extends('layouts.app', ['title' => 'Data Siswa Terdaftar'])

@section('content')
<div class="box-card p-4 mb-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div>
            <h5 class="fw-bold mb-1">Data Siswa Terdaftar</h5>
            <p class="text-muted mb-0 small">Daftar akun siswa yang memiliki hak akses untuk menyampaikan aspirasi dan pengaduan sarana.</p>
        </div>
        <button type="button" class="btn btn-primary btn-sm px-3 py-2 fw-semibold" data-bs-toggle="modal" data-bs-target="#modalTambahSiswa">
            <i class="bi bi-person-plus me-1"></i> Tambah Siswa Baru
        </button>
    </div>
</div>

<div class="box-card p-3 mb-4">
    <form action="{{ route('admin.students.index') }}" method="GET" class="d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div class="input-group input-group-sm" style="max-width: 380px;">
            <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search"></i></span>
            <input type="text" name="keyword" value="{{ request('keyword') }}" class="form-control border-start-0 ps-0" placeholder="Cari nama siswa, NISN, atau kelas...">
        </div>
        <small class="text-muted fw-semibold">Total: {{ $students->count() }} siswa</small>
    </form>
</div>

<div class="box-card overflow-hidden">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" style="font-size: 0.84rem;">
            <thead class="table-light">
                <tr class="text-uppercase fw-bold text-muted" style="font-size: 0.72rem;">
                    <th class="py-3 ps-3">No</th>
                    <th>Nama Lengkap Siswa</th>
                    <th>NISN</th>
                    <th>Kelas</th>
                    <th>Email Akun</th>
                    <th class="text-center">Aspirasi Terkirim</th>
                    <th class="text-end pe-3">Status Akun</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $index => $s)
                    <tr>
                        <td class="ps-3 text-muted">{{ $index + 1 }}</td>
                        <td>
                            <div class="fw-bold text-dark">{{ $s->name }}</div>
                            <small class="text-muted font-monospace" style="font-size: 0.72rem;">ID: usr-siswa-{{ $s->id }}</small>
                        </td>
                        <td class="text-muted font-monospace">{{ $s->nisn ?? '-' }}</td>
                        <td><span class="badge bg-light text-secondary border">{{ $s->kelas ?? '-' }}</span></td>
                        <td class="text-muted font-monospace small">{{ $s->email }}</td>
                        <td class="text-center fw-bold">{{ $s->complaints_count }}</td>
                        <td class="text-end pe-3">
                            <span class="badge" style="background-color: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; font-weight: 500;">
                                <i class="bi bi-check2"></i> Aktif
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah Siswa -->
<div class="modal fade" id="modalTambahSiswa" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom py-3">
                <h6 class="modal-title fw-bold">Tambah Akun Siswa Baru</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.students.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Nama Lengkap Siswa <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control form-control-sm" placeholder="Contoh: Ahmad Fauzi" required>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-semibold">NISN <span class="text-danger">*</span></label>
                            <input type="text" name="nisn" class="form-control form-control-sm" placeholder="0061234567" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold">Kelas <span class="text-danger">*</span></label>
                            <input type="text" name="kelas" class="form-control form-control-sm" placeholder="XII RPL 1" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Alamat Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control form-control-sm" placeholder="siswa@example.com" required>
                    </div>
                </div>
                <div class="modal-footer border-top py-2">
                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm fw-semibold">Simpan Akun Siswa</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
