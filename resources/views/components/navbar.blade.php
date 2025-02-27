<nav class="bg-transparent shadow-sm border-b" x-data="{ isOpen: false }">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <div class="shrink-0">
                <a href="/">
                    <img class="size-8" src="{{ asset('storage/images/logo.png') }}" alt="Your Company">
                </a>
            </div>
            <div class="flex items-center">
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <a href="/"
                            class="{{ request()->is('/') ? 'underline decoration-2 text-black' : 'text-black hover:underline hover:decoration-2' }} rounded-md px-3 py-2 text-sm font-medium"
                            aria-current="{{ request()->is('/') ? 'page' : false }}">Beranda</a>
                        <a href="/shop"
                            class="{{ request()->is('shop') ? 'underline decoration-2 text-black' : 'text-black hover:underline hover:decoration-2' }} rounded-md px-3 py-2 text-sm font-medium"
                            aria-current="{{ request()->is('shop') ? 'page' : false }}">Belanja</a>
                        <a href="/contact"
                            class="{{ request()->is('contact') ? 'underline decoration-2 text-black' : 'text-black hover:underline hover:decoration-2' }} rounded-md px-3 py-2 text-sm font-medium"
                            aria-current="{{ request()->is('contact') ? 'page' : false }}">Kontak</a>
                    </div>
                </div>
            </div>
            <div class="hidden md:block">
                <div class="flex justify-end gap-6">
                    @guest
                        <!-- Navbar Cart Component -->
                        <div class="Basket relative">
                            <div class="relative">
                                <x-fas-basket-shopping width="30" height="30" data-modal-target="static-modal"
                                    data-modal-toggle="static-modal"
                                    class="border border-black p-1 rounded-full cursor-pointer" />
                                <span id="cart-count"
                                    class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full size-5 flex items-center justify-center">
                                    {{ array_sum(array_column(session('cart', []), 'quantity')) }}
                                </span>
                            </div>

                            <!-- Cart Modal -->
                            <div id="static-modal" tabindex="-1" aria-hidden="true"
                                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                <div class="relative p-4 w-full max-w-2xl max-h-full">
                                    <!-- Modal content -->
                                    <div class="relative rounded-lg shadow bg-white">
                                        <!-- Modal header -->
                                        <div class="flex items-center justify-between  p-4 md:p-5 border-b rounded-t ">
                                            <h3 class="text-xl font-semibold">
                                                Keranjang Belanja
                                            </h3>
                                            <button type="button"
                                                class="rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                                data-modal-hide="static-modal">
                                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                    fill="none" viewBox="0 0 14 14">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                </svg>
                                                <span class="sr-only">Close modal</span>
                                            </button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="p-4 md:p-5 space-y-4 ">
                                            <!-- Cart items will be loaded here via AJAX -->
                                            <div class="text-center">
                                                <p>Loading cart contents...</p>
                                            </div>
                                        </div>
                                        <!-- Modal footer -->
                                        <div class="flex flex-col gap-4 p-4 md:p-5  border-t rounded-b">
                                            <div class="flex justify-between items-center">
                                                <span class="text-lg font-semibold">Total:</span>
                                                <span id="cart-total" class="text-lg font-bold">Rp0</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <button type="button" id="clear-cart-button"
                                                    class="py-2.5 px-5 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:ring-red-300">
                                                    Hapus Semua
                                                </button>
                                                <button type="button" id="checkout-button"
                                                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                                    Checkout
                                                </button>
                                            </div>
                                       </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Success & Error Popup -->
                            <div id="cart-popup"
                                class="fixed bottom-4 right-4 px-4 py-2 rounded-lg transition-opacity duration-300 hidden">
                            </div>
                        </div>
                        @if (Route::has('login'))
                            <a class="nav-link" href="{{ route('login') }}">
                                <x-fas-user width="30" height="30" class="border border-black p-1 rounded-full " />
                            </a>
                        @endif
                    @else
                        @if (Auth::user()->role_id == 5)
                            <!-- Navbar Cart Component -->
                            <div class="Basket relative">
                                <div class="relative">
                                    <x-fas-basket-shopping width="30" height="30" data-modal-target="static-modal"
                                        data-modal-toggle="static-modal"
                                        class="border border-black p-1 rounded-full cursor-pointer" />
                                    <span id="cart-count"
                                        class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full size-5 flex items-center justify-center">
                                        {{ array_sum(array_column(session('cart', []), 'quantity')) }}
                                    </span>
                                </div>

                                <!-- Cart Modal -->
                                <div id="static-modal" tabindex="-1" aria-hidden="true"
                                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                    <div class="relative p-4 w-full max-w-2xl max-h-full">
                                        <!-- Modal content -->
                                        <div class="relative rounded-lg bg-white shadow">
                                            <!-- Modal header -->
                                            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t ">
                                                <h3 class="text-xl font-semibold">
                                                    Keranjang Belanja
                                                </h3>
                                                <button type="button"
                                                    class="rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                                    data-modal-hide="static-modal">
                                                    <svg class="w-3 h-3" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 14 14">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                    </svg>
                                                    <span class="sr-only">Close modal</span>
                                                </button>
                                            </div>
                                            <!-- Modal body -->
                                            <div class="p-4 md:p-5 space-y-4">
                                                <!-- Cart items will be loaded here via AJAX -->
                                                <div class="text-center">
                                                    <p>Loading cart contents...</p>
                                                </div>
                                            </div>
                                            <!-- Modal footer -->
                                            <div class="flex flex-col gap-4 p-4 md:p-5 border-t rounded-b">
                                                <div class="flex justify-between items-center">
                                                    <span class="text-lg font-semibold">Total:</span>
                                                    <span id="cart-total" class="text-lg font-bold">Rp0</span>
                                                </div>
                                                <div class="flex justify-between">
                                                    <button type="button" id="clear-cart-button"
                                                        class="py-2.5 px-5 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:ring-red-300">
                                                        Hapus Semua
                                                    </button>
                                                    <button type="button" id="checkout-button"
                                                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                                        Checkout
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Success popup animation -->
                                <div id="cart-popup"
                                    class="fixed bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg transition-opacity duration-300 hidden">
                                </div>
                            </div>
                        @endif
                        <button id="dropdownInformationButton" data-dropdown-toggle="dropdownInformation" class=""
                            type="button">
                            <x-fas-user width="30" height="30" class="border border-black p-1 rounded-full " />
                        </button>

                        <!-- Dropdown menu -->
                        <div id="dropdownInformation"
                            class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700 dark:divide-gray-600">
                            <div class="px-4 py-3 text-sm text-gray-900 dark:text-white">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="font-medium truncate">{{ Auth::user()->email }}</div>
                            </div>
                            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                                aria-labelledby="dropdownInformationButton">
                                <li>
                                    <a href="
                                    @if (Auth::user()->role_id == 5) user
                                        @else
                                        admin @endif
                                    "
                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Dashboard</a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Settings</a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Earnings</a>
                                </li>
                            </ul>
                            <div class="block px-4 py-2 text-sm text-gray-700 hover:rounded-b-lg hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white"
                                aria-labelledby="navbarDropdown">
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    class="d-none cursor-pointer w-full">
                                    <button class="w-full text-red-600" type="submit">
                                        {{ __('Logout') }}
                                    </button>
                                    @csrf
                                </form>
                            </div>
                        </div>
                    @endguest
                </div>
            </div>

            <div class="-mr-2 flex md:hidden">
                <!-- Mobile menu button -->
                <button type="button" @click="isOpen = !isOpen"
                    class="relative inline-flex items-center justify-center rounded-md bg-gray-800 p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800"
                    aria-controls="mobile-menu" aria-expanded="false">
                    <span class="absolute -inset-0.5"></span>
                    <span class="sr-only">Open main menu</span>
                    <!-- Menu open: "hidden", Menu closed: "block" -->
                    <svg :class="{ 'hidden': isOpen, 'block': !isOpen }" class="block size-6" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"
                        data-slot="icon">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.30h16.5" />
                    </svg>
                    <!-- Menu open: "block", Menu closed: "hidden" -->
                    <svg :class="{ 'block': isOpen, 'hidden': !isOpen }" class="hidden size-6" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"
                        data-slot="icon">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu, show/hide based on menu state. -->
    <div x-show="isOpen" class="md:hidden" id="mobile-menu">
        <div class="space-y-1 px-2 pb-3 pt-2 sm:px-3">
            <a href="/"
                class="{{ request()->is('/') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} rounded-md px-3 py-2 text-sm font-medium"
                aria-current="{{ request()->is('/') ? 'page' : false }}">Beranda</a>
            <a href="/about"
                class="{{ request()->is('about') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} rounded-md px-3 py-2 text-sm font-medium"
                aria-current="{{ request()->is('about') ? 'page' : false }}">Tentang Kami</a>
            <a href="/catalogue"
                class="{{ request()->is('catalogue') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} rounded-md px-3 py-2 text-sm font-medium"
                aria-current="{{ request()->is('catalogue') ? 'page' : false }}">Katalog</a>
        </div>
        <div class="md:hidden">
            <div class="Order_obat py-1 px-2 rounded-md border text-white border-[#4e1111] bg-[#be2121]">
                <a href="/order">Pesan Obat</a>
            </div>
        </div>
    </div>
</nav>

<style>
    #cart-popup {
        transition: opacity 0.3s ease-in-out, transform 0.3s ease-in-out;
        transform: translateY(-10px);
        opacity: 0;
        z-index: 1000;
        pointer-events: none;
    }

    #cart-popup.opacity-100 {
        opacity: 1;
        transform: translateY(0);
    }

    /* Button state changes */
    .add-to-cart.bg-green-500 {
        background-color: rgb(34, 197, 94);
        transition: background-color 0.3s ease;
    }

    /* Animation for newly added items in cart */
    @keyframes highlight {
        0% {
            background-color: rgba(34, 197, 94, 0.2);
        }

        100% {
            background-color: transparent;
        }
    }

    .cart-item-new {
        animation: highlight 2s ease-out forwards;
    }
</style>
