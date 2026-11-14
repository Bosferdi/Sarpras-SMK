<?php

use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ComplaintController as AdminComplaintController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\StudentController as AdminStudentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Petugas\ComplaintController as PetugasComplaintController;
use App\Http\Controllers\Siswa\ComplaintController as SiswaComplaintController;
use App\Http\Controllers\Siswa\DashboardController as SiswaDashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rute Halaman Utama & Autentikasi
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    // Jika user sudah login, langsung arahkan ke dashboard sesuai rolenya
    if (auth()->check()) {
        $role = auth()->user()->role;
        if ($role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($role === 'petugas') {
            return redirect()->route('petugas.dashboard');
        } elseif ($role === 'siswa') {
            return redirect()->route('siswa.dashboard');
        }
    }

    // Jika belum login, tampilkan form login
    return app(AuthController::class)->showLogin();
})->name('login');

// Alias /login
Route::get('/login', function () {
    return redirect()->route('login');
});

// Aksi Login & Register (Bebas dari hambatan middleware guest)
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Grup Pengguna: SISWA
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/dashboard', [SiswaDashboardController::class, 'index'])->name('dashboard');
    Route::get('/pengaduan', [SiswaComplaintController::class, 'index'])->name('complaints.index');
    Route::get('/pengaduan/buat', [SiswaComplaintController::class, 'create'])->name('complaints.create');
    Route::post('/pengaduan', [SiswaComplaintController::class, 'store'])->name('complaints.store');
    Route::get('/pengaduan/{id}', [SiswaComplaintController::class, 'show'])->name('complaints.show');
});

/*
|--------------------------------------------------------------------------
| Grup Pengguna: ADMIN SARPRAS
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/pengaduan', [AdminComplaintController::class, 'index'])->name('complaints.index');
    Route::get('/pengaduan/{id}', [AdminComplaintController::class, 'show'])->name('complaints.show');
    Route::post('/pengaduan/{id}/tindak-lanjut', [AdminComplaintController::class, 'updateStatus'])->name('complaints.update');
    Route::delete('/pengaduan/{id}', [AdminComplaintController::class, 'destroy'])->name('complaints.destroy');

    // CRUD Master Kategori Sarana
    Route::resource('categories', AdminCategoryController::class)->except(['create', 'show', 'edit']);

    // Master Data Siswa
    Route::get('/students', [AdminStudentController::class, 'index'])->name('students.index');
    Route::post('/students', [AdminStudentController::class, 'store'])->name('students.store');
});

/*
|--------------------------------------------------------------------------
| Grup Pengguna: PETUGAS / TEKNISI SARPRAS
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:petugas,admin'])
    ->prefix('petugas')
    ->name('petugas.')
    ->group(function () {
        Route::get('/dashboard', [PetugasComplaintController::class, 'index'])->name('dashboard');
        Route::get('/complaints', [PetugasComplaintController::class, 'index'])->name('complaints.index');
        Route::get('/complaints/{id}', [PetugasComplaintController::class, 'show'])->name('complaints.show');
        Route::post('/complaints/{id}/status', [PetugasComplaintController::class, 'updateStatus'])->name('complaints.update-status');
    });