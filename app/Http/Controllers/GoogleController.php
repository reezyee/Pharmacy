<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    public function login()
    {
        return Socialite::driver('google')
            ->with(['prompt' => 'select_account'])
            ->redirect();
    }

    public function callback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Terjadi kesalahan saat login!');
        }

        $user = User::where('email', $googleUser->getEmail())->first();

        if (!$user) {
            $role = Role::firstWhere('name', 'Pelanggan');

            // Simpan data pengguna baru
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'password' => bcrypt(Str::random(16)),
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),  // Gunakan avatar yang benar
                'role_id' => $role ? $role->id : null,
                'auth_method' => 'google',
            ]);
        }

        // Login pengguna
        Auth::login($user, true);
        // Merge session cart dengan database cart setelah login
        app(CartController::class)->mergeCartWithDatabase();

        // Redirect dengan URL yang sesuai (gunakan input 'redirect' jika ada)
        $redirect = $request->input('redirect', route('user'));
        return redirect()->intended($redirect);
    }

    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect('https://accounts.google.com/Logout?continue=' . urlencode(route('login')));
    }
}
