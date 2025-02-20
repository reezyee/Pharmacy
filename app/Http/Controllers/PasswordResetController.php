<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PasswordResetController extends Controller
{
    // Menampilkan form untuk input email (untuk reset link)
    public function showResetForm()
    {
        return view('auth.passwords.email');
    }

    // Mengirim link reset password
    public function sendResetLinkEmail(Request $request)
    {
        // Validasi input (email, username, atau phone)
        $validator = Validator::make($request->all(), [
            'email' => 'nullable|email|exists:users,email',
            'phone' => 'nullable|exists:users,phone',
            'username' => 'nullable|exists:users,username',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Mencari user berdasarkan input
        $user = null;
        if ($request->has('email')) {
            $user = User::where('email', $request->email)->first();
        } elseif ($request->has('phone')) {
            $user = User::where('phone', $request->phone)->first();
        } elseif ($request->has('username')) {
            $user = User::where('username', $request->username)->first();
        }

        if ($user) {
            // Kirim email reset password
            Password::sendResetLink(['email' => $user->email]);
        }

        return back()->with('status', 'Link reset kata sandi telah dikirim jika email/nama pengguna/nomor telepon ditemukan.');
    }

    // Menampilkan form untuk memasukkan kata sandi baru
    public function showNewPasswordForm($token)
    {
        return view('auth.passwords.reset', ['token' => $token]);
    }

    // Menangani reset kata sandi
    public function resetPassword(Request $request)
    {
        // Validasi form reset password
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|confirmed|min:8',
            'token' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Melakukan proses reset kata sandi
        $resetStatus = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->password = Hash::make($request->password);
                $user->save();
            }
        );

        if ($resetStatus == Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', 'Kata sandi berhasil direset.');
        }

        return back()->withErrors(['email' => [trans($resetStatus)]]);
    }
}
