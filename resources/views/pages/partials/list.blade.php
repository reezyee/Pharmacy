@if ($obats->isEmpty())
    <div class="col-span-full py-8">
        <div class="text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4m8-8v16"></path>
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900">Tidak ada produk ditemukan</h3>
            <p class="mt-1 text-sm text-gray-500">Coba ubah filter pencarian Anda</p>
        </div>
    </div>
@else
    <div class="grid grid-cols-2 gap-2">
        @foreach ($obats as $obat)
            <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg">
                <img src="{{ asset('storage/' . $obat->foto) }}" class="w-full h-32 object-cover"
                    alt="{{ $obat->nama }}">
                <div class="p-4">
                    <h3 class="font-semibold text-gray-900 truncate">{{ $obat->nama }}</h3>
                    <p class="text-sm text-gray-500 mb-2">Per {{ $obat->banyak }}
                        {{ $obat->jenisObat?->nama ?? 'Tanpa Jenis' }}</p>
                    <p class="text-lg font-bold text-blue-600 mb-3">Rp{{ number_format($obat->harga, 0, ',', '.') }}</p>
                    @if ($obat->banyak > 0)
                    <!-- Tombol Tambah ke Keranjang -->
                    <button id="tambah-keranjang-{{ $obat->id }}" data-id="{{ $obat->id }}"
                        class="w-full bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition-colors duration-300 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        <span>Tambah ke Keranjang</span>
                    </button>

                    <div id="quantity-controls-{{ $obat->id }}"
                        class="hidden w-full flex items-center justify-between border border-gray-300 rounded-lg p-2">
                        <button id="kurangi-{{ $obat->id }}"
                            class="text-blue-500 hover:bg-blue-50 p-1 rounded">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 12H4" />
                            </svg>
                        </button>
                        <input type="number" id="quantity-{{ $obat->id }}" value="1"
                            class="w-16 text-center border-0 focus:ring-0 p-0" readonly>
                        <button id="tambah-{{ $obat->id }}"
                            class="text-blue-500 hover:bg-blue-50 p-1 rounded">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </button>
                    </div>
                @else
                    <!-- Jika stok habis, tombol dinonaktifkan -->
                    <button
                        class="w-full bg-gray-400 text-white px-4 py-2 rounded-lg flex items-center justify-center gap-2 cursor-not-allowed"
                        disabled>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        <span>Stok Habis</span>
                    </button>
                @endif
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination Links -->
    <div class="mt-6">
        {{ $obats->links() }}
    </div>
@endif
