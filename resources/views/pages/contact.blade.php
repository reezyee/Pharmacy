@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto px-4 py-8">
        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Layout 1: Pharmacy Information -->
            <div class="w-full lg:w-1/2">
                <div class="bg-cyan-400 p-6 rounded-t-lg shadow-lg text-white">
                    <h1 class="text-2xl font-bold">Tentang Apotek Kami</h1>
                    <p class="mt-1">Informasi lengkap mengenai apotek kami.</p>
                </div>

                @if ($pharmacy)
                    <div class="bg-white p-6 rounded-b-lg shadow-md">
                        <div class="space-y-4">
                            <div>
                                <h2 class="text-xl font-bold text-cyan-600">{{ $pharmacy->name }}</h2>
                                <div class="mt-4 space-y-2 text-gray-700">
                                    @php
                                        $izin = $pharmacy->nomor_izin_apotek;
                                        $visible = 7; // Jumlah digit awal yang ditampilkan
                                        $hiddenLength = max(strlen($izin) - $visible, 0); // Hindari nilai negatif
                                    @endphp

                                    <p><span class="font-medium">Nomor Izin Apotek:</span>
                                        {{ substr($izin, 0, $visible) . str_repeat('x', $hiddenLength) }}</p>
                                    <p><span class="font-medium">Apoteker Penanggung Jawab:</span>
                                        {{ $pharmacy->nama_apoteker }}</p>
                                    <p><span class="font-medium">SIPA:</span>
                                        {{ substr($pharmacy->sipa, 0, 12) . str_repeat('x', strlen($pharmacy->sipa) - 12) }}
                                    </p>
                                    <p><span class="font-medium">Jadwal Praktik:</span> {{ $pharmacy->jadwal_praktik }}</p>
                                </div>
                            </div>

                            <div class="border-t pt-4">
                                <h3 class="text-lg font-semibold text-cyan-600">Informasi Kontak</h3>
                                <ul class="mt-3 space-y-2 text-gray-700">
                                    <li class="flex items-start">
                                        <span class="mr-2">📍</span>
                                        <span>{{ $pharmacy->address }}</span>
                                    </li>
                                    <li class="flex items-start">
                                        <span class="mr-2">📞</span>
                                        <a href="tel:+62123456789" class="text-cyan-500 hover:underline">+62 123 456 789</a>
                                    </li>
                                    <li class="flex items-start">
                                        <span class="mr-2">✉️</span>
                                        <a href="mailto:info@apotekklinik.com"
                                            class="text-cyan-500 hover:underline">info@apotekklinik.com</a>
                                    </li>
                                    <li class="flex items-start">
                                        <span class="mr-2">🕒</span>
                                        <span>Senin - Sabtu, 08:00 - 21:00</span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Peta Lokasi -->
                        <div class="mt-6 border-t pt-4">
                            <h3 class="text-lg font-semibold text-cyan-600 mb-3">Lokasi Apotek</h3>
                            @if ($pharmacy->latitude && $pharmacy->longitude)
                                <div class="rounded-lg overflow-hidden border border-gray-200">
                                    <iframe class="w-full h-64 rounded-lg"
                                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3957.127053619629!2d{{ $pharmacy->longitude }}!3d{{ $pharmacy->latitude }}!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6f5798bcf78e6d%3A0xd20cd79b3cdb4cab!2sApotek%20Sehat!5e0!3m2!1sid!2sid!4v1737086056430!5m2!1sid!2sid"
                                        allowfullscreen="" loading="lazy">
                                    </iframe>
                                </div>
                            @else
                                <p class="text-red-500">Peta lokasi tidak tersedia.</p>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="bg-white p-6 rounded-b-lg shadow-md">
                        <p class="text-gray-600">Informasi apotek tidak tersedia.</p>
                    </div>
                @endif
            </div>

            <!-- Layout 2: Contact Form -->
            <div class="w-full lg:w-1/2">
                <div class="bg-lime-400 p-6 rounded-t-lg shadow-lg text-white">
                    <h1 class="text-2xl font-bold">Hubungi Kami</h1>
                    <p class="mt-1">Kami siap membantu Anda dengan layanan terbaik.</p>
                </div>

                <div class="bg-white p-6 rounded-b-lg shadow-md">
                    <h2 class="text-xl font-bold text-lime-600">Kirim Pesan</h2>
                    <p class="text-gray-600 mt-2">Isi formulir di bawah untuk menghubungi kami.</p>

                    <form action="{{ route('contact.send') }}" method="POST" class="mt-6">
                        @csrf

                        {{-- Tampilkan pesan sukses/gagal --}}
                        @if (session('success'))
                            <div class="bg-green-100 text-green-700 p-3 rounded-md mb-6">
                                {{ session('success') }}
                            </div>
                        @endif

                        {{-- Validasi Error --}}
                        @if ($errors->any())
                            <div class="bg-red-100 text-red-700 p-3 rounded-md mb-6">
                                <ul class="list-disc pl-4">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Input Nama --}}
                        <div class="mb-5">
                            <label class="block text-gray-700 font-medium mb-1">Nama</label>
                            <input type="text" name="nama"
                                class="w-full px-4 py-2 border rounded-md focus:ring-lime-400 focus:border-lime-400 transition"
                                value="{{ old('nama') }}" placeholder="Masukkan nama anda">
                        </div>

                        {{-- Input Email --}}
                        <div class="mb-5">
                            <label class="block text-gray-700 font-medium mb-1">Email</label>
                            <input type="email" name="email"
                                class="w-full px-4 py-2 border rounded-md focus:ring-lime-400 focus:border-lime-400 transition"
                                value="{{ old('email') }}" placeholder="Masukkan email anda">
                        </div>

                        {{-- Input Subjek --}}
                        <div class="mb-5">
                            <label class="block text-gray-700 font-medium mb-1">Subjek</label>
                            <input type="text" name="subjek"
                                class="w-full px-4 py-2 border rounded-md focus:ring-lime-400 focus:border-lime-400 transition"
                                value="{{ old('subjek') }}" placeholder="Subjek pesan">
                        </div>

                        {{-- Input Pesan --}}
                        <div class="mb-6">
                            <label class="block text-gray-700 font-medium mb-1">Pesan</label>
                            <textarea name="pesan" rows="5"
                                class="w-full px-4 py-2 border rounded-md focus:ring-lime-400 focus:border-lime-400 transition"
                                placeholder="Tulis pesan anda disini">{{ old('pesan') }}</textarea>
                        </div>

                        <button
                            class="bg-lime-400 text-white px-6 py-3 rounded-lg font-medium hover:bg-lime-500 transition shadow-md w-full sm:w-auto">
                            Kirim Pesan
                        </button>
                    </form>
                </div>

                <!-- Additional Info -->
                <div class="bg-white p-6 mt-6 rounded-lg shadow-md">
                    <h3 class="text-lg font-semibold text-lime-600 mb-3">Layanan Kami</h3>
                    <ul class="space-y-2 text-gray-700">
                        <li class="flex items-start">
                            <span class="text-lime-500 mr-2">✓</span>
                            <span>Konsultasi dengan apoteker</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-lime-500 mr-2">✓</span>
                            <span>Pengiriman obat ke rumah</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-lime-500 mr-2">✓</span>
                            <span>Pengadaan obat resep</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-lime-500 mr-2">✓</span>
                            <span>Layanan kesehatan dan pemeriksaan</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
