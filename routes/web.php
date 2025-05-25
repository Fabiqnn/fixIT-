<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FasilitasController;
use App\Http\Controllers\PanduanController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\GedungController;
use App\Http\Controllers\UserManajemenController;
use App\Http\Controllers\PelaporanController;


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
});

Route::get('/pelaporan', [PelaporanController::class, 'index']);


Route::get('/laporan', [StatusController::class, 'index']);


Route::get('/panduan', [PanduanController::class, 'index'])->name('panduan.index');
