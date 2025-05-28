<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FasilitasController;
use App\Http\Controllers\PanduanController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\GedungController;
use App\Http\Controllers\LantaiController;
use App\Http\Controllers\UserManajemenController;
use App\Http\Controllers\PelaporanController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\RuanganController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');

Route::post('/login', [AuthController::class, 'login']);

Route::prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index']);
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
});

Route::get('/pelaporan', [PelaporanController::class, 'index']);


Route::get('/laporan', [StatusController::class, 'index']);


Route::get('/panduan', [PanduanController::class, 'index'])->name('panduan.index');

Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
Route::get('/dashboard', [MahasiswaController::class, 'index'])->name('mahasiswa.dashboard');
// Route::get('/dosen/dashboard', [DosenController::class, 'index'])->name('dosen.dashboard');

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');


Route::get('/', [AuthController::class, 'landing'])->name('landing');
