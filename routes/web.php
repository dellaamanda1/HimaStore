<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ApplyHimaController;
use App\Http\Controllers\AdminHimaController;
use App\Http\Controllers\HimaProductController;
use App\Http\Controllers\ProductCatalogController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PaymentController;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard default
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// =======================
// ADMIN ROUTES
// =======================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return 'Dashboard ADMIN';
    })->name('dashboard');

    Route::get('/himas', [AdminHimaController::class, 'index'])->name('himas.index');

    // verifikasi pembayaran subscription (simulator) -> verified
    Route::post('/himas/{hima}/verify-payment', [AdminHimaController::class, 'verifyPayment'])
        ->name('himas.verifyPayment');

    // approve -> is_active true + role user jadi hima
    Route::post('/himas/{hima}/approve', [AdminHimaController::class, 'approve'])->name('himas.approve');
});

// =======================
// USER ROUTES (APPLY HIMA)
// =======================
Route::middleware(['auth'])->group(function () {
    Route::get('/apply-hima', [ApplyHimaController::class, 'create'])->name('apply-hima.create');
    Route::post('/apply-hima', [ApplyHimaController::class, 'store'])->name('apply-hima.store');
    Route::get('/apply-hima/status', [ApplyHimaController::class, 'status'])->name('apply-hima.status');

    // tombol subscription (upgrade) -> ke QRIS
    Route::post('/apply-hima/subscription/start', [ApplyHimaController::class, 'startSubscription'])
        ->name('apply-hima.subscription.start');

    // halaman QRIS
    Route::get('/apply-hima/subscription/{hima}', [ApplyHimaController::class, 'subscriptionPage'])
        ->name('apply-hima.subscription.page');

    // tombol "Saya sudah bayar" -> pending
    Route::post('/apply-hima/subscription/{hima}/confirm', [ApplyHimaController::class, 'subscriptionConfirm'])
        ->name('apply-hima.subscription.confirm');
});

// =======================
// HIMA ROUTES (JUALAN)
// =======================
Route::middleware(['auth', 'role:hima'])->prefix('hima')->name('hima.')->group(function () {
    Route::get('/dashboard', [HimaProductController::class, 'index'])->name('dashboard');

    Route::get('/products', [HimaProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [HimaProductController::class, 'create'])->name('products.create');
    Route::post('/products', [HimaProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [HimaProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [HimaProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [HimaProductController::class, 'destroy'])->name('products.destroy');
});

// =======================
// PRODUK KATALOG (PEMBELI)
// =======================
Route::get('/products', [ProductCatalogController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductCatalogController::class, 'show'])->name('products.show');

// =======================
// CHECKOUT & PAYMENT (LOGIN)
// =======================
Route::middleware(['auth'])->group(function () {
    Route::get('/checkout/{product}', [CheckoutController::class, 'create'])->name('checkout.create');
    Route::post('/checkout/{product}', [CheckoutController::class, 'store'])->name('checkout.store');

    Route::get('/payments/pay/{order}', [PaymentController::class, 'pay'])->name('payments.pay');
});

// webhook midtrans (NO AUTH)
Route::post('/payments/midtrans/notification', [PaymentController::class, 'notification'])->name('payments.notification');

// =======================
// PROFILE (BREEZE)
// =======================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

use App\Http\Controllers\ShopController;

Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::get('/products/{product}', [ShopController::class, 'show'])->name('products.show');

Route::get('/shop', [ShopController::class, 'index'])
    ->middleware('auth')
    ->name('shop');

Route::get('/products/{product}', [ShopController::class, 'show'])
    ->middleware('auth')
    ->name('products.show');

    
require __DIR__.'/auth.php';
