<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KategorisController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\ObatCostumerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\ResepController;
use App\Http\Controllers\SettingsController;



Route::middleware(['auth'])->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
});

Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/cart/count', [CartController::class, 'getCount'])->name('cart.count');
Route::get('/cart/contents', [CartController::class, 'getCartContents']);
Route::post('/cart/checkout', [CartController::class, 'checkout']);
Route::post('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');
Route::get('/cart/check-quantity/{obatId}', [CartController::class, 'checkQuantity']);

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/admin/settings/update-profile', [SettingsController::class, 'updateProfile'])->name('settings.updateProfile');
    Route::post('/admin/settings/update-notifications', [SettingsController::class, 'updateNotifications'])->name('settings.updateNotifications');
    Route::post('/admin/settings/update-password', [SettingsController::class, 'updatePassword'])->name('settings.updatePassword');
});



// 🔹 Autentikasi dengan Google
Route::get('login/google', [GoogleController::class, 'login'])->name('google.login');
Route::get('login/google/callback', [GoogleController::class, 'callback']);

// 🔹 Logout (hanya untuk pengguna yang sudah login)
Route::middleware(['auth'])->post('logout', [GoogleController::class, 'logout'])->name('logout');

// 🔹 Halaman Beranda
Route::get('/', [KategorisController::class, 'index'])->name('home');

Route::get('/shop', [ObatCostumerController::class, 'index'])->name('obat.pelanggan');
Route::get('/shop/filter', [ObatCostumerController::class, 'index'])->name('shop.filter');

// 🔹 Autentikasi (register, login, verifikasi email)
Auth::routes(['verify' => true]);

// 🔹 Dashboard hanya untuk pengguna yang telah verifikasi email
Route::middleware(['auth', 'verified'])->get('/user', [DashboardController::class, 'index'])
    ->name('user');

Route::middleware(['auth', 'verified'])->get('/admin', [DashboardController::class, 'index'])
    ->name('admin');


Route::get('/admin/pesanan', function () {
    return view('pages.admin.pesanan', ['title' => 'Pesanan']);
});
Route::get('/admin/laporan', function () {
    return view('pages.admin.laporan', ['title' => 'Laporan & Statistik']);
});
Route::get('/admin/akun', function () {
    return view('pages.admin.akun', ['title' => 'Manage Akun']);
});
Route::get('/admin/setting', function () {
    return view('pages.admin.setting', ['title' => 'Pengaturan']);
});

Route::resource('/admin/obat', App\Http\Controllers\ObatController::class);

Route::get('password/reset', [PasswordResetController::class, 'showResetForm'])->name('password.request');
Route::post('password/email', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [PasswordResetController::class, 'showNewPasswordForm'])->name('password.reset');
Route::post('password/reset', [PasswordResetController::class, 'resetPassword'])->name('password.update');



Route::middleware(['auth'])->group(function () {
    Route::get('/admin/resep', [ResepController::class, 'index'])->name('admin.resep');
    Route::post('/admin/resep', [ResepController::class, 'store'])->name('admin.resep.store');
    Route::get('/admin/resep/{id}/edit', [ResepController::class, 'edit'])->name('admin.resep.edit');
    Route::put('/admin/resep/{id}', [ResepController::class, 'update'])->name('admin.resep.update');
    Route::delete('/admin/resep/{id}', [ResepController::class, 'destroy'])->name('admin.resep.destroy');
});

Route::middleware(['auth'])->group(function () {
    // Original routes
    Route::get('/admin/akun', [UserController::class, 'index'])->name('admin.akun');
    Route::get('/admin/akun/create', [UserController::class, 'create'])->name('admin.akun.create');
    Route::post('/admin/akun', [UserController::class, 'store'])->name('admin.akun.store');

    // New routes for update and delete
    Route::put('/admin/akun/{user}', [UserController::class, 'update'])->name('admin.akun.update');
    Route::delete('/admin/akun/{user}', [UserController::class, 'destroy'])->name('admin.akun.delete');
});


Route::group(['middleware' => 'auth'], function () {
    Route::get('/admin/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/admin/chat/{id}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/admin/chat/send', [ChatController::class, 'sendMessage'])->name('chat.send');
    Route::get('/admin/chat/fetch/{id}', [ChatController::class, 'fetchMessages'])->name('chat.fetch');
});
