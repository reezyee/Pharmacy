@extends('layouts.auth')

@section('content')
    <div class="container mx-auto px-4 py-8 font-mono">
        <div class="max-w-2xl mx-auto bg-white rounded-lg shadow p-6">
            <div class="text-center mb-8">
                <svg class="w-16 h-16 text-green-500 border-2 rounded-full border-green-500 mx-auto mb-4" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <h1 class="text-2xl font-bold text-gray-800">Resep Berhasil Ditebus!</h1>
                <span class="flex gap-2 justify-center items-center">
                    <img src="{{ asset('storage/images/logo.png') }}" class="w-7" alt="">
                    <p class="text-xl leading-4 font-semibold">PT. Apotek Amanah</p>
                </span>
                <p class="text-gray-600 mt-2">Nomor Resep: <span
                        class="font-bold text-lg text-red-700">{{ $order->order_number }}</span>
                </p>
            </div>

            {{-- Informasi Pasien & Dokter --}}
            <div class="border-t border-b py-4 my-4 space-y-3">
                <div class="flex justify-between font-medium">
                    <span>Nama Pasien:</span>
                    <span>{{ $order->user->name }}</span>
                </div>
                <div class="flex justify-between font-medium">
                    <span>Nama Dokter:</span>
                    <span>
                        {{ $order->resep ? $order->resep->dokter->name ?? 'Tidak diketahui' : 'Tidak diketahui' }}
                    </span>
                </div>

                <div class="flex justify-between font-medium">
                    <span>Payment Method:</span>
                    @if ($order->payment_method === 'cop')
                        <span>Cash On Pickup</span>
                    @elseif ($order->payment_method === 'cod')
                        <span>Cash On Delivery</span>
                    @else
                        <span>Bank Transfer</span>
                    @endif
                </div>
            </div>

            {{-- Detail Obat dalam Resep --}}
            <div class="mt-6">
                <h2 class="text-xl font-semibold mb-4">Obat dalam Resep</h2>
                <div class="space-y-4">
                    {{-- Detail Obat dalam Resep --}}
                    @if ($order->resep)
                        <div class="mt-6">
                            <div class="space-y-4">
                                @foreach ($order->resep->obatReseps as $item)
                                    <div class="flex justify-between items-center py-3 border-b last:border-b-0">
                                        <div class="flex items-center space-x-4">
                                            <img src="{{ asset('storage/' . $item->obat->foto) }}"
                                                alt="{{ $item->obat->nama }}" class="w-16 h-16 object-cover rounded">
                                            <div>
                                                <h3 class="font-medium">{{ $item->obat->nama }}</h3>
                                                <p class="text-gray-600 text-sm">
                                                    Rp{{ number_format($item->obat->harga) }} x {{ $item->dosis }} 
                                                </p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-semibold">Rp{{ number_format((optional($item->obat)->harga ?? 0) * (int) preg_replace('/\D/', '', $item->dosis)) }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <p class="text-red-500 font-semibold mt-4">Resep tidak ditemukan atau belum terhubung ke pesanan
                            ini.</p>
                    @endif
                </div>
            </div>

            {{-- Total Pembayaran --}}
            <div class="mt-6 pt-4 space-y-2">
                <div class="flex justify-between text-lg border-t pt-3">
                    <p>Subtotal</p>
                    <p class="font-semibold">Rp{{ number_format($order->total_amount) }}</p>
                </div>
                @if ($order->payment_method !== 'cop')
                    <div class="flex justify-between">
                        <p class="font-medium">Shipping Cost</p>
                        <p>Rp 10,000</p>
                    </div>
                @endif
                @if ($order->payment_method === 'cod')
                    <div class="flex justify-between">
                        <p class="font-medium">Handling Fee</p>
                        <p>Rp 1,000</p>
                    </div>
                @endif
                <div class="flex justify-between text-lg font-black border-t pt-3">
                    <p>Total Bayar</p>
                    <p class="font-bold text-xl">
                        Rp{{ number_format($order->total_amount + ($order->payment_method !== 'cop' ? 10000 : 0) + ($order->payment_method === 'cod' ? 1000 : 0)) }}
                    </p>
                </div>
            </div>

            {{-- Instruksi Pembayaran --}}
            @if ($order->payment_method === 'transfer')
                <div class="mt-6 bg-blue-50 p-4 rounded-lg">
                    <h3 class="font-semibold text-blue-800 mb-2">Instruksi Pembayaran</h3>
                    <p class="text-blue-600">Silakan transfer ke rekening berikut:</p>
                    <div class="mt-2 p-3 bg-white rounded border border-blue-200">
                        <p class="font-mono">Bank: BCA</p>
                        <p class="font-mono">No. Rekening: 1234567890</p>
                        <p class="font-mono">Atas Nama: PT. Apotek Amanah</p>
                        <p class="font-mono">Jumlah: Rp{{ number_format($order->total_amount) }}</p>
                    </div>
                    <p class="text-sm text-blue-600 mt-2 font-semibold">
                        * Cantumkan nomor resep ({{ $order->order_number }}) dalam keterangan transfer.
                    </p>
                </div>
            @else
                <div class="mt-6 bg-green-50 p-4 rounded-lg">
                    <h3 class="font-semibold text-green-800 mb-2">Instruksi Pengambilan</h3>
                    <p class="text-green-600">Silakan ambil obat di:</p>
                    <div class="mt-2">
                        <p class="font-medium">Apotek Amanah</p>
                        <p>Jalan Ibu Apipah No. 06, Kec. Tawang, Kota Tasikmalaya</p>
                        <p>Telepon: 085123456789</p>
                    </div>
                    <p class="text-sm text-green-600 mt-2 font-semibold">
                        * Jangan lupa membawa nomor resep ({{ $order->order_number }})
                    </p>
                </div>
            @endif

            {{-- Tombol Aksi --}}
            <div class="mt-8 flex justify-center space-x-4">
                <a href="{{ route('home') }}"
                    class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    <span>Kembali ke Home</span>
                </a>
                <a href=""
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h11M9 21V3"></path>
                    </svg>
                    <span>View Order Details</span>
                </a>
                <a href="{{ route('order.pdf', $order) }}"
                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                        fill="white">
                        <path
                            d="m720-120 160-160-56-56-64 64v-167h-80v167l-64-64-56 56 160 160ZM560 0v-80h320V0H560ZM240-160q-33 0-56.5-23.5T160-240v-560q0-33 23.5-56.5T240-880h280l240 240v121h-80v-81H480v-200H240v560h240v80H240Zm0-80v-560 560Z" />
                    </svg>
                </a>
            </div>

            @if (session('success'))
                <div class="mt-6 p-4 bg-green-50 text-green-700 rounded-lg text-center">
                    {{ session('success') }}
                </div>
            @endif
        </div>
    </div>
@endsection
