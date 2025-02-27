@extends('layouts.app')

@section('content')
<div class="mx-auto p-4 lg:p-6">
    <div class="relative mb-12">
        <!-- Background element -->
        <div class="absolute inset-0 bg-gradient-to-r from-cyan-400/65 via-white to-lime-400/65 opacity-80 rounded-2xl shadow-2xl transform -skew-y-1"></div>
        
        <!-- Hero title -->
        <div class="relative py-12 px-6 text-center">
            <h1 class="text-3xl md:text-4xl font-extrabold text-white mb-2 tracking-tight">
                <span class="bg-clip-text text-transparent bg-gradient-to-r from-cyan-400 to-lime-400">
                    Pharmacy of the Future
                </span>
            </h1>
            <p class="text-cyan-800 text-lg max-w-2xl mx-auto">
                Discover innovative healthcare solutions for your wellness journey
            </p>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-slate-900 backdrop-blur-xl rounded-2xl shadow-xl border border-slate-800 p-5 mb-8 relative overflow-hidden">
        <!-- Decorative element -->
        <div class="absolute -right-10 -top-10 w-40 h-40 bg-cyan-400 rounded-full opacity-10"></div>
        <div class="absolute -left-10 -bottom-10 w-40 h-40 bg-lime-400 rounded-full opacity-10"></div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 relative z-10">
            <!-- Search Filter -->
            <div class="relative group">
                <div class="absolute inset-y-0 start-0 flex items-center ps-4 pointer-events-none">
                    <svg class="w-4 h-4 text-cyan-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
                <input type="text" id="search"
                    class="block w-full p-4 ps-10 text-gray-200 border-0 rounded-xl bg-slate-800/70 backdrop-blur-sm focus:ring-cyan-400 focus:border-cyan-400 transition-all duration-300 placeholder:text-slate-400"
                    placeholder="Search medicines...">
                <div class="absolute bottom-0 left-0 h-0.5 w-0 bg-cyan-400 transition-all duration-300 group-focus-within:w-full"></div>
            </div>

            <!-- Price Range Filter -->
            <div class="relative group">
                <select id="price_range"
                    class="block w-full p-4 text-gray-200 border-0 rounded-xl bg-slate-800/70 backdrop-blur-sm focus:ring-cyan-400 focus:border-cyan-400 transition-all duration-300 appearance-none">
                    <option value="">Price Range</option>
                    <option value="0-50000">Rp0 - Rp50.000</option>
                    <option value="50000-100000">Rp50.000 - Rp100.000</option>
                    <option value="100000-200000">Rp100.000 - Rp200.000</option>
                    <option value="200000-500000">Rp200.000 - Rp500.000</option>
                    <option value="500000-1000000">Rp500.000 - Rp1.000.000</option>
                    <option value="1000000-">Above Rp1.000.000</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                    <svg class="w-4 h-4 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>
                <div class="absolute bottom-0 left-0 h-0.5 w-0 bg-cyan-400 transition-all duration-300 group-focus-within:w-full"></div>
            </div>

            <!-- Availability Filter -->
            <div class="relative group">
                <select id="availability"
                    class="block w-full p-4 text-gray-200 border-0 rounded-xl bg-slate-800/70 backdrop-blur-sm focus:ring-cyan-400 focus:border-cyan-400 transition-all duration-300 appearance-none">
                    <option value="">Availability</option>
                    <option value="1">Available</option>
                    <option value="0">Out of Stock</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                    <svg class="w-4 h-4 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>
                <div class="absolute bottom-0 left-0 h-0.5 w-0 bg-cyan-400 transition-all duration-300 group-focus-within:w-full"></div>
            </div>

            <!-- Reset Filter Button -->
            <button id="resetFilters"
                class="relative overflow-hidden text-white font-medium rounded-xl p-4 transition-all duration-300 
                bg-gradient-to-r from-cyan-500 to-lime-500 hover:from-cyan-400 hover:to-lime-400 
                transform hover:scale-105 hover:shadow-lg">
                <span class="relative z-10 flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    Reset Filters
                </span>
            </button>
        </div>
    </div>

    <!-- Categories Section -->
    <div class="relative mb-8">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold text-black">Categories:</h2>
            <div class="hidden md:flex space-x-2">
                <button type="button" id="prevKategori"
                    class="bg-slate-800 text-cyan-400 p-2 rounded-full shadow-lg hover:bg-slate-700 transition-all duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button type="button" id="nextKategori"
                    class="bg-slate-800 text-cyan-400 p-2 rounded-full shadow-lg hover:bg-slate-700 transition-all duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>

        <div class="relative">
            <div id="kategoriCarousel" class="overflow-hidden">
                <div id="kategoriItems" class="flex space-x-3 transition-all duration-300 p-2">
                    @foreach ($kategoris as $kategori)
                        <div class="category-item group relative cursor-pointer"
                            data-kategori-id="{{ $kategori->id }}">
                            <div
                                class="flex flex-col items-center p-4 bg-slate-800/70 backdrop-blur-sm rounded-xl shadow-md 
                                border border-slate-700/50 transition-all duration-300 hover:shadow-cyan-400/20 
                                hover:border-cyan-400/30 hover:bg-slate-700">
                                <div class="w-12 h-12 bg-gradient-to-br from-cyan-400 to-lime-400 rounded-full 
                                    flex items-center justify-center mb-2 shadow-inner">
                                    <span
                                        class="text-lg font-bold text-white">{{ substr($kategori->nama, 0, 1) }}</span>
                                </div>
                                <span class="text-sm font-medium text-gray-200">{{ $kategori->nama }}</span>
                                <div
                                    class="category-indicator hidden absolute -top-1 -right-1 w-3 h-3 bg-cyan-400 rounded-full 
                                    shadow-lg shadow-cyan-400/50 animate-pulse">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Cart Popup -->
    <div id="cart-popup"
        class="fixed top-4 right-4 bg-gradient-to-r from-cyan-500 to-lime-500 border-l-4 border-cyan-300 
        text-white p-4 shadow-lg rounded-lg hidden opacity-0 transition-opacity duration-300 
        backdrop-blur-lg z-50">
    </div>

    <!-- Loading indicator -->
    <div id="loading-indicator" class="hidden fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center">
        <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-b-4 border-cyan-400"></div>
    </div>

    <!-- Products Grid -->
    <div class="mb-8">
        <div id="productsContainer" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 lg:gap-6">
            <!-- Products will be loaded here -->
        </div>

        <!-- Pagination -->
        <div class="mt-8" id="pagination">
            <!-- Pagination will be loaded here -->
        </div>
    </div>
</div>
@endsection

<style>
    .category-item {
        min-width: 120px;
    }

    /* Hide scrollbar but allow scrolling */
    #kategoriItems {
        overflow-x: auto;
        scroll-behavior: smooth;
        scrollbar-width: none; /* Firefox */
    }

    #kategoriItems::-webkit-scrollbar {
        display: none; /* Chrome, Safari, Edge */
    }

    /* Futuristic glow effects */
    .glow-effect {
        box-shadow: 0 0 10px rgba(34, 211, 238, 0.5), 0 0 20px rgba(34, 211, 238, 0.3);
    }

    .glow-text {
        text-shadow: 0 0 5px rgba(34, 211, 238, 0.7);
    }

    /* Custom animation for product cards */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translate3d(0, 20px, 0);
        }
        to {
            opacity: 1;
            transform: translate3d(0, 0, 0);
        }
    }

    .animate-fadeInUp {
        animation: fadeInUp 0.5s ease-out forwards;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize state
        let activeFilters = {
            search: '',
            kategori_id: '',
            harga_min: '',
            harga_max: '',
            availability: ''
        };

        // Cache DOM elements
        const productsContainer = document.getElementById('productsContainer');
        const paginationContainer = document.getElementById('pagination');
        const searchInput = document.getElementById('search');
        const priceRangeSelect = document.getElementById('price_range');
        const availabilitySelect = document.getElementById('availability');
        const resetButton = document.getElementById('resetFilters');
        const kategoriItems = document.getElementById('kategoriItems');
        const prevKategoriButton = document.getElementById('prevKategori');
        const nextKategoriButton = document.getElementById('nextKategori');
        const loadingIndicator = document.getElementById('loading-indicator');

        // Get CSRF token for AJAX requests
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        // Price range mapping
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

        // Debounce function to limit API calls
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

        // Update products with filtering
        const updateProducts = debounce(async () => {
            try {
                // Build query parameters
                const queryParams = new URLSearchParams();
                if (activeFilters.search) queryParams.set('search', activeFilters.search);
                if (activeFilters.kategori_id) queryParams.set('kategori_id', activeFilters.kategori_id);
                if (activeFilters.harga_min) queryParams.set('harga_min', activeFilters.harga_min);
                if (activeFilters.harga_max) queryParams.set('harga_max', activeFilters.harga_max);
                if (activeFilters.availability) queryParams.set('availability', activeFilters.availability);

                // Show loading indicator
                loadingIndicator.classList.remove('hidden');
                
                // Fetch filtered data
                const response = await fetch(`/shop/filter?${queryParams.toString()}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                if (!response.ok) throw new Error('Network response was not ok');

                const data = await response.json();

                // Update DOM with new data
                productsContainer.innerHTML = data.html;
                paginationContainer.innerHTML = data.pagination || '';

                // Update URL without page reload
                window.history.pushState({}, '', `${window.location.pathname}?${queryParams.toString()}`);

                // Add animation to products
                const productElements = productsContainer.querySelectorAll('.product-card');
                productElements.forEach((el, index) => {
                    el.style.animationDelay = `${index * 0.05}s`;
                    el.classList.add('animate-fadeInUp');
                });

                // Re-setup cart event listeners after content update
                setupCartEventListeners();
            } catch (error) {
                console.error('Error updating products:', error);
            } finally {
                // Hide loading indicator
                loadingIndicator.classList.add('hidden');
            }
        }, 300);

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

            // Pagination links
            document.querySelectorAll('.pagination a').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    let url = new URL(this.href);
                    
                    // Merge current filters with pagination
                    for (let key in activeFilters) {
                        if (activeFilters[key]) {
                            url.searchParams.set(key, activeFilters[key]);
                        }
                    }
                    
                    fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        productsContainer.innerHTML = data.html;
                        paginationContainer.innerHTML = data.pagination || '';
                        window.history.pushState({}, '', url);
                        setupCartEventListeners();
                    })
                    .catch(error => console.error('Error:', error));
                });
            });
        }

        // Initialize cart functionality
        function initializeCart() {
            // Get current cart items count
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
                })
                .catch(error => console.error('Error fetching cart:', error));

            setupCartEventListeners();
        }

        // Cart event handlers
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

        // UI helper functions
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

        // Category navigation
        function updateButtonVisibility() {
            prevKategoriButton.style.display = kategoriItems.scrollLeft > 0 ? 'block' : 'none';
            nextKategoriButton.style.display =
                kategoriItems.scrollLeft + kategoriItems.clientWidth < kategoriItems.scrollWidth - 10 ?
                'block' :
                'none';
        }

        // Event listeners
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

        // Handle category filter selection
        kategoriItems.addEventListener('click', function(e) {
            const categoryItem = e.target.closest('.category-item');
            if (categoryItem) {
                const kategoriId = categoryItem.dataset.kategoriId;
                const indicator = categoryItem.querySelector('.category-indicator');

                // If same category clicked again, reset filter
                if (activeFilters.kategori_id === kategoriId) {
                    activeFilters.kategori_id = '';
                    categoryItem.querySelector('.category-indicator').classList.add('hidden');
                } else {
                    activeFilters.kategori_id = kategoriId;

                    // Reset all other categories
                    document.querySelectorAll('.category-item').forEach((item) => {
                        item.querySelector('.category-indicator').classList.add('hidden');
                    });

                    // Mark selected category
                    indicator.classList.remove('hidden');
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

        // Initialize
        updateButtonVisibility();
        updateProducts();
        initializeCart();
    });
</script>