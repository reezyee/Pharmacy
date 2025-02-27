<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\CartController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Role;
use League\OAuth1\Client\Credentials\Credentials;


class LoginController extends Controller
{
    protected $redirectTo = '/admin';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login')->with(['title' => 'Login']);;
    }

    public function login(Request $request)
    {
        $request->validate([
            'email_or_phone' => 'required',
            'password' => 'required',
        ]);

        $field = filter_var($request->email_or_phone, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        $user = User::where($field, $request->email_or_phone)->first();

        if (!$user) {
            return back()->withErrors(['email_or_phone' => 'Akun yang anda masukan tidak ditemukan atau belum terdaftar'])->withInput();
        }

        if ($user->auth_method === 'google') {
            return back()->withErrors(['email_or_phone' => 'Akun yang terkait menggunakan login dengan Google. Silahkan gunakan metode yang sama dengan sebelumnya.'])->withInput();
        }

        if (!$user->role_id) {
            $role = Role::firstWhere('name', 'Pelanggan');
            $user->role_id = $role ? $role->id : null;
            $user->save();
        }

        $credentials = [$field => $request->email_or_phone, 'password' => $request->password];

        if (Auth::attempt($credentials)) {
            // Merge session cart with database cart
            app(CartController::class)->mergeCartWithDatabase();

            // Cek role dan redirect sesuai role
            $roleName = $user->role->name ?? 'Pelanggan'; // Default ke Pelanggan jika role tidak ditemukan

            if ($roleName === 'Pelanggan') {
                return redirect()->intended('/user')->with('success', 'Login Berhasil');
            }

            return redirect()->intended('/admin')->with('success', 'Login Berhasil');
        }

        return back()->withErrors(['password' => 'Sandi yang anda masukan salah'])->withInput();
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/')->with('success', 'Logout berhasil');
    }
}
