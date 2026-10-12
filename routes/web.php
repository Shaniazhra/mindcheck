<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SdqController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SuperAdminController;

// Redirect root ke welcome
Route::get('/', function () {
    return view('welcome');
});

// Auth (Guest Only)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'registerForm']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/forgot-password', [AuthController::class, 'forgotForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'forgotSend'])->middleware('throttle:5,1')->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'resetForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetSave'])->name('password.update');
});

// Login Guru BK / Admin (halaman terpisah dari login siswa)
// Sengaja di luar grup "guest": pengecekan role ditangani di AuthController.
Route::get('/login-guru', [AuthController::class, 'loginGuruForm'])->name('login.guru');
Route::post('/login-guru', [AuthController::class, 'loginGuru'])->middleware('throttle:5,1');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Akses Siswa
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/sdq', [SdqController::class, 'index']);
    Route::post('/sdq/submit', [SdqController::class, 'submit']);

    // Jaga-jaga kalau /sdq/submit terbuka lewat GET (refresh, tombol back,
    // atau pemulihan tab). Diarahkan ke halaman hasil, bukan error 405.
    Route::get('/sdq/submit', fn () => redirect('/sdq/hasil'));

    Route::get('/sdq/hasil', [SdqController::class, 'hasil']);
    Route::get('/dashboard-siswa', [DashboardController::class, 'siswa']);
    Route::get('/hasil-skrining', [DashboardController::class, 'hasilSkrining']);
});

// Akses Guru BK / Admin
// Hanya role "admin" (Guru BK) dan "super_admin". Siswa akan mendapat 403.
Route::middleware(['auth', 'role:admin,super_admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/riwayat', [DashboardController::class, 'riwayat']);
    Route::get('/riwayat/{id}', [DashboardController::class, 'detail']);

    // Ubah nomor HP siswa dari halaman detail riwayat
    Route::patch('/riwayat/{id}/no_telp', [DashboardController::class, 'updateNoTelp'])->name('riwayat.no-telp');

    // Route Laporan BK (Fitur 1-to-1)
    Route::get('/riwayat/{id}/laporan', [DashboardController::class, 'laporanForm'])->name('laporan.form');
    Route::post('/riwayat/{id}/laporan', [DashboardController::class, 'laporanSimpan'])->name('laporan.simpan');
    Route::get('/riwayat/{id}/laporan/pdf', [DashboardController::class, 'laporanPdf'])->name('laporan.pdf');

    // Route Edit & Update Laporan BK
    Route::get('/riwayat/{id}/laporan/{laporan_id}/edit', [DashboardController::class, 'laporanEdit'])->name('laporan.edit');
    Route::put('/riwayat/{id}/laporan/{laporan_id}', [DashboardController::class, 'laporanUpdate'])->name('laporan.update');

    // =========================================================
    // DATA PER KELAS
    // =========================================================

    // Daftar semua kelas aktif
    Route::get('/kelas', [DashboardController::class, 'kelasIndex'])
        ->name('kelas.index');

    // Detail siswa dalam satu kelas
    Route::get('/kelas/{kode}', [DashboardController::class, 'kelasDetail'])
        ->name('kelas.detail');

    // Menandai seluruh siswa kelas 9 sebagai lulus
    // Hanya kode kelas 9-x yang diperbolehkan.
    // Data HasilSdq TIDAK dihapus.
    Route::post('/kelas/{kode}/lulus', [SuperAdminController::class, 'kelasLulus'])
        ->where('kode', '9-\d+')
        ->name('kelas.lulus');

    // =========================================================
    // RIWAYAT ANGKATAN
    // =========================================================

    // Daftar angkatan (tahun masuk) siswa yang sudah lulus
    Route::get('/riwayat_angkatan', [DashboardController::class, 'riwayatAngkatan'])
        ->name('riwayat.angkatan.index');

    // Detail siswa lulus berdasarkan angkatan
    Route::get('/riwayat_angkatan/{angkatan}', [DashboardController::class, 'riwayatAngkatanDetail'])
        ->whereNumber('angkatan')
        ->name('riwayat.angkatan.detail');
});

// Akses Super Admin
Route::middleware(['auth', 'role:super_admin'])->prefix('super-admin')->group(function () {
    Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('superadmin.dashboard');

    // Kelola Guru BK
    Route::get('/guru-bk', [SuperAdminController::class, 'guruIndex'])->name('superadmin.guru.index');
    Route::get('/guru-bk/create', [SuperAdminController::class, 'guruCreate'])->name('superadmin.guru.create');
    Route::post('/guru-bk', [SuperAdminController::class, 'guruStore'])->name('superadmin.guru.store');
    Route::get('/guru-bk/{id}/edit', [SuperAdminController::class, 'guruEdit'])->name('superadmin.guru.edit');
    Route::put('/guru-bk/{id}', [SuperAdminController::class, 'guruUpdate'])->name('superadmin.guru.update');
    Route::delete('/guru-bk/{id}', [SuperAdminController::class, 'guruDestroy'])->name('superadmin.guru.destroy');

    // Kelola Data Siswa
    Route::get('/siswa', [SuperAdminController::class, 'siswaIndex'])->name('superadmin.siswa.index');
    Route::get('/siswa/{id}/edit', [SuperAdminController::class, 'siswaEdit'])->name('superadmin.siswa.edit');
    Route::put('/siswa/{id}', [SuperAdminController::class, 'siswaUpdate'])->name('superadmin.siswa.update');
    Route::delete('/siswa/{id}', [SuperAdminController::class, 'siswaDestroy'])->name('superadmin.siswa.destroy');
    Route::post('/siswa/{id}/reset-password', [SuperAdminController::class, 'siswaResetPassword'])->name('superadmin.siswa.reset-password');

    // Kelola Data Kuesioner (hasil SDQ)
    Route::get('/kuesioner', [SuperAdminController::class, 'kuesionerIndex'])->name('superadmin.kuesioner.index');
    Route::get('/kuesioner/{id}', [SuperAdminController::class, 'kuesionerDetail'])->name('superadmin.kuesioner.detail');
    Route::delete('/kuesioner/{id}', [SuperAdminController::class, 'kuesionerDestroy'])->name('superadmin.kuesioner.destroy');

    // >>>>>>>>>> BARU: Pengaturan Tampilan (logo + gambar hero) >>>>>>>>>>
    Route::get('/pengaturan', [SuperAdminController::class, 'pengaturanIndex'])->name('superadmin.pengaturan.index');
    Route::post('/pengaturan', [SuperAdminController::class, 'pengaturanUpdate'])->name('superadmin.pengaturan.update');
});

// =========================================================
// VERIFIKASI EMAIL
// =========================================================

// Tautan yang diklik dari email.
// SENGAJA di luar grup "auth": siswa bisa membukanya dari HP/browser lain
// yang belum login. Keamanan dijaga oleh middleware "signed" dan
// pencocokan hash email di AuthController@verificationVerify.
Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verificationVerify'])
    ->middleware(['signed', 'throttle:6,1'])
    ->name('verification.verify');

// Dicek berkala oleh halaman "Periksa emailmu" untuk tahu apakah tautan sudah dibuka.
// URL-nya bertanda tangan (signed), dibuat langsung di view verify_email.
Route::get('/email/verify-status/{id}', [AuthController::class, 'verificationStatus'])
    ->middleware(['signed', 'throttle:60,1'])
    ->name('verification.status');

// Halaman singkat "Email berhasil diverifikasi" setelah tautan di email dibuka.
Route::get('/email/verified', [AuthController::class, 'verificationDone'])
    ->name('verification.done');

Route::middleware('auth')->group(function () {
    // Halaman "cek emailmu"
    Route::get('/email/verify', [AuthController::class, 'verificationNotice'])
        ->name('verification.notice');

    // Kirim ulang tautan
    Route::post('/email/verification-notification', [AuthController::class, 'verificationSend'])
        ->middleware('throttle:6,1')
        ->name('verification.send');
});