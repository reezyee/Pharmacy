<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use App\Models\User;

class ForgotPasswordController extends Controller
{
    public function showForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'phone' => 'nullable|digits:12',
            'username' => 'nullable|string',
        ]);

        $user = User::where('email', $request->email)
                    ->orWhere('phone', $request->phone)
                    ->orWhere('username', $request->username)
                    ->first();

        if ($user) {
            // Kirim link reset password melalui email
            Password::sendResetLink($request->only('email'));
            return back()->with('status', 'Link reset kata sandi telah dikirim.');
        }

        return back()->withErrors(['email' => 'Akun dengan data tersebut tidak ditemukan.']);
    }
}
