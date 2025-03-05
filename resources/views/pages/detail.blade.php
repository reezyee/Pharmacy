@extends('layouts.app')

@section('content')
<div class="mx-auto p-4 lg:p-6">
    <!-- Breadcrumb -->
    <nav class="flex mb-5" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3 text-sm">
            <li class="inline-flex items-center">
                <a href="{{ url('/') }}" class="inline-flex items-center text-cyan-400 hover:text-cyan-300">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                    </svg>
                    Home
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <a href="{{ url('/shop') }}" class="ml-1 text-cyan-400 hover:text-cyan-300 md:ml-2">Shop</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="ml-1 text-gray-400 md:ml-2 line-clamp-1">{{ $obat->nama }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Cart Popup -->
    <div id="cart-popup"
        class="fixed top-4 right-4 bg-gradient-to-r from-lime-600 to-cyan-600 border-l-4 border-lime-400 
         p-4 shadow-lg rounded-lg hidden opacity-0 transition-opacity duration-300 
        backdrop-blur-lg z-50">
    </div>

    <!-- Product Detail Section -->
    <div class="bg-slate=100 backdrop-blur-xl rounded-2xl shadow-xl border border-slate-200 overflow-hidden">
        <div class="relative">
            <!-- Decorative elements -->
            <div class="absolute -left-20 -top-20 w-40 h-40 bg-cyan-500 rounded-full opacity-10"></div>
            <div class="absolute -right-20 -bottom-20 w-40 h-40 bg-lime-500 rounded-full opacity-10"></div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-6 relative z-10">
                <!-- Product Image -->
                <div class="flex flex-col items-center justify-center">
                    <div class="w-full aspect-square bg-gradient-to-br from-slate-800 to-slate-700 rounded-xl flex items-center justify-center overflow-hidden p-6 shadow-lg">
                        @if($obat->foto)
                            <img 
                                src="{{ asset('storage/' . $obat->foto) }}" 
                                alt="{{ $obat->nama }}" 
                                class="max-w-full max-h-full object-contain"
                            >
                        @else
                            <div class="w-40 h-40 bg-gradient-to-br from-cyan-500 to-lime-500 rounded-full flex items-center justify-center shadow-inner">
                                <span class="text-4xl font-bold ">{{ substr($obat->nama, 0, 1) }}</span>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Category & Availability Badge -->
                    <div class="flex items-center justify-center space-x-3 mt-4">
                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-cyan-900/50 text-cyan-400 border border-cyan-700">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                            </svg>
                            {{ $obat->kategori->nama }}
                        </span>
                        
                        @if($obat->is_available)
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-lime-900/50 text-lime-400 border border-lime-700">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Available
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-red-900/50 text-red-300 border border-red-700">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Out of Stock
                            </span>
                        @endif
                    </div>
                </div>
                
                <!-- Product Info -->
                <div class="flex flex-col">
                    <h1 class="text-2xl md:text-3xl font-bold  mb-2">{{ $obat->nama }}</h1>
                    
                    <!-- Price -->
                    <div class="mt-2 mb-4">
                        <span class="text-3xl font-bold ">
                            Rp{{ number_format($obat->harga, 0, ',', '.') }}
                        </span>
                    </div>
                    
                    <!-- Specs -->
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div class="bg-slate-200/70 p-3 rounded-lg border border-slate-700/50">
                            <span class="text-sm text-slate-400">Type</span>
                            <p class="text-slate-800 font-medium">{{ $obat->jenisObat->nama_jenis_obat }}</p>
                        </div>
                        <div class="bg-slate-200/70 p-3 rounded-lg border border-slate-700/50">
                            <span class="text-sm text-slate-400">Form</span>
                            <p class="text-slate-800 font-medium">{{ $obat->bentukObat->nama_bentuk_obat }}</p>
                        </div>
                        <div class="bg-slate-200/70 p-3 rounded-lg border border-slate-700/50">
                            <span class="text-sm text-slate-400">Stock</span>
                            <p class="text-slate-800 font-medium">{{ $obat->banyak }} units</p>
                        </div>
                        <div class="bg-slate-200/70 p-3 rounded-lg border border-slate-700/50">
                            <span class="text-sm text-slate-400">Nomer Izin Edar</span>
                            <p class="text-slate-800 font-medium">{{ $obat->nie }}</p>
                        </div>
                        <div class="bg-slate-200/70 p-3 rounded-lg border border-slate-700/50">
                            <span class="text-sm text-slate-400">Composition</span>
                            <p class="text-slate-800 font-medium">{{ $obat->komposisi_obat }}</p>
                        </div>
                        <div class="bg-slate-200/70 p-3 rounded-lg border border-slate-700/50">
                            <span class="text-sm text-slate-400">Mass</span>
                            <p class="text-slate-800 font-medium">{{ $obat->kekuatan_obat }}</p>
                        </div>
                        <div class="bg-slate-200/70 p-3 rounded-lg border border-slate-700/50">
                            <span class="text-sm text-slate-400">Dosage</span>
                            <p class="text-slate-800 font-medium">{{ $obat->dosis_obat }}</p>
                        </div>
                    </div>
                    
                    <!-- Add to Cart Section -->
                    <div class="mt-auto">
                        @if($obat->is_available)
                            <!-- Add to cart button -->
                            <button 
                                id="tambah-keranjang-{{ $obat->id }}" 
                                data-id="{{ $obat->id }}"
                                class="w-full relative overflow-hidden  font-medium rounded-xl p-4 transition-all duration-300 
                                bg-gradient-to-r from-cyan-600 to-lime-600 hover:from-cyan-500 hover:to-lime-500 
                                transform hover:scale-105 hover:shadow-lg"
                            >
                                <span class="relative z-10 flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    Add to Cart
                                </span>
                            </button>
                            
                            <!-- Quantity controls (hidden by default) -->
                            <div 
                                id="quantity-controls-{{ $obat->id }}" 
                                class="hidden w-full bg-slate-100 rounded-xl border border-slate-700 overflow-hidden"
                            >
                                <div class="flex items-center justify-between">
                                    <button 
                                        id="kurangi-{{ $obat->id }}" 
                                        class="p-4  hover:bg-slate-700 transition-colors duration-200 flex-none"
                                    >
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                        </svg>
                                    </button>
                                    
                                    <input 
                                        type="number" 
                                        id="quantity-{{ $obat->id }}" 
                                        class="w-16 text-center bg-transparent  border-0 focus:ring-0" 
                                        value="1" 
                                        min="1" 
                                        readOnly
                                    >
                                    
                                    <button 
                                        id="tambah-{{ $obat->id }}" 
                                        class="p-4  hover:bg-slate-700 transition-colors duration-200 flex-none"
                                    >
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        @else
                            <button class="w-full bg-slate-800 text-slate-400 font-medium rounded-xl p-4 cursor-not-allowed" disabled>
                                <span class="flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Out of Stock
                                </span>
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Description Section -->
        <div class="border-t border-slate-800 p-6">
            <h2 class="text-xl font-bold  mb-4">Description</h2>
            <div class="bg-slate-200/70 rounded-xl p-5 backdrop-blur-sm">
                <div class="prose prose-invert prose-cyan max-w-none">
                    {!! $obat->deskripsi_obat !!}
                </div>
            </div>
        </div>
        
        <!-- Usage & Caution Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-t border-slate-800 p-6">
            <!-- Usage Info -->
            <div>
                <h3 class="flex items-center text-lg font-bold  mb-3">
                    <svg class="w-5 h-5 mr-2 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Usage Information
                </h3>
                <div class="bg-slate-200/70 rounded-xl p-4 backdrop-blur-sm">
                    <ul class="space-y-2">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 mr-2 text-cyan-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Follow the dosage instructions provided by your healthcare provider or as indicated on the packaging.</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 mr-2 text-cyan-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Keep this medicine in its original container, tightly closed, and out of reach of children.</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 mr-2 text-cyan-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Store at room temperature away from moisture, heat, and direct light.</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Caution Info -->
            <div>
                <h3 class="flex items-center text-lg font-bold  mb-3">
                    <svg class="w-5 h-5 mr-2 text-lime-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    Caution & Side Effects
                </h3>
                <div class="bg-slate-200/70 rounded-xl p-4 backdrop-blur-sm">
                    <ul class="space-y-2">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 mr-2 text-lime-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            <span>Consult with a healthcare professional before use if you have any medical conditions or are taking other medications.</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 mr-2 text-lime-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            <span>Discontinue use and seek medical attention if you experience any adverse reactions or side effects.</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 mr-2 text-lime-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            <span>Keep out of reach of children. In case of accidental ingestion, seek medical help immediately.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get CSRF token for AJAX requests
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        
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
                            if (item.obat_id == {{ $obat->id }}) {
                                showQuantityControls(item.obat_id, item.quantity);
                            }
                        });
                    }
                })
                .catch(error => console.error('Error fetching cart:', error));

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

        // Initialize
        initializeCart();
    });
</script>
@endsection