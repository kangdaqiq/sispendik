<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\MataPelajaranController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\KehadiranController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\TahunAjaranController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\ReferralLinkController;
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/pendaftaran', [PendaftaranController::class, 'create'])->name('pendaftaran.create');
Route::post('/pendaftaran', [PendaftaranController::class, 'store'])->name('pendaftaran.store');
Route::get('/pendaftaran/sukses', [PendaftaranController::class, 'sukses'])->name('pendaftaran.sukses');
Route::get('/pendaftaran/referral/{code}', [PendaftaranController::class, 'createWithReferral'])->name('pendaftaran.referral');

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Data Master
    Route::resource('siswa', SiswaController::class);
    Route::resource('guru', GuruController::class);
    Route::resource('kelas', KelasController::class)->parameters(['kelas' => 'kela']);
    Route::resource('jurusan', JurusanController::class);
    Route::resource('mata-pelajaran', MataPelajaranController::class)->parameters(['mata-pelajaran' => 'mataPelajaran']);
    Route::resource('tahun-ajaran', TahunAjaranController::class)->parameters(['tahun-ajaran' => 'tahunAjaran']);

    // Akademik
    Route::get('jadwal/bulk-create', [JadwalController::class, 'bulkCreate'])->name('jadwal.bulk-create');
    Route::post('jadwal/bulk-store', [JadwalController::class, 'bulkStore'])->name('jadwal.bulk-store');
    Route::resource('jadwal', JadwalController::class);

    // Pendaftaran
    Route::get('/admin/pendaftaran', [App\Http\Controllers\AdminPendaftaranController::class, 'index'])->name('admin.pendaftaran.index');
    Route::get('/admin/pendaftaran/{pendaftaran}', [App\Http\Controllers\AdminPendaftaranController::class, 'show'])->name('admin.pendaftaran.show');
    Route::get('/admin/pendaftaran/{pendaftaran}/print', [App\Http\Controllers\AdminPendaftaranController::class, 'print'])->name('admin.pendaftaran.print');
    Route::post('/admin/pendaftaran/{pendaftaran}/terima', [App\Http\Controllers\AdminPendaftaranController::class, 'terima'])->name('admin.pendaftaran.terima');
    Route::post('/admin/pendaftaran/{pendaftaran}/tolak', [App\Http\Controllers\AdminPendaftaranController::class, 'tolak'])->name('admin.pendaftaran.tolak');

    // Referral Link
    Route::get('/admin/referral-link', [ReferralLinkController::class, 'index'])->name('admin.referral-link.index');
    Route::post('/admin/referral-link', [ReferralLinkController::class, 'store'])->name('admin.referral-link.store');
    Route::delete('/admin/referral-link/{referralLink}', [ReferralLinkController::class, 'destroy'])->name('admin.referral-link.destroy');



    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Layanan Data Wilayah
Route::prefix('api/wilayah')->group(function () {
    Route::get('/provinces', [AddressController::class, 'getProvinces']);
    Route::get('/regencies/{provId}', [AddressController::class, 'getRegencies']);
    Route::get('/districts/{cityId}', [AddressController::class, 'getDistricts']);
    Route::get('/villages/{disId}', [AddressController::class, 'getVillages']);
});

require __DIR__ . '/auth.php';
