@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <!-- Filter Section -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Search Filter -->
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input type="text" id="search"
                        class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Cari obat, vitamin...">
                </div>

                <!-- Price Range Filter -->
                <div>
                    <select id="price_range"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-4">
                        <option value="">Rentang Harga</option>
                        <option value="0-50000">Rp0 - Rp50.000</option>
                        <option value="50000-100000">Rp50.000 - Rp100.000</option>
                        <option value="100000-200000">Rp100.000 - Rp200.000</option>
                        <option value="200000-500000">Rp200.000 - Rp500.000</option>
                        <option value="500000-1000000">Rp500.000 - Rp1.000.000</option>
                        <option value="1000000-">Di atas Rp1.000.000</option>
                    </select>
                </div>

                <!-- Availability Filter -->
                <div>
                    <select id="availability"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-4">
                        <option value="">Ketersediaan</option>
                        <option value="1">Tersedia</option>
                        <option value="0">Tidak Tersedia</option>
                    </select>
                </div>

                <!-- Reset Filter Button -->
                <button id="resetFilters"
                    class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-4 transition-all duration-300">
                    Reset Filter
                </button>
            </div>
        </div>

        <!-- Categories Section -->
        <div class="relative mb-8">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-900">Kategori</h2>
            </div>

            <div class="relative">
                <div id="kategoriCarousel" class="overflow-hidden">
                    <div id="kategoriItems" class="flex space-x-2 transition-all duration-300 p-2">
                        @foreach ($kategoris as $kategori)
                            <div class="category-item group relative max-w-fit cursor-pointer"
                                data-kategori-id="{{ $kategori->id }}">
                                <div
                                    class="flex flex-col items-center p-4 bg-white rounded-xl shadow-md transition-all duration-300 hover:shadow-lg hover:scale-105">
                                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mb-2">
                                        <span
                                            class="text-lg font-semibold text-blue-600">{{ substr($kategori->nama, 0, 1) }}</span>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700">{{ $kategori->nama }}</span>
                                    <div
                                        class="category-indicator hidden absolute -top-1 -right-1 w-3 h-3 bg-blue-500 rounded-full">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Previous and Next buttons -->
                <button type="button" id="prevKategori"
                    class="absolute top-1/2 -left-4 -translate-y-1/2 bg-white p-2 rounded-full shadow-lg hover:bg-gray-50">
                    <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>

                <button type="button" id="nextKategori"
                    class="absolute top-1/2 -right-4 -translate-y-1/2 bg-white p-2 rounded-full shadow-lg hover:bg-gray-50">
                    <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Cart Popup -->
        <div id="cart-popup"
            class="fixed top-4 right-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 shadow-md rounded-md hidden opacity-0 transition-opacity duration-300">
        </div>

        <!-- Products Grid -->
        <div id="productsContainer" class="grid grid-cols-2">
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

        <!-- Pagination -->
        <div class="mt-8" id="pagination">
            {{ $obats->links() }}
        </div>
    </div>
@endsection

<style>
    .category-item {
        position: relative;
    }

    .category-indicator {
        position: absolute;
        top: -3px;
        right: -3px;
        width: 8px;
        height: 8px;
        background-color: #3b82f6;
        /* Biru terang */
        border-radius: 50%;
    }

    #kategoriItems {
        display: flex;
        transition: transform 0.3s ease-in-out;
    }

    #kategoriCarousel {
        position: relative;
    }

    #prevKategori,
    #nextKategori {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background-color: rgba(255, 255, 255, 0.8);
        border: none;
        padding: 8px;
        border-radius: 50%;
        cursor: pointer;
    }

    #prevKategori {
        left: -20px;
    }

    #nextKategori {
        right: -20px;
    }

    #prevKategori:hover,
    #nextKategori:hover {
        background-color: rgba(255, 255, 255, 1);
    }

    #kategoriItems {
        overflow-x: auto;
        scroll-behavior: smooth;
        white-space: nowrap;
        display: flex;
        gap: 16px;

        /* Sembunyikan scrollbar */
        scrollbar-width: none;
        /* Firefox */
    }

    #kategoriItems::-webkit-scrollbar {
        display: none;
        /* Chrome, Safari, Edge */
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let activeFilters = {
            search: '',
            kategori_id: '',
            harga_min: '',
            harga_max: '',
            availability: ''
        };

        const productsContainer = document.getElementById('productsContainer');
        const paginationContainer = document.getElementById('pagination');
        const searchInput = document.getElementById('search');
        const priceRangeSelect = document.getElementById('price_range');
        const availabilitySelect = document.getElementById('availability');
        const resetButton = document.getElementById('resetFilters');
        const kategoriItems = document.getElementById('kategoriItems');
        const prevKategoriButton = document.getElementById('prevKategori');
        const nextKategoriButton = document.getElementById('nextKategori');

        // Get CSRF token for AJAX requests
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;


        const priceRanges = {
            '0-50000': {
                min: 0,
                max: 50000
            },
            '50000-100000': {
                min: 50000,
                max: 100000
            },
            '100000-200000': {
                min: 100000,
                max: 200000
            },
            '200000-500000': {
                min: 200000,
                max: 500000
            },
            '500000-1000000': {
                min: 500000,
                max: 1000000
            },
            '1000000-': {
                min: 1000000,
                max: null
            }
        };

        // Initialize cart functionality
        function initializeCart() {
            // Initialize quantity controls for items already in cart
            fetch("/cart/count")
                .then((response) => response.json())
                .then((data) => {
                    updateCartCount(data.count);
                    // Initialize UI controls for items in cart
                    if (data.items && data.items.length > 0) {
                        data.items.forEach(item => {
                            showQuantityControls(item.obat_id, item.quantity);
                        });
                    }
                });

            // Set up event listeners after filtering
            setupCartEventListeners();
        }

        // Set up event listeners for cart buttons
        function setupCartEventListeners() {
            // Add to cart button handlers
            document
                .querySelectorAll('[id^="tambah-keranjang-"]')
                .forEach((button) => {
                    button.addEventListener("click", handleAddToCart);
                });

            // Quantity control handlers
            document.querySelectorAll('[id^="tambah-"]').forEach((button) => {
                if (!button.id.includes("keranjang")) {
                    button.addEventListener("click", handleIncreaseQuantity);
                }
            });

            document.querySelectorAll('[id^="kurangi-"]').forEach((button) => {
                button.addEventListener("click", handleDecreaseQuantity);
            });
        }

        async function handleAddToCart(event) {
            const button = event.currentTarget;
            const obatId = button.dataset.id;

            try {
                const response = await fetch("/cart/add", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrfToken,
                    },
                    body: JSON.stringify({
                        obat_id: obatId
                    }),
                });

                const data = await response.json();

                if (data.success) {
                    showQuantityControls(obatId, data.quantity || 1);
                    showCartPopup(data.message);
                    updateCartCount(data.cartCount);
                }
            } catch (error) {
                console.error("Error adding to cart:", error);
            }
        }

        function showQuantityControls(obatId, quantity) {
            const addButton = document.querySelector(`#tambah-keranjang-${obatId}`);
            const quantityControls = document.querySelector(`#quantity-controls-${obatId}`);
            const quantityInput = document.querySelector(`#quantity-${obatId}`);

            if (addButton && quantityControls && quantityInput) {
                addButton.classList.add("hidden");
                quantityControls.classList.remove("hidden");
                quantityInput.value = quantity;
            }
        }

        async function handleIncreaseQuantity(event) {
            const obatId = event.currentTarget.id.replace("tambah-", "");
            const quantityInput = document.querySelector(`#quantity-${obatId}`);
            const newQuantity = parseInt(quantityInput.value) + 1;

            await updateCartQuantity(obatId, newQuantity);
        }

        async function handleDecreaseQuantity(event) {
            const obatId = event.currentTarget.id.replace("kurangi-", "");
            const quantityInput = document.querySelector(`#quantity-${obatId}`);
            const newQuantity = parseInt(quantityInput.value) - 1;

            if (newQuantity > 0) {
                await updateCartQuantity(obatId, newQuantity);
            } else {
                await removeFromCart(obatId);
                hideQuantityControls(obatId);
            }
        }

        async function updateCartQuantity(obatId, quantity) {
            try {
                const response = await fetch("/cart/update", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrfToken,
                    },
                    body: JSON.stringify({
                        obat_id: obatId,
                        quantity: quantity,
                    }),
                });

                const data = await response.json();

                if (data.success) {
                    document.querySelector(`#quantity-${obatId}`).value = quantity;
                    updateCartCount(data.cartCount);
                }
            } catch (error) {
                console.error("Error updating cart:", error);
            }
        }

        async function removeFromCart(obatId) {
            try {
                const response = await fetch("/cart/remove", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrfToken,
                    },
                    body: JSON.stringify({
                        obat_id: obatId
                    }),
                });

                const data = await response.json();

                if (data.success) {
                    hideQuantityControls(obatId);
                    updateCartCount(data.cartCount);
                }
            } catch (error) {
                console.error("Error removing from cart:", error);
            }
        }

        function hideQuantityControls(obatId) {
            const addButton = document.querySelector(`#tambah-keranjang-${obatId}`);
            const quantityControls = document.querySelector(`#quantity-controls-${obatId}`);

            if (addButton && quantityControls) {
                addButton.classList.remove("hidden");
                quantityControls.classList.add("hidden");
            }
        }

        function updateCartCount(count) {
            const cartCountElement = document.querySelector("#cart-count");
            if (cartCountElement) {
                cartCountElement.textContent = count || "0";
            }
        }

        function showCartPopup(message) {
            const popup = document.getElementById("cart-popup");
            if (popup) {
                popup.textContent = message;
                popup.classList.remove("hidden");
                popup.classList.add("opacity-100");

                setTimeout(() => {
                    popup.classList.remove("opacity-100");
                    popup.classList.add("opacity-0");
                    setTimeout(() => {
                        popup.classList.add("hidden");
                    }, 300);
                }, 2000);
            }
        }

        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }

        const updateProducts = debounce(async () => {
            try {
                const queryParams = new URLSearchParams();
                if (activeFilters.search) queryParams.set('search', activeFilters.search);
                if (activeFilters.kategori_id) queryParams.set('kategori_id', activeFilters
                    .kategori_id);
                if (activeFilters.harga_min) queryParams.set('harga_min', activeFilters.harga_min);
                if (activeFilters.harga_max) queryParams.set('harga_max', activeFilters.harga_max);
                if (activeFilters.availability) queryParams.set('availability', activeFilters
                    .availability);

                productsContainer.classList.add('opacity-50');
                const response = await fetch(`/shop/filter?${queryParams.toString()}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                if (!response.ok) throw new Error('Network response was not ok');

                const data = await response.json();

                productsContainer.innerHTML = data.html;
                paginationContainer.innerHTML = data.pagination;

                window.history.pushState({}, '',
                    `${window.location.pathname}?${queryParams.toString()}`);

                // Re-setup cart event listeners after content update
                setupCartEventListeners();
            } catch (error) {
                console.error('Error updating products:', error);
            } finally {
                productsContainer.classList.remove('opacity-50');
            }
        }, 300);

        searchInput.addEventListener('input', (e) => {
            activeFilters.search = e.target.value;
            updateProducts();
        });

        priceRangeSelect.addEventListener('change', (e) => {
            const range = priceRanges[e.target.value];
            if (range) {
                activeFilters.harga_min = range.min;
                activeFilters.harga_max = range.max;
            } else {
                activeFilters.harga_min = '';
                activeFilters.harga_max = '';
            }
            updateProducts();
        });

        availabilitySelect.addEventListener('change', (e) => {
            activeFilters.availability = e.target.value;
            updateProducts();
        });

        resetButton.addEventListener('click', () => {
            activeFilters = {
                search: '',
                kategori_id: '',
                harga_min: '',
                harga_max: '',
                availability: ''
            };
            searchInput.value = '';
            priceRangeSelect.value = '';
            availabilitySelect.value = '';
            document.querySelectorAll('.category-item').forEach((item) => {
                item.classList.remove('bg-blue-50');
                item.querySelector('.category-indicator').classList.add('hidden');
            });
            updateProducts();
        });

        function updateButtonVisibility() {
            prevKategoriButton.style.display = kategoriItems.scrollLeft > 0 ? 'block' : 'none';
            nextKategoriButton.style.display =
                kategoriItems.scrollLeft + kategoriItems.clientWidth < kategoriItems.scrollWidth - 10 ?
                'block' :
                'none';
        }

        // Handle category filter selection
        kategoriItems.addEventListener('click', function(e) {
            const categoryItem = e.target.closest('.category-item');
            if (categoryItem) {
                const kategoriId = categoryItem.dataset.kategoriId;
                const indicator = categoryItem.querySelector('.category-indicator');

                // Jika kategori yang sama diklik lagi, reset filter
                if (activeFilters.kategori_id === kategoriId) {
                    activeFilters.kategori_id = ''; // Hapus filter kategori
                    categoryItem.classList.remove('bg-blue-50'); // Hapus highlight
                    indicator.classList.add('hidden'); // Sembunyikan indikator
                } else {
                    activeFilters.kategori_id = kategoriId;

                    // Reset semua kategori lainnya
                    const allCategories = document.querySelectorAll('.category-item');
                    allCategories.forEach((item) => {
                        item.classList.remove('bg-blue-50');
                        item.querySelector('.category-indicator').classList.add('hidden');
                    });

                    // Tandai kategori yang dipilih
                    categoryItem.classList.add('bg-blue-50');
                    indicator.classList.remove('hidden'); // Tampilkan indikator
                }
                updateProducts();
            }
        });

        prevKategoriButton.addEventListener('click', function(e) {
            e.preventDefault();
            kategoriItems.scrollBy({
                left: -200,
                behavior: 'smooth'
            });
        });

        nextKategoriButton.addEventListener('click', function(e) {
            e.preventDefault();
            kategoriItems.scrollBy({
                left: 200,
                behavior: 'smooth'
            });
        });

        kategoriItems.addEventListener('scroll', updateButtonVisibility);
        window.addEventListener('resize', updateButtonVisibility);

        // Load products on page load
        updateProducts();const updateProducts = debounce(async () => {
            try {
                const queryParams = new URLSearchParams();
                if (activeFilters.search) queryParams.set('search', activeFilters.search);
                if (activeFilters.kategori_id) queryParams.set('kategori_id', activeFilters
                    .kategori_id);
                if (activeFilters.harga_min) queryParams.set('harga_min', activeFilters.harga_min);
                if (activeFilters.harga_max) queryParams.set('harga_max', activeFilters.harga_max);
                if (activeFilters.availability) queryParams.set('availability', activeFilters
                    .availability);

                productsContainer.classList.add('opacity-50');
                const response = await fetch(`/shop/filter?${queryParams.toString()}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                if (!response.ok) throw new Error('Network response was not ok');

                const data = await response.json();

                productsContainer.innerHTML = data.html;
                paginationContainer.innerHTML = data.pagination;

                window.history.pushState({}, '',
                    `${window.location.pathname}?${queryParams.toString()}`);

                // Re-setup cart event listeners after content update
                setupCartEventListeners();
            } catch (error) {
                console.error('Error updating products:', error);
            } finally {
                productsContainer.classList.remove('opacity-50');
            }
        }, 300);

        searchInput.addEventListener('input', (e) => {
            activeFilters.search = e.target.value;
            updateProducts();
        });

        priceRangeSelect.addEventListener('change', (e) => {
            const range = priceRanges[e.target.value];
            if (range) {
                activeFilters.harga_min = range.min;
                activeFilters.harga_max = range.max;
            } else {
                activeFilters.harga_min = '';
                activeFilters.harga_max = '';
            }
            updateProducts();
        });

        availabilitySelect.addEventListener('change', (e) => {
            activeFilters.availability = e.target.value;
            updateProducts();
        });

        resetButton.addEventListener('click', () => {
            activeFilters = {
                search: '',
                kategori_id: '',
                harga_min: '',
                harga_max: '',
                availability: ''
            };
            searchInput.value = '';
            priceRangeSelect.value = '';
            availabilitySelect.value = '';
            document.querySelectorAll('.category-item').forEach((item) => {
                item.classList.remove('bg-blue-50');
                item.querySelector('.category-indicator').classList.add('hidden');
            });
            updateProducts();
        });

        function updateButtonVisibility() {
            prevKategoriButton.style.display = kategoriItems.scrollLeft > 0 ? 'block' : 'none';
            nextKategoriButton.style.display =
                kategoriItems.scrollLeft + kategoriItems.clientWidth < kategoriItems.scrollWidth - 10 ?
                'block' :
                'none';
        }

        // Handle category filter selection
        kategoriItems.addEventListener('click', function(e) {
            const categoryItem = e.target.closest('.category-item');
            if (categoryItem) {
                const kategoriId = categoryItem.dataset.kategoriId;
                const indicator = categoryItem.querySelector('.category-indicator');

                // Jika kategori yang sama diklik lagi, reset filter
                if (activeFilters.kategori_id === kategoriId) {
                    activeFilters.kategori_id = ''; // Hapus filter kategori
                    categoryItem.classList.remove('bg-blue-50'); // Hapus highlight
                    indicator.classList.add('hidden'); // Sembunyikan indikator
                } else {
                    activeFilters.kategori_id = kategoriId;

                    // Reset semua kategori lainnya
                    const allCategories = document.querySelectorAll('.category-item');
                    allCategories.forEach((item) => {
                        item.classList.remove('bg-blue-50');
                        item.querySelector('.category-indicator').classList.add('hidden');
                    });

                    // Tandai kategori yang dipilih
                    categoryItem.classList.add('bg-blue-50');
                    indicator.classList.remove('hidden'); // Tampilkan indikator
                }
                updateProducts();
            }
        });

        prevKategoriButton.addEventListener('click', function(e) {
            e.preventDefault();
            kategoriItems.scrollBy({
                left: -200,
                behavior: 'smooth'
            });
        });

        nextKategoriButton.addEventListener('click', function(e) {
            e.preventDefault();
            kategoriItems.scrollBy({
                left: 200,
                behavior: 'smooth'
            });
        });

        kategoriItems.addEventListener('scroll', updateButtonVisibility);
        window.addEventListener('resize', updateButtonVisibility);

        // Load products on page load
        updateProducts();

        // Initialize cart functionality
        initializeCart();
    });
</script>
