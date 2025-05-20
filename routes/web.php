<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('landingpage');
});

Route::get('/login', [AuthController::class, 'login']);

Route::prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index']);
    Route::prefix('fasilitas')->group(function () {
        Route::get('/', [AdminController::class, 'fasilitas']);
        Route::get('/create', [AdminController::class, 'tambah_ajax_fasilitas']);
    });
    Route::get('/user', [AdminController::class, 'user']);
    Route::get('/building', [AdminController::class, 'building']);
    Route::get('/userCreateAjax', [AdminController::class, 'createAjax']);
});

Route::get('/pelaporan', function () {
    return view('user.laporankerusakan');
});
