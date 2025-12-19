<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ApplyHimaController;
use App\Http\Controllers\AdminHimaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

/**
 * Dashboard default (user login)
 */
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

/**
 * 🔐 ADMIN ROUTES
 */
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return 'Dashboard ADMIN';
    });

    // daftar & approve pengajuan HIMA
    Route::get('/admin/himas', [AdminHimaController::class, 'index'])->name('admin.himas.index');
    Route::post('/admin/himas/{hima}/approve', [AdminHimaController::class, 'approve'])
        ->name('admin.himas.approve');
});

/**
 * 👤 USER ROUTES (login user biasa)
 */
Route::middleware(['auth'])->group(function () {

    // apply jadi HIMA
    Route::get('/apply-hima', [ApplyHimaController::class, 'create'])->name('apply-hima.create');
    Route::post('/apply-hima', [ApplyHimaController::class, 'store'])->name('apply-hima.store');
    Route::get('/apply-hima/status', [ApplyHimaController::class, 'status'])->name('apply-hima.status');

    // dashboard HIMA (setelah di-approve admin)
    Route::middleware('role:hima')->get('/hima/dashboard', function () {
        return 'Dashboard HIMA';
    })->name('hima.dashboard');
});

/**
 * Profile (bawaan Breeze)
 */
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/**
 * Auth routes (login, register, logout)
 * HARUS PALING BAWAH
 */
require __DIR__.'/auth.php';