@if ($obats->isEmpty())
    <div class="col-span-full py-12 bg-gradient-to-r from-slate-900 to-cyan-900 rounded-2xl">
        <div class="text-center">
            <div
                class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-black/30 backdrop-blur-xl mb-6 border border-cyan-400/30">
                <svg class="w-10 h-10 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4m8-8v16"></path>
                </svg>
            </div>
            <h3 class="text-xl font-medium text-white">Tidak ada produk ditemukan</h3>
            <p class="mt-2 text-cyan-300">Coba ubah filter pencarian Anda</p>
        </div>
    </div>
@else
    @foreach ($obats as $obat)
        <div
            class="product-card bg-gradient-to-br from-slate-900 to-cyan-900 rounded-2xl overflow-hidden transition-all duration-300 hover:scale-105 shadow-xl hover:shadow-lime-500/20 border border-cyan-400/20">
            <a href="{{ route('obat.detail', $obat->id) }}">
                <div class="relative">
                    <img src="{{ asset('storage/' . $obat->foto) }}" class="w-full h-40 object-cover object-center"
                        alt="{{ $obat->nama }}">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                </div>
            </a>
            <div class="p-5 relative">
                <!-- Glowing orb decoration -->
                <div class="absolute -top-6 right-4 w-12 h-12 rounded-full bg-lime-400/20 blur-xl"></div>

                <h3 class="font-bold text-white text-lg truncate">{{ $obat->nama }}</h3>
                <p class="text-cyan-300 text-sm mb-3">Per {{ $obat->banyak }}
                    {{ $obat->jenisObat?->nama ?? 'Tanpa Jenis' }}</p>
                <p class="text-xl font-bold text-lime-400 mb-4">Rp{{ number_format($obat->harga, 0, ',', '.') }}</p>

                @if ($obat->banyak > 0)
                    <!-- Tombol Tambah ke Keranjang -->
                    <button id="tambah-keranjang-{{ $obat->id }}" data-id="{{ $obat->id }}"
                        class="w-full bg-gradient-to-r from-cyan-600 to-lime-600 hover:from-cyan-500 hover:to-lime-500 text-white px-4 py-3 rounded-xl transition-all duration-300 flex items-center justify-center gap-2 backdrop-blur-sm shadow-lg shadow-lime-600/20 border border-cyan-400/30">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        <span>Tambah ke Keranjang</span>
                    </button>

                    <div id="quantity-controls-{{ $obat->id }}"
                        class="hidden w-full flex items-center justify-between bg-slate-800/50 backdrop-blur-sm border border-cyan-400/20 rounded-xl p-3 mt-3">
                        <button id="kurangi-{{ $obat->id }}"
                            class="text-cyan-400 hover:text-lime-300 hover:bg-cyan-900/50 p-2 rounded-lg transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                            </svg>
                        </button>
                        <input type="number" id="quantity-{{ $obat->id }}" value="1"
                            class="w-16 text-center bg-transparent border-0 focus:ring-0 p-0 text-white font-bold"
                            readonly>
                        <button id="tambah-{{ $obat->id }}"
                            class="text-lime-400 hover:text-cyan-300 hover:bg-cyan-900/50 p-2 rounded-lg transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </button>
                    </div>
                @else
                    <!-- Jika stok habis, tombol dinonaktifkan -->
                    <button
                        class="w-full bg-slate-800 text-gray-400 px-4 py-3 rounded-xl flex items-center justify-center gap-2 cursor-not-allowed border border-slate-700/50"
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
@endif

<!-- Pagination Links with futuristic styling -->
@if (isset($obats) && $obats->hasPages())
    <div class="pagination-container mt-8">
        {{ $obats->withQueryString()->links('vendor.pagination.tailwind', ['class' => 'pagination-futuristic']) }}
    </div>

    <style>
        /* Custom styling for pagination */
        .pagination-futuristic nav {
            @apply flex justify-center;
        }

        .pagination-futuristic .pagination {
            @apply flex rounded-xl overflow-hidden bg-slate-900/50 backdrop-blur-sm border border-cyan-400/20;
        }

        .pagination-futuristic .page-item {
            @apply border-r border-cyan-400/20 last:border-0;
        }

        .pagination-futuristic .page-link {
            @apply px-4 py-2 text-cyan-400 hover:bg-cyan-900/50 transition-colors;
        }

        .pagination-futuristic .page-item.active .page-link {
            @apply bg-gradient-to-r from-cyan-600 to-lime-600 text-white;
        }

        .pagination-futuristic .page-item.disabled .page-link {
            @apply text-gray-600 cursor-not-allowed;
        }
    </style>
@endif
