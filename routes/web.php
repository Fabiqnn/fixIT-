<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FasilitasController;
use App\Http\Controllers\PanduanController;
use App\Http\Controllers\StatusController;


Route::get('/', function () {
    return view('landingpage');
});

Route::get('/login', [AuthController::class, 'showLogin']);
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



Route::get('/laporan', [StatusController::class, 'index']);


Route::get('/panduan', [PanduanController::class, 'index'])->name('panduan.index');

