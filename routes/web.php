<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\admin\FasilitasController;
use App\Http\Controllers\PanduanController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\admin\GedungController;
use App\Http\Controllers\admin\LantaiController;
use App\Http\Controllers\admin\PelaporanController as AdminPelaporanController;
use App\Http\Controllers\admin\PrioritasController;
use App\Http\Controllers\admin\UserManajemenController;
use App\Http\Controllers\PelaporanController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\admin\RuanganController;
use App\Http\Controllers\admin\SPKController;
use App\Http\Controllers\TeknisiController;
use App\Http\Controllers\ProfileController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/profile', [AdminController::class, 'profile'])->name('profile.show');
    Route::get('/profile/{id}/edit', [AdminController::class, 'edit_profile']);
    Route::put('/profile/update_ajax/{id}', [AdminController::class, 'update_profile']);
    Route::prefix('fasilitas')->group(function () {
        Route::get('/', [FasilitasController::class, 'fasilitas']);
        Route::get('/list', [FasilitasController::class, 'list_fasilitas']);
        Route::get('/create', [FasilitasController::class, 'tambah_ajax_fasilitas']);
        Route::post('/store', [FasilitasController::class, 'store_fasilitas']);
        Route::get('/{id}/edit', [FasilitasController::class, 'edit']);
        Route::get('/{id}/show', [FasilitasController::class, 'show']);
        Route::put('/{id}/update', [FasilitasController::class, 'update']);
        Route::get('/{id}/delete_ajax', [FasilitasController::class, 'confirm']);
        Route::delete('/{id}/delete_ajax', [FasilitasController::class, 'delete_ajax']);
        Route::get('/get-lantai/{gedung_id}', [FasilitasController::class, 'getLantai']);
        Route::get('/get-ruangan/{id_lantai}', [FasilitasController::class, 'getRuangan']);
    });
    Route::prefix('user')->group(function () {
        Route::get('/', [UserManajemenController::class, 'user']);
        Route::get('/list', [UserManajemenController::class, 'list_user']);
        Route::get('/create', [UserManajemenController::class, 'tambah_ajax']);
        Route::post('/store', [UserManajemenController::class, 'store']);
        Route::get('/{id}/show', [UserManajemenController::class, 'show']);
        Route::get('/{id}/delete_ajax', [UserManajemenController::class, 'confirm']);
        Route::delete('/{id}/delete_ajax', [UserManajemenController::class, 'delete_ajax']);
        Route::get('/{id}/edit_ajax', [UserManajemenController::class, 'edit_ajax']);
        Route::put('/update_ajax/{id}', [UserManajemenController::class, 'update_ajax']);
    });

    Route::prefix('gedung')->group(function () {
        Route::get('/', [GedungController::class, 'gedung']);
        Route::get('/list', [GedungController::class, 'list_gedung']);
        Route::get('/create', [GedungController::class, 'tambah_ajax_gedung']);
        Route::post('/store', [GedungController::class, 'store']);
        Route::get('/{id}/show', [GedungController::class, 'show']);
        Route::get('/{id}/edit_ajax', [GedungController::class, 'edit_ajax']);
        Route::put('/update_ajax/{id}', [GedungController::class, 'update_ajax']);
        Route::get('/{id}/delete_ajax', [GedungController::class, 'confirm']);
        Route::delete('/delete_ajax/{id}', [GedungController::class, 'delete_ajax']);
    });

    Route::prefix('lantai')->group(function () {
        Route::get('/', [LantaiController::class, 'index']);
        Route::get('/list', [LantaiController::class, 'list']);
        Route::get('/create', [LantaiController::class, 'tambah_ajax']);
        Route::post('/store', [LantaiController::class, 'store']);
        Route::get('/{id}/show', [LantaiController::class, 'show']);
        Route::get('/{id}/edit', [LantaiController::class, 'edit']);
        Route::put('/{id}/update', [LantaiController::class, 'update']);
        Route::get('/{id}/delete_ajax', [LantaiController::class, 'confirm']);
        Route::delete('/{id}/delete_ajax', [LantaiController::class, 'delete_ajax']);
    });

    Route::prefix('ruangan')->group(function () {
        Route::get('/', [RuanganController::class, 'index']);
        Route::get('/list', [RuanganController::class, 'list']);
        Route::get('/create', [RuanganController::class, 'tambah_ajax']);
        Route::post('/store', [RuanganController::class, 'store']);
        Route::get('/{id}/show', [RuanganController::class, 'show']);
        Route::get('/{id}/edit', [RuanganController::class, 'edit']);
        Route::put('/{id}/update', [RuanganController::class, 'update']);
        Route::get('/{id}/delete_ajax', [RuanganController::class, 'confirm']);
        Route::delete('/{id}/delete_ajax', [RuanganController::class, 'delete_ajax']);
        Route::get('/get-lantai/{gedung_id}', [RuanganController::class, 'getLantai']);
    });

    Route::prefix('pelaporan')->group(function () {
        Route::get('/', [AdminPelaporanController::class, 'index']);
        Route::get('/list-pending', [AdminPelaporanController::class, 'list_pending']);
        Route::get('/list-acc', [AdminPelaporanController::class, 'list_acc']);
        Route::get('/list-dec', [AdminPelaporanController::class, 'list_dec']);
        Route::get('/{id}/show', [AdminPelaporanController::class, 'show']);
        Route::get('/{id}/acc', [AdminPelaporanController::class, 'acc']);
        Route::put('/{id}/up_acc', [AdminPelaporanController::class, 'update_acc']);
        Route::get('/{id}/dec', [AdminPelaporanController::class, 'dec']);
        Route::put('/{id}/up_dec', [AdminPelaporanController::class, 'update_dec']);
        // Route::get('/{id}/edit', [AdminPelaporanController::class, 'edit']);
        // Route::put('/{id}/update', [AdminPelaporanController::class, 'update']);
    });

    Route::prefix('prioritas')->group(function () {
        Route::get('/', [PrioritasController::class, 'index']);
        Route::get('/list-kriteria', [PrioritasController::class, 'list_kriteria']);
        Route::get('/list-alternatif', [PrioritasController::class, 'list_alternatif']);
        Route::get('/list-penilaian', [PrioritasController::class, 'list_penilaian']);
        Route::get('/create-alternatif', [PrioritasController::class, 'tambah_alternatif']);
        Route::post('/store-alternatif', [PrioritasController::class, 'store_alternatif']);
        Route::get('/step', [SPKController::class, 'operasiMABAC']);
        Route::get('/get-laporan/{id}', [PrioritasController::class, 'getLaporan']);
        Route::get('/{id}/edit-kriteria', [PrioritasController::class, 'edit_kriteria']);
        Route::put('/{id}/update-kriteria', [PrioritasController::class, 'update_kriteria']);
        Route::get('/{id}/edit-alternatif', [PrioritasController::class, 'edit_alternatif']);
        Route::put('/{id}/update-alternatif', [PrioritasController::class, 'update_alternatif']);
        Route::get('/{id}/delete-alternatif', [PrioritasController::class, 'delete']);
        Route::delete('/{id}/delete-confirm', [PrioritasController::class, 'confirm']);
    });
});

Route::middleware('auth')->group(function () {
    Route::prefix('teknisi')->group(function () {
        Route::get('/', [TeknisiController::class, 'index'])->name('teknisi.dashboard');
        Route::get('/tugasDiproses', [TeknisiController::class, 'sedangDiproses']);
        Route::get('/list_diproses', [TeknisiController::class, 'list_diproses']);
        Route::get('/list_selesai', [TeknisiController::class, 'list_selesai']);
        Route::get('/selesai', [TeknisiController::class, 'selesai']);
        Route::get('/list_diproses/{id}/show', [TeknisiController::class, 'show']);
        Route::get('/laporan/{id}/confirm_tuntas', [TeknisiController::class, 'confirmTuntas']);
        Route::post('/laporan/{id}/selesai', [TeknisiController::class, 'markTuntas']);
    });
});



Route::get('/panduan', [PanduanController::class, 'index'])->name('panduan.index');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [MahasiswaController::class, 'index'])->name('mahasiswa.dashboard');
    Route::get('/laporan', [StatusController::class, 'index']);
    Route::get('/pelaporan', [PelaporanController::class, 'index']);
    Route::get('/ajax/lantai', [PelaporanController::class, 'getLantai']);
    Route::get('/ajax/ruangan', [PelaporanController::class, 'getRuangan']);
    Route::get('/ajax/fasilitas', [PelaporanController::class, 'getFasilitas']);
    Route::post('/pelaporan', [PelaporanController::class, 'store'])->name('laporan.store');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/status/{id}/show', [StatusController::class, 'show'])->name('show.detail');
    Route::get('/profile/edit_ajax/{id}', [ProfileController::class, 'edit_ajax'])->name('profile.edit_ajax');
    Route::put('/profile/update_ajax/{no_induk}', [ProfileController::class, 'update_ajax'])->name('profile.update_ajax');
});
// Route::get('/dosen/dashboard', [DosenController::class, 'index'])->name('dosen.dashboard');

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');


Route::get('/', [AuthController::class, 'landing'])->name('landing');
Route::get('/test-tabelKeputusan', [SPKController::class, 'operasiMABAC']);
