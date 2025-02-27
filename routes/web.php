<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\ObatCostumerController;
use App\Http\Controllers\ObatResepController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderExportController;
use App\Http\Controllers\ResepController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UserObatResepController;
use App\Http\Controllers\CheckoutResepController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\NotificationController;


Route::middleware(['auth', 'admin'])->group(function (){

});


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/order/{order}/pdf', [OrderExportController::class, 'exportPDF'])->name('order.pdf');
    Route::get('/admin/setting', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/admin/setting/update-profile', [SettingsController::class, 'updateProfile'])->name('settings.updateProfile');
    Route::post('/admin/setting/update-notifications', [SettingsController::class, 'updateNotifications'])->name('settings.updateNotifications');
    Route::post('/admin/setting/update-password', [SettingsController::class, 'updatePassword'])->name('settings.updatePassword');
    // Add this with your other settings routes
    Route::post('/admin/pharmacy/update', [SettingsController::class, 'updatePharmacy'])->name('admin.updatePharmacy');
    // 🔹 Logout (hanya untuk pengguna yang sudah login)
    Route::post('logout', [GoogleController::class, 'logout'])->name('logout');
    Route::get('/user', [DashboardController::class, 'index'])->name('user');
    Route::get('/admin', [DashboardController::class, 'index'])->name('admin');
    Route::get('/admin/laporan', [LaporanController::class, 'index'])->name('admin.laporan');
    Route::resource('/admin/obat', ObatController::class);
    Route::get('/admin/resep', [ResepController::class, 'index'])->name('admin.resep');
    Route::post('/admin/resep', [ResepController::class, 'store'])->name('admin.resep.store');
    Route::get('/admin/resep/{id}/edit', [ResepController::class, 'edit'])->name('admin.resep.edit');
    Route::put('/admin/resep/{id}', [ResepController::class, 'update'])->name('admin.resep.update');
    Route::delete('/admin/resep/{id}', [ResepController::class, 'destroy'])->name('admin.resep.destroy');

    // Original routes
    Route::get('/admin/akun', [UserController::class, 'index'])->name('admin.akun');
    Route::get('/admin/akun/create', [UserController::class, 'create'])->name('admin.akun.create');
    Route::post('/admin/akun', [UserController::class, 'store'])->name('admin.akun.store');

    // New routes for update and delete
    Route::put('/admin/akun/{user}', [UserController::class, 'update'])->name('admin.akun.update');
    Route::delete('/admin/akun/{user}', [UserController::class, 'destroy'])->name('admin.akun.delete');

    // ====================== ADMIN CHAT ======================
    Route::get('/admin/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/admin/chat/{id}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/admin/chat/send', [ChatController::class, 'sendMessage'])->name('chat.send');
    Route::get('/admin/chat/fetch/{id}', [ChatController::class, 'fetchMessages'])->name('chat.fetch');
    // ====================== USER (PELANGGAN) CHAT ======================
    Route::get('/user/chat', [ChatController::class, 'index'])->name('user.chat.index');
    Route::get('/user/chat/{id}', [ChatController::class, 'show'])->name('user.chat.show');
    Route::post('/user/chat/send', [ChatController::class, 'sendMessage'])->name('user.chat.send');
    Route::get('/user/chat/fetch/{id}', [ChatController::class, 'fetchMessages'])->name('user.chat.fetch');


    Route::get('/admin/obat-resep', [ObatResepController::class, 'index'])->name('admin.obat-resep.index');
    Route::get('/admin/obat-resep/fetch', [ObatResepController::class, 'fetch'])->name('admin.obat-resep.fetch');
    Route::post('/admin/obat-resep/verify/{id}', [ObatResepController::class, 'verify'])->name('admin.obat-resep.verify');
    Route::post('/admin/obat-resep/reject/{id}', [ObatResepController::class, 'reject'])->name('admin.obat-resep.reject');
    Route::get('/notifications', [NotificationController::class, 'getNotifications'])->name('notifications.get');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
});

Route::middleware('guest')->group(function () {
    // Menampilkan form lupa password
    Route::get('/forgot-password', function () {
        return view('auth.passwords.forgot-password'); // Buat file ini di resources/views/auth
    })->name('password.request');

    // Mengirim email reset password
    Route::post('/forgot-password', function (Request $request) {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    })->name('password.email');

    // Menampilkan form reset password dengan token
    Route::get('/reset-password/{token}', function ($token) {
        return view('auth.passwords.reset-password', ['token' => $token]); // Buat file ini di resources/views/auth
    })->name('password.reset');

    // Proses reset password
    Route::post('/reset-password', function (Request $request) {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => bcrypt($password),
                ])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    })->name('password.update');
});


// 🔹 Route untuk user yang sudah login
Route::middleware('auth')->group(function () {
    // Menampilkan form ubah password di dashboard
    Route::get('/change-password', function () {
        return view('auth.passwords.change-password');
    })->name('password.change');

    // Proses ubah password dari dashboard
    Route::post('/change-password', function (Request $request) {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama tidak sesuai.']);
        }

        $user->update(['password' => Hash::make($request->password)]);

        return back()->with('status', 'Password berhasil diubah.');
    })->name('password.update.auth');
});

Route::middleware(['auth', 'admin.kasir'])->group(function () {
    Route::get('/admin/pesanan', [OrderController::class, 'index'])->name('admin.orders.index');
    Route::post('/admin/pesanan/{order}/update-status', [OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Pengaturan User
    Route::get('/user/setting', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/user/setting/update-profile', [SettingsController::class, 'updateProfile'])->name('settings.updateProfile');
    Route::post('/user/setting/update-notifications', [SettingsController::class, 'updateNotifications'])->name('settings.updateNotifications');
    Route::post('/user/setting/update-password', [SettingsController::class, 'updatePassword'])->name('settings.updatePassword');

    // Resep
    Route::get('/user/resep', [UserObatResepController::class, 'index'])->name('user.resep.index');
    Route::post('/user/resep/{id}/verifikasi', [UserObatResepController::class, 'verifikasi']);
    Route::get('/user/resep/fetch', [UserObatResepController::class, 'fetch'])->name('user.resep.fetch');
    Route::post('/upload-resep', [ResepController::class, 'upload'])->name('resep.upload');

    // Pesanan Obat
    Route::get('/user/pesanan', [OrderController::class, 'index'])->name('user.orders.obat');
    Route::patch('/user/pesanan/{order}/cancel', [OrderController::class, 'cancelOrder'])->name('user.orders.cancel');

    // Checkout Resep
    Route::get('/checkout/resep/{resep}', [CheckoutResepController::class, 'index'])->name('checkout.resep.index'); // ✅ Fix Nama Route
    Route::get('/checkout/resep/{id}/checkout', [CheckoutResepController::class, 'checkoutPage'])->name('checkout.resep.checkout'); // ✅ URL lebih jelas
    Route::post('/checkout/resep/process', [CheckoutResepController::class, 'process'])->name('checkout.resep.process'); // ✅ Hapus duplikasi
    Route::get('/checkout/resep/{order}/success', [CheckoutResepController::class, 'success'])
        ->name('checkout.success_resep');
});

// 🔹 Autentikasi (register, login, verifikasi email)
Auth::routes(['verify' => true]);

// 🔹 Autentikasi dengan Google
Route::get('login/google', [GoogleController::class, 'login'])->name('google.login');

// 🔹 Halaman Beranda
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/shop', [ObatCostumerController::class, 'index'])->name('obat.pelanggan');
Route::get('/detail/{id}', [ObatCostumerController::class, 'show'])->name('obat.detail');
Route::get('/shop/filter', [ObatCostumerController::class, 'index'])->name('shop.filter');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/cart/count', [CartController::class, 'getCount'])->name('cart.count');
Route::get('/cart/contents', [CartController::class, 'getCartContents']);
Route::post('/cart/checkout', [CartController::class, 'checkout']);
Route::post('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');
Route::get('/cart/check-quantity/{obatId}', [CartController::class, 'checkQuantity']);
Route::get('login/google/callback', [GoogleController::class, 'callback']);
Route::get('/upload-resep', function () {
    return view('pages.upload-resep', ['title' => 'Upload Resep']);
})->name('resep.upload.form');
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');
