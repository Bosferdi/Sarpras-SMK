@extends('layouts.app', ['title' => 'Login & Register - Sarpras Care'])

@section('content')
    <style>
        /* Animasi Sentuh & Hover Halus untuk Tombol Akun UKK */
        .btn-account-hover {
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            border: 1px solid #e2e8f0;
        }

        /* Efek saat kursor diarahkan (hover) */
        .btn-account-hover:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 14px rgba(0, 0, 0, 0.08) !important;
            border-color: #93c5fd !important;
            background-color: #ffffff !important;
        }

        /* Efek saat tombol ditekan (click / active) */
        .btn-account-hover:active {
            transform: scale(0.96);
        }
    </style>

    <div class="d-flex align-items-center justify-content-center min-vh-100 py-4"
        style="background: linear-gradient(180deg, #f0f7ff 0%, #f8fafc 100%);">
        <div class="box-card p-4 p-md-5"
            style="max-width: 500px; width: 100%; background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">

            <!-- Logo & Judul Sesuai UKK Paket 3 -->
            <div class="text-center mb-4">
                <div class="mb-2">
                    <img src="{{ asset('img/logo.jpg') }}" alt="Logo Sarpras SMK"
                        style="height: 200px; width: auto; object-fit: contain;">
                </div>
                <h4 class="fw-bold mb-1 text-dark">Aplikasi Pengaduan Sarana Sekolah</h4>
                <p class="text-muted small">Uji Kompetensi Keahlian (UKK) Rekayasa Perangkat Lunak 2025/2026<br>Paket 3</p>
            </div>

            <!-- Kotak Akun Pengujian UKK (1-Klik Isi: Siswa, Petugas, Admin) -->
            <div class="p-3 mb-4 rounded-3 border" style="background-color: #f0f7ff; border-color: #bfdbfe !important;">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="small fw-bold text-dark">Akun Pengujian UKK (1-Klik Isi):</span>
                    <span class="small text-primary">Password: <strong class="font-monospace">password</strong></span>
                </div>
                <div class="row g-2">
                    <!-- 1. Akun Siswa -->
                    <div class="col-4">
                        <button type="button"
                            class="btn btn-white bg-white w-100 p-2 rounded-3 shadow-sm d-flex align-items-center justify-content-center gap-2 btn-account-hover"
                            onclick="fillAccount('siswa@example.com')" title="Klik untuk isi akun Siswa">
                            <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                style="width: 28px; height: 28px; background: #e0f2fe; color: #0284c7;">
                                <i class="bi bi-person"></i>
                            </div>
                            <span class="fw-bold small text-dark">Siswa</span>
                        </button>
                    </div>

                    <!-- 2. Akun Petugas (Teknisi) -->
                    <div class="col-4">
                        <button type="button"
                            class="btn btn-white bg-white w-100 p-2 rounded-3 shadow-sm d-flex align-items-center justify-content-center gap-2 btn-account-hover"
                            onclick="fillAccount('petugas@sarpras.sch.id')" title="Klik untuk isi akun Petugas">
                            <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                style="width: 28px; height: 28px; background: #fef3c7; color: #d97706;">
                                <i class="bi bi-person-gear"></i>
                            </div>
                            <span class="fw-bold small text-dark">Petugas</span>
                        </button>
                    </div>

                    <!-- 3. Akun Admin -->
                    <div class="col-4">
                        <button type="button"
                            class="btn btn-white bg-white w-100 p-2 rounded-3 shadow-sm d-flex align-items-center justify-content-center gap-2 btn-account-hover"
                            onclick="fillAccount('admin@example.com')" title="Klik untuk isi akun Admin">
                            <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                style="width: 28px; height: 28px; background: #e0e7ff; color: #4338ca;">
                                <i class="bi bi-shield-check"></i>
                            </div>
                            <span class="fw-bold small text-dark">Admin</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Tab Navigasi Login & Register -->
            <ul class="nav nav-tabs nav-fill mb-3" id="authTab">
                <li class="nav-item">
                    <button class="nav-link active fw-semibold" id="login-tab" data-bs-toggle="tab"
                        data-bs-target="#tabLogin" type="button">Masuk (Login)</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link fw-semibold" id="register-tab" data-bs-toggle="tab"
                        data-bs-target="#tabRegister" type="button">Daftar Akun Siswa Baru</button>
                </li>
            </ul>

            <div class="tab-content">
                <!-- Form Login -->
                <div class="tab-pane fade show active" id="tabLogin">

                    <!-- Peringatan Error Jika Login Gagal -->
                    @if ($errors->any())
                        <div class="alert alert-danger py-2 px-3 small mb-3 rounded-3 d-flex align-items-center gap-2 shadow-sm"
                            style="background-color: #fef2f2; color: #991b1b; border: 1px solid #fecaca !important;">
                            <i class="bi bi-exclamation-triangle-fill flex-shrink-0 fs-6 text-danger"></i>
                            <div>{{ $errors->first() }}</div>
                        </div>
                    @endif

                    <!-- Peringatan Sukses -->
                    @if (session('success'))
                        <div class="alert alert-success py-2 px-3 small mb-3 rounded-3 d-flex align-items-center gap-2 shadow-sm"
                            style="background-color: #f0fdf4; color: #166534; border: 1px solid #bbf7d0 !important;">
                            <i class="bi bi-check-circle-fill flex-shrink-0 fs-6 text-success"></i>
                            <div>{{ session('success') }}</div>
                        </div>
                    @endif

                    <form action="{{ route('login.post') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Alamat Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white text-muted"><i class="bi bi-envelope"></i></span>
                                <input type="email" name="email" id="loginEmail" class="form-control"
                                    value="siswa@example.com" required>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label small fw-semibold">Kata Sandi</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white text-muted"><i class="bi bi-lock"></i></span>
                                <input type="password" name="password" id="loginPassword" class="form-control"
                                    value="password" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Masuk ke Aplikasi
                        </button>
                    </form>
                </div>

                <!-- Form Registrasi Mandiri Siswa -->
                <div class="tab-pane fade" id="tabRegister">
                    <form action="{{ route('register.post') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Nama Lengkap Siswa</label>
                            <input type="text" name="name" class="form-control" placeholder="misal: Rizky Pratama"
                                required>
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label small fw-semibold">NISN</label>
                                <input type="text" name="nisn" class="form-control" placeholder="0061234567"
                                    required>
                            </div>
                            <div class="col-6">
                                <label class="form-label small fw-semibold">Kelas</label>
                                <select name="kelas" class="form-select" required>
                                    <option value="XII RPL 1">XII RPL 1</option>
                                    <option value="XII RPL 2">XII RPL 2</option>
                                    <option value="XI RPL 1">XI RPL 1</option>
                                    <option value="XI RPL 2">XI RPL 2</option>
                                    <option value="X RPL 1">X RPL 1</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Alamat Email</label>
                            <input type="email" name="email" class="form-control" placeholder="siswa@example.com"
                                required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label small fw-semibold">Kata Sandi</label>
                            <input type="password" name="password" class="form-control" value="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                            <i class="bi bi-person-plus me-1"></i> Daftar Akun Baru
                        </button>
                    </form>
                </div>
            </div>

            <div class="text-center mt-4">
                <small class="text-muted" style="font-size: 0.72rem;">Dilindungi Autentikasi Role Middleware Laravel &
                    Session CSRF Guard</small>
            </div>
        </div>
    </div>

    <script>
        function fillAccount(email) {
            document.getElementById('loginEmail').value = email;
            document.getElementById('loginPassword').value = 'password';
            const triggerEl = document.querySelector('#login-tab');
            bootstrap.Tab.getInstance(triggerEl)?.show() || new bootstrap.Tab(triggerEl).show();
        }
    </script>
@endsection
