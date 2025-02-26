<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use App\Models\User;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.passwords.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'nullable|email',
            'phone' => 'nullable|digits:12',
            'username' => 'nullable|string',
        ]);

        // Cari user berdasarkan email, phone, atau username
        $user = User::where('email', $request->email)
                    ->orWhere('phone', $request->phone)
                    ->orWhere('username', $request->username)
                    ->first();

        // Pastikan user ditemukan dan memiliki email
        if (!$user || !$user->email) {
            return back()->withErrors(['email' => 'Akun dengan data tersebut tidak ditemukan atau tidak memiliki email terdaftar.']);
        }

        // Kirim link reset password ke email yang ditemukan
        $status = Password::sendResetLink(['email' => $user->email]);

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __('Link reset kata sandi telah dikirim ke email Anda.'))
            : back()->withErrors(['email' => __('Gagal mengirim link reset password.')]);
    }
}
