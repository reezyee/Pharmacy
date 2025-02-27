@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
    {{-- Informasi Apotek --}}
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-cyan-600">Informasi Apotek</h2>
        @if ($pharmacy)
            <p class="text-gray-600 mt-2">{{ $pharmacy->name }}</p>
            <ul class="mt-3 space-y-2 text-gray-700">
                <li><strong>📍 Alamat:</strong> {{ $pharmacy->address }}</li>
                <li><strong>📞 Telepon:</strong> <a href="tel:+62123456789" class="text-cyan-500">+62 123 456 789</a></li>
                <li><strong>✉️ Email:</strong> <a href="mailto:info@apotekklinik.com" class="text-cyan-500">info@apotekklinik.com</a></li>
                <li><strong>🕒 Jadwal:</strong> {{ $pharmacy->jadwal_praktik }}</li>
                <li><strong>👨‍⚕️ Apoteker:</strong> {{ $pharmacy->nama_apoteker }}</li>
            </ul>
        @else
            <p class="text-red-500">Informasi apotek tidak tersedia.</p>
        @endif
    </div>

    {{-- Formulir Kontak --}}
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-bold text-cyan-600">Kirim Pesan</h2>
        <p class="text-gray-600 mt-2">Isi formulir di bawah untuk menghubungi kami.</p>

        <form action="{{ route('contact.send') }}" method="POST" class="mt-4">
            @csrf

            @if (session('success'))
                <div class="bg-green-100 text-green-700 p-3 rounded-md mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 text-red-700 p-3 rounded-md mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mb-4">
                <label class="block text-gray-700">Nama</label>
                <input type="text" name="nama" class="w-full px-4 py-2 border rounded-md focus:ring-lime-400 focus:border-lime-400" value="{{ old('nama') }}">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Email</label>
                <input type="email" name="email" class="w-full px-4 py-2 border rounded-md focus:ring-lime-400 focus:border-lime-400" value="{{ old('email') }}">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Pesan</label>
                <textarea name="pesan" rows="4" class="w-full px-4 py-2 border rounded-md focus:ring-lime-400 focus:border-lime-400">{{ old('pesan') }}</textarea>
            </div>

            <button class="bg-lime-400 text-white px-6 py-2 rounded-lg hover:bg-lime-500">Kirim</button>
        </form>
    </div>
</div>

{{-- Peta Lokasi --}}
<div class="max-w-6xl mx-auto p-6 bg-white mt-6 rounded-lg shadow-md">
    <h2 class="text-xl font-bold text-cyan-600">Lokasi Apotek</h2>
    <p class="text-gray-600 mt-2">Temukan lokasi kami dengan mudah:</p>
    <div class="mt-3">
        @if ($pharmacy && $pharmacy->latitude && $pharmacy->longitude)
            <iframe class="w-full h-64 rounded-lg"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3957.127053619629!2d{{ $pharmacy->longitude }}!3d{{ $pharmacy->latitude }}!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6f5798bcf78e6d%3A0xd20cd79b3cdb4cab!2sApotek%20Sehat!5e0!3m2!1sid!2sid!4v1737086056430!5m2!1sid!2sid"
                allowfullscreen="" loading="lazy">
            </iframe>
        @else
            <p class="text-red-500">Peta lokasi tidak tersedia.</p>
        @endif
    </div>
</div>
@endsection
