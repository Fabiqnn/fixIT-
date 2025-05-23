<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PanduanController;

Route::get('/', function () {
    return view('landingpage');
});

Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login']);

Route::prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index']);
    Route::prefix('fasilitas')->group(function () {
        Route::get('/', [AdminController::class, 'fasilitas']);
        Route::get('/list', [AdminController::class, 'list_fasilitas']);
        Route::get('/create', [AdminController::class, 'tambah_ajax_fasilitas']);
    });
    Route::prefix('user')->group(function () {
        Route::get('/', [AdminController::class, 'user']);
        Route::get('/list', [AdminController::class, 'list_user']);
    });

    Route::prefix('building')->group(function () {

        Route::get('/', [AdminController::class, 'gedung']);
        Route::get('/list', [AdminController::class, 'list_gedung']);
        Route::get('/create', [AdminController::class, 'tambah_ajax_gedung']);
        Route::post('/store', [AdminController::class, 'store']);
        Route::get('/{id}/edit_ajax', [AdminController::class, 'edit_ajax']);
        Route::put('/update_ajax/{id}', [AdminController::class, 'update_ajax']);
    });
});

Route::get('/pelaporan', function () {
    return view('user.laporankerusakan');
});

Route::get('/panduan', [PanduanController::class, 'index'])->name('guidance.index');
