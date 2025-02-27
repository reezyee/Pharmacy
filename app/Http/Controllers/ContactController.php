<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pharmacy;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        $pharmacy = Pharmacy::where('is_active', true)->first();
        return view('pages.contact', compact('pharmacy'))->with(['title' => 'Contact Us']);
    }

    public function send(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email',
            'pesan' => 'required|string|min:10',
        ]);

        Mail::raw("Pesan dari {$request->nama} ({$request->email}):\n\n{$request->pesan}", function ($mail) {
            $mail->to('rezasapitra514@gmail.com')->subject('Pesan Baru dari Pelanggan');
        });

        return back()->with('success', 'Pesan Anda telah dikirim! Kami akan segera menghubungi Anda.');
    }
}
