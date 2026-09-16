<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\KategoriController;
use App\Http\Controllers\API\PengembalianController;
use App\Http\Controllers\API\LogAktivitasController;

// Public Routes (Tidak perlu token)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected Routes (Wajib membawa Bearer Token dari Sanctum)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::middleware('role.admin')->group(function () {
        Route::apiResource('kategori', KategoriController::class);
        
        // Route Pengembalian untuk Admin
        Route::get('/pengembalian', [PengembalianController::class, 'index']);
        Route::get('/pengembalian/{pengembalian}', [PengembalianController::class, 'show']);
        Route::put('/pengembalian/{pengembalian}', [PengembalianController::class, 'update']);
        Route::delete('/pengembalian/{pengembalian}', [PengembalianController::class, 'destroy']);
        
        // Route Log Aktivitas untuk Admin
        Route::get('/log-aktivitas', [LogAktivitasController::class, 'index']);
    });

    Route::middleware('role.petugas')->group(function () {
        // Route untuk hak akses petugas
        Route::post('/pengembalian', [PengembalianController::class, 'store']);
    });

    Route::middleware('role.peminjam')->group(function () {
        // Route untuk hak akses peminjam
    });
});