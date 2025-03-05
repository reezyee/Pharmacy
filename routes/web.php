<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CheckoutResepController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\ObatCostumerController;
use App\Http\Controllers\ObatResepController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderExportController;
use App\Http\Controllers\ResepController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserObatResepController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;

// 🔹 Autentikasi (register, login, verifikasi email)
Auth::routes(['verify' => true]);

// 🔹 Autentikasi dengan Google
Route::get('login/google', [GoogleController::class, 'login'])->name('google.login');
Route::get('login/google/callback', [GoogleController::class, 'callback']);

// 🔹 Halaman Beranda
Route::get('/', [HomeController::class, 'index'])->name('home');

// 🔹 Shop & Obat
Route::prefix('shop')->group(function () {
    Route::get('/', [ObatCostumerController::class, 'index'])->name('obat.pelanggan');
    Route::get('/filter', [ObatCostumerController::class, 'index'])->name('shop.filter');
});

Route::get('/detail/{id}', [ObatCostumerController::class, 'show'])->name('obat.detail');

// 🔹 Shopping Cart
Route::prefix('cart')->group(function () {
    Route::post('/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/update', [CartController::class, 'update'])->name('cart.update');
    Route::post('/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::get('/count', [CartController::class, 'getCount'])->name('cart.count');
    Route::get('/contents', [CartController::class, 'getCartContents'])->name('cart.contents');
    Route::post('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::post('/clear', [CartController::class, 'clearCart'])->name('cart.clear');
    Route::get('/check-quantity/{obatId}', [CartController::class, 'checkQuantity'])->name('cart.checkQuantity');
});

// 🔹 Contact
Route::prefix('contact')->group(function () {
    Route::get('/', [ContactController::class, 'index'])->name('contact.index');
    Route::post('/send', [ContactController::class, 'send'])->name('contact.send');
});

// ====================== GUEST ROUTES ======================
Route::middleware('guest')->group(function () {
    // 🔹 Password Reset
    Route::get('/forgot-password', function () {
        return view('auth.passwords.forgot-password');
    })->name('password.request');

    Route::post('/forgot-password', function (Request $request) {
        $request->validate(['email' => 'required|email']);
        $status = Password::sendResetLink($request->only('email'));
        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    })->name('password.email');

    Route::get('/reset-password/{token}', function ($token) {
        return view('auth.passwords.reset-password', ['token' => $token]);
    })->name('password.reset');

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
                    'password' => Hash::make($password),
                ])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    })->name('password.update');
});

// ====================== AUTHENTICATED ROUTES ======================
Route::middleware(['auth', 'verified'])->group(function () {
    // 🔹 Notifications (untuk semua user)
    Route::prefix('notifications')->group(function () {
        Route::get('/', [NotificationController::class, 'getNotifications'])->name('notifications.get');
        Route::post('/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    });

    // 🔹 Logout (untuk semua user)
    Route::post('/logout', [GoogleController::class, 'logout'])->name('logout');

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

// ====================== CUSTOMER ROUTES ======================
Route::middleware(['auth', 'pelanggan'])->group(function () {
    // 🔹 Dashboard
    Route::get('/user', [DashboardController::class, 'index'])->name('user.dashboard');

    // 🔹 User Settings
    Route::prefix('user/setting')->group(function () {
        Route::get('/', [SettingsController::class, 'index'])->name('user.settings.index');
        Route::post('/update-profile', [SettingsController::class, 'updateProfile'])->name('user.settings.updateProfile');
        Route::post('/update-notifications', [SettingsController::class, 'updateNotifications'])->name('user.settings.updateNotifications');
        Route::post('/update-password', [SettingsController::class, 'updatePassword'])->name('user.settings.updatePassword');
    });

    // 🔹 Resep Management
    Route::prefix('user/resep')->group(function () {
        Route::get('/', [UserObatResepController::class, 'index'])->name('user.resep.index');
        Route::post('/{id}/verifikasi', [UserObatResepController::class, 'verifikasi'])->name('user.resep.verifikasi');
        Route::get('/fetch', [UserObatResepController::class, 'fetch'])->name('user.resep.fetch');
    });
    // Route to display the form
    Route::get('/upload-resep', [ResepController::class, 'showUploadForm'])->name('resep.form');

    // Route to process the form submission
    Route::post('/upload-resep', [ResepController::class, 'upload'])->name('resep.upload');

    // 🔹 Order Management
    Route::prefix('user/pesanan')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('user.orders.index');
        Route::patch('/{order}/cancel', [OrderController::class, 'cancelOrder'])->name('user.orders.cancel');
        Route::post('/{order}/upload-proof', [OrderController::class, 'uploadPaymentProof'])->name('user.orders.uploadProof');
    });    

    // 🔹 Checkout (Non-Resep)
    Route::prefix('checkout')->group(function () {
        Route::get('/', [CheckoutController::class, 'index'])->name('checkout.index');
        Route::post('/process', [CheckoutController::class, 'process'])->name('checkout.process');
        Route::get('/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');
    });

    // 🔹 Checkout (Resep)
    Route::prefix('checkout/resep')->group(function () {
        Route::get('/{resep}', [CheckoutResepController::class, 'index'])->name('checkout.resep.index');
        Route::get('/{id}/checkout', [CheckoutResepController::class, 'checkoutPage'])->name('checkout.resep.checkout');
        Route::post('/process', [CheckoutResepController::class, 'process'])->name('checkout.resep.process');
    });
    Route::get('checkout/success_resep/{order}', [CheckoutResepController::class, 'success'])->name('checkout.resep.success');

    // 🔹 Order Export
    Route::get('/order/{order}/pdf', [OrderExportController::class, 'exportPDF'])->name('order.pdf');

    // 🔹 Customer Chat
    Route::prefix('user/chat')->group(function () {
        Route::get('/', [ChatController::class, 'index'])->name('user.chat.index');
        Route::get('/{id}', [ChatController::class, 'show'])->name('user.chat.show');
        Route::post('/send', [ChatController::class, 'sendMessage'])->name('user.chat.send');
        Route::get('/fetch/{id}', [ChatController::class, 'fetchMessages'])->name('user.chat.fetch');
    });
});

// ====================== ADMIN/STAFF COMMON ROUTES ======================
Route::middleware(['auth', 'non.pelanggan'])->group(function () {
    // 🔹 Admin Dashboard
    Route::get('/admin', [DashboardController::class, 'index'])->name('admin.dashboard');

    // 🔹 Admin Settings
    Route::prefix('admin/setting')->group(function () {
        Route::get('/', [SettingsController::class, 'index'])->name('admin.settings.index');
        Route::post('/update-profile', [SettingsController::class, 'updateProfile'])->name('admin.settings.updateProfile');
        Route::post('/update-notifications', [SettingsController::class, 'updateNotifications'])->name('admin.settings.updateNotifications');
        Route::post('/update-password', [SettingsController::class, 'updatePassword'])->name('admin.settings.updatePassword');
    });
});

// ====================== ADMINISTRATOR ROUTES ======================
Route::middleware(['auth', 'admin'])->group(function () {
    // 🔹 Pharmacy Settings
    Route::post('/admin/pharmacy/update', [SettingsController::class, 'updatePharmacy'])->name('admin.updatePharmacy');

    // 🔹 Reports
    Route::prefix('admin/laporan')->group(function () {
    Route::get('/', [LaporanController::class, 'index'])->name('admin.laporan.index');
    });
    // 🔹 User Management
    Route::prefix('admin/akun')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('admin.akun.index');
        Route::get('/create', [UserController::class, 'create'])->name('admin.akun.create');
        Route::post('/', [UserController::class, 'store'])->name('admin.akun.store');
        Route::put('/{user}', [UserController::class, 'update'])->name('admin.akun.update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('admin.akun.destroy');
    });
});

// ====================== CASHIER/ADMIN ROUTES ======================
Route::middleware(['auth', 'admin.kasir'])->group(function () {
    // 🔹 Order Management
    Route::prefix('admin/pesanan')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('admin.orders.index');
        Route::post('{order}/update-status', [OrderController::class, 'updateStatus'])
            ->name('admin.orders.updateStatus');
    });
});

// ====================== PHARMACIST/ADMIN ROUTES ======================
Route::middleware(['auth', 'admin.apoteker'])->group(function () {
    // 🔹 Medicine Management
    Route::resource('/admin/obat', ObatController::class);

    // 🔹 Prescription Medicine
    Route::prefix('admin/obat-resep')->group(function () {
        Route::get('/', [ObatResepController::class, 'index'])->name('admin.obat-resep.index');
        Route::get('/fetch', [ObatResepController::class, 'fetch'])->name('admin.obat-resep.fetch');
        Route::post('/verify/{id}', [ObatResepController::class, 'verify'])->name('admin.obat-resep.verify');
        Route::post('/reject/{id}', [ObatResepController::class, 'reject'])->name('admin.obat-resep.reject');
    });
});

// ====================== DOCTOR/PHARMACIST/ADMIN ROUTES ======================
Route::middleware(['auth', 'admin.dokter.apoteker'])->group(function () {
    // 🔹 Prescription Management
    Route::prefix('admin/resep')->group(function () {
        Route::get('/', [ResepController::class, 'index'])->name('admin.resep.index');
        Route::post('/', [ResepController::class, 'store'])->name('admin.resep.store');
        Route::get('/{id}/edit', [ResepController::class, 'edit'])->name('admin.resep.edit');
        Route::put('/{id}', [ResepController::class, 'update'])->name('admin.resep.update');
        Route::delete('/{id}', [ResepController::class, 'destroy'])->name('admin.resep.destroy');
    });
});

// ====================== DOCTOR/PHARMACIST ROUTES ======================
Route::middleware(['auth', 'dokter.apoteker'])->group(function () {
    // 🔹 Admin Chat
    Route::prefix('admin/chat')->group(function () {
        Route::get('/', [ChatController::class, 'index'])->name('admin.chat.index');
        Route::get('/{id}', [ChatController::class, 'show'])->name('admin.chat.show');
        Route::post('/send', [ChatController::class, 'sendMessage'])->name('admin.chat.send');
        Route::get('/fetch/{id}', [ChatController::class, 'fetchMessages'])->name('admin.chat.fetch');
    });
});
