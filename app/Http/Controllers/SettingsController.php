<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Pharmacy;

class SettingsController extends Controller
{
    public function index()
    {
        // Mengecek peran pengguna yang sedang login
        $role = Auth::user()->role->name ?? 'Pelanggan';

        // Jika peran adalah Pelanggan, arahkan ke halaman setting pelanggan
        if ($role === 'Pelanggan') {
            return view('pages.user.setting')->with(['title' => 'Settings']);
        }

        // Jika bukan Pelanggan, arahkan ke halaman setting admin
        // Get pharmacy data for admin view
        $pharmacy = Pharmacy::first(); // Or use a more specific query based on your requirements
        return view('pages.admin.setting')->with([
            'title' => 'Setting',
            'pharmacy' => $pharmacy
        ]);
    }

    public function updateProfile(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Ambil user yang sedang login
        $user = Auth::user();

        // Update data user
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->address = $request->input('address');

        // Cek apakah ada gambar yang diupload
        if ($request->hasFile('avatar')) {
            // Hapus gambar lama jika ada
            if ($user->avatar && Storage::exists('public/' . $user->avatar)) {
                Storage::delete('public/' . $user->avatar);
            }

            // Simpan gambar baru
            $avatar = $request->file('avatar')->store('images', 'public');
            $user->avatar = $avatar;
        }

        // Simpan perubahan
        $user->save();
        // Redirect dengan pesan sukses
        return redirect()->route('settings.index')->with('success', 'Profile updated successfully.');
    }

    // Update password
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        // Ambil user yang sedang login
        $user = Auth::user();

        // Perbarui password
        $user->password = Hash::make($request->input('new_password'));

        // Simpan perubahan
        $user->save();

        // Redirect dengan pesan sukses
        return redirect()->route('settings.index')->with('success', 'Password updated successfully.');
    }

    // Update notification settings
    public function updateNotifications(Request $request)
    {
        $user = Auth::user();

        // Update preferensi notifikasi
        $user->email_notifications = $request->has('email_notifications');
        $user->sms_notifications = $request->has('sms_notifications');

        // Simpan perubahan
        $user->save();

        // Redirect dengan pesan sukses
        return redirect()->route('settings.index')->with('success', 'Notification settings updated.');
    }

    // Add method to update pharmacy information
    public function updatePharmacy(Request $request)
    {
        // Validate pharmacy data
        $request->validate([
            'name' => 'required|string|max:255',
            'nomor_izin_apotek' => 'required|string|max:255',
            'nama_apoteker' => 'required|string|max:255',
            'sipa' => 'required|string|max:255',
            'jadwal_praktik' => 'required|string',
            'address' => 'required|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        // Find or create pharmacy record
        $pharmacy = Pharmacy::first();
        if (!$pharmacy) {
            $pharmacy = new Pharmacy();
        }

        // Update pharmacy data
        $pharmacy->name = $request->input('name');
        $pharmacy->nomor_izin_apotek = $request->input('nomor_izin_apotek');
        $pharmacy->nama_apoteker = $request->input('nama_apoteker');
        $pharmacy->sipa = $request->input('sipa');
        $pharmacy->jadwal_praktik = $request->input('jadwal_praktik');
        $pharmacy->address = $request->input('address');
        $pharmacy->latitude = $request->input('latitude');
        $pharmacy->longitude = $request->input('longitude');
        $pharmacy->is_active = $request->has('is_active') ? 1 : 0;

        // Save pharmacy data
        $pharmacy->save();

        // Redirect with success message
        return redirect()->route('settings.index')->with('success', 'Pharmacy information updated successfully.');
    }
}
