<!-- Sidebar -->
<aside id="sidebar"
    class="fixed left-0 w-64 top-0 h-full bg-white shadow-lg transition-all duration-300 ease-in-out z-10 flex flex-col">
    {{-- Profile Section --}}
    <div class="flex items-center justify-center flex-col pt-8 pb-6 border-b border-gray-100 mx-4">
        @php
            $role = Auth::user()->role->name ?? 'Pelanggan';
            $roleColors = [
                'Admin' => [
                    'bg' => 'bg-purple-100',
                    'text' => 'text-purple-700',
                    'border' => 'border-purple-500',
                    'avatar_bg' => 'd8b4fe',
                    'avatar_text' => '6b21a8',
                    'icon' => 'text-purple-600',
                ],
                'Apoteker' => [
                    'bg' => 'bg-green-100',
                    'text' => 'text-green-700',
                    'border' => 'border-green-500',
                    'avatar_bg' => 'a3e635',
                    'avatar_text' => '166534',
                    'icon' => 'text-green-600',
                ],
                'Dokter' => [
                    'bg' => 'bg-blue-100',
                    'text' => 'text-blue-700',
                    'border' => 'border-blue-500',
                    'avatar_bg' => '93c5fd',
                    'avatar_text' => '1e3a8a',
                    'icon' => 'text-blue-600',
                ],
                'Kasir' => [
                    'bg' => 'bg-orange-100',
                    'text' => 'text-orange-700',
                    'border' => 'border-orange-500',
                    'avatar_bg' => 'fdba74',
                    'avatar_text' => '9a3412',
                    'icon' => 'text-orange-600',
                ],
                'Pelanggan' => [
                    'bg' => 'bg-gray-100',
                    'text' => 'text-gray-700',
                    'border' => 'border-gray-500',
                    'avatar_bg' => 'd1d5db',
                    'avatar_text' => '374151',
                    'icon' => 'text-gray-600',
                ],
            ];
            $colors = $roleColors[$role] ?? $roleColors['Pelanggan'];
        @endphp

        <div
            class="w-20 h-20 rounded-full overflow-hidden shadow-md mb-3 ring-2 ring-opacity-50 {{ $colors['border'] }}">
            <img id="avatarPreview"
                src="{{ Auth::user()->avatar
                    ? asset('storage/' . Auth::user()->avatar)
                    : 'https://ui-avatars.com/api/?name=' .
                        urlencode(Auth::user()->name) .
                        '&background=' .
                        $colors['avatar_bg'] .
                        '&color=' .
                        $colors['avatar_text'] }}"
                alt="Profile Picture" class="w-full h-full rounded-full object-cover" />
        </div>
        <div class="text-center">
            <h2 class="text-lg font-semibold leading-tight">{{ Auth::user()->name }}</h2>
            <span
                class="px-2.5 py-0.5 text-xs font-medium rounded-full mt-1 inline-block {{ $colors['bg'] }} {{ $colors['text'] }}">
                {{ $role }}
            </span>
            <p class="text-sm text-gray-500 mt-1">{{ Auth::user()->email }}</p>
        </div>
    </div>

    {{-- Navigation Menu --}}
    <nav class="flex-1 overflow-y-auto py-4 px-3 scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
        <ul class="space-y-1">
            @if (Auth::user()->role_id === 5)
                {{-- Customer Menu --}}
                <li>
                    <a href="/user"
                        class="flex items-center p-2.5 rounded-lg text-gray-700 hover:bg-gray-100 group transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="{{ $colors['icon'] }} w-5 h-5 transition-all duration-200" viewBox="0 -960 960 960"
                            fill="currentColor">
                            <path
                                d="M520-600v-240h320v240H520ZM120-440v-400h320v400H120Zm400 320v-400h320v400H520Zm-400 0v-240h320v240H120Z" />
                        </svg>
                        <span class="ml-3 font-medium">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="/user/resep"
                        class="flex items-center p-2.5 rounded-lg text-gray-700 hover:bg-gray-100 group transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="{{ $colors['icon'] }} w-5 h-5 transition-all duration-200" viewBox="0 -960 960 960"
                            fill="currentColor">
                            <path
                                d="M320-280q17 0 28.5-11.5T360-320q0-17-11.5-28.5T320-360q-17 0-28.5 11.5T280-320q0 17 11.5 28.5T320-280Zm0-160q17 0 28.5-11.5T360-480q0-17-11.5-28.5T320-520q-17 0-28.5 11.5T280-480q0 17 11.5 28.5T320-440Zm0-160q17 0 28.5-11.5T360-640q0-17-11.5-28.5T320-680q-17 0-28.5 11.5T280-640q0 17 11.5 28.5T320-600Zm120 320h240v-80H440v80Zm0-160h240v-80H440v80Zm0-160h240v-80H440v80ZM200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Z" />
                        </svg>
                        <span class="ml-3 font-medium">Recipes</span>
                    </a>
                </li>
                <li>
                    <a href="/upload-resep"
                        class="flex items-center p-2.5 rounded-lg text-gray-700 hover:bg-gray-100 group transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="{{ $colors['icon'] }} w-5 h-5 transition-all duration-200" viewBox="0 -960 960 960"
                            fill="currentColor">
                            <path
                                d="M440-200h80v-167l64 64 56-57-160-160-160 160 57 56 63-63v167ZM240-80q-33 0-56.5-23.5T160-160v-640q0-33 23.5-56.5T240-880h320l240 240v480q0 33-23.5 56.5T720-80H240Zm280-520v-200H240v640h480v-440H520ZM240-800v200-200 640-640Z" />
                        </svg>
                        <span class="ml-3 font-medium">Upload Recipes</span>
                    </a>
                </li>
                <li>
                    <a href="/user/pesanan"
                        class="flex items-center p-2.5 rounded-lg text-gray-700 hover:bg-gray-100 group transition-all duration-200">
                        <svg class="{{ $colors['icon'] }} w-5 h-5 transition-all duration-200" fill="currentColor"
                            viewBox="0 0 18 21" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M15 12a1 1 0 0 0 .962-.726l2-7A1 1 0 0 0 17 3H3.77L3.175.745A1 1 0 0 0 2.208 0H1a1 1 0 0 0 0 2h.438l.6 2.255v.019l2 7 .746 2.986A3 3 0 1 0 9 17a2.966 2.966 0 0 0-.184-1h2.368c-.118.32-.18.659-.184 1a3 3 0 1 0 3-3H6.78l-.5-2H15Z" />
                        </svg>
                        <span class="ml-3 font-medium">Orders</span>
                    </a>
                </li>
                <li>
                    <a href="/user/chat"
                        class="flex items-center p-2.5 rounded-lg text-gray-700 hover:bg-gray-100 group transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="{{ $colors['icon'] }} w-5 h-5 transition-all duration-200" viewBox="0 -960 960 960"
                            fill="currentColor">
                            <path
                                d="M240-400h320v-80H240v80Zm0-120h480v-80H240v80Zm0-120h480v-80H240v80ZM80-80v-720q0-33 23.5-56.5T160-880h640q33 0 56.5 23.5T880-800v480q0 33-23.5 56.5T800-240H240L80-80Zm126-240h594v-480H160v525l46-45Zm-46 0v-480 480Z" />
                        </svg>
                        <span class="ml-3 font-medium">Chat</span>
                    </a>
                </li>
                <li>
                    <a href="/user/setting"
                        class="flex items-center p-2.5 rounded-lg text-gray-700 hover:bg-gray-100 group transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="{{ $colors['icon'] }} w-5 h-5 transition-all duration-200" viewBox="0 -960 960 960"
                            fill="currentColor">
                            <path
                                d="m370-80-16-128q-13-5-24.5-12T307-235l-119 50L78-375l103-78q-1-7-1-13.5v-27q0-6.5 1-13.5L78-585l110-190 119 50q11-8 23-15t24-12l16-128h220l16 128q13 5 24.5 12t22.5 15l119-50 110 190-103 78q1 7 1 13.5v27q0 6.5-2 13.5l103 78-110 190-118-50q-11 8-23 15t-24 12L590-80H370Zm112-260q58 0 99-41t41-99q0-58-41-99t-99-41q-59 0-99.5 41T342-480q0 58 40.5 99t99.5 41Z" />
                        </svg>
                        <span class="ml-3 font-medium">Settings</span>
                    </a>
                </li>
            @else
                @php
                    $role = Auth::user()->role->name;
                @endphp

                {{-- Admin/Staff Menu --}}
                <li>
                    <a href="/admin"
                        class="flex items-center p-2.5 rounded-lg text-gray-700 hover:bg-gray-100 group transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="{{ $colors['icon'] }} w-5 h-5 transition-all duration-200" viewBox="0 -960 960 960"
                            fill="currentColor">
                            <path
                                d="M520-600v-240h320v240H520ZM120-440v-400h320v400H120Zm400 320v-400h320v400H520Zm-400 0v-240h320v240H120Z" />
                        </svg>
                        <span class="ml-3 font-medium">Dashboard</span>
                    </a>
                </li>

                @if (in_array($role, ['Admin', 'Apoteker']))
                    <li>
                        <a href="/admin/obat"
                            class="flex items-center p-2.5 rounded-lg text-gray-700 hover:bg-gray-100 group transition-all duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="{{ $colors['icon'] }} w-5 h-5 transition-all duration-200"
                                viewBox="0 -960 960 960" fill="currentColor">
                                <path
                                    d="M420-260h120v-100h100v-120H540v-100H420v100H320v120h100v100ZM280-120q-33 0-56.5-23.5T200-200v-440q0-33 23.5-56.5T280-720h400q33 0 56.5 23.5T760-640v440q0 33-23.5 56.5T680-120H280Zm-40-640v-80h480v80H240Z" />
                            </svg>
                            <span class="ml-3 font-medium">Products</span>
                        </a>
                    </li>
                @endif

                @if (in_array($role, ['Admin', 'Dokter', 'Apoteker']))
                    <li>
                        <a href="/admin/resep"
                            class="flex items-center p-2.5 rounded-lg text-gray-700 hover:bg-gray-100 group transition-all duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="{{ $colors['icon'] }} w-5 h-5 transition-all duration-200"
                                viewBox="0 -960 960 960" fill="currentColor">
                                <path
                                    d="m735-77 46-46-178-178-46 46q-37 37-37 89t37 89q37 37 89 37t89-37Zm102-102 46-46q37-37 37-89t-37-89q-37-37-89-37t-89 37l-46 46 178 178ZM280-600h400v-80H280v80Zm200-190q13 0 21.5-8.5T510-820q0-13-8.5-21.5T480-850q-13 0-21.5 8.5T450-820q0 13 8.5 21.5T480-790Zm-35 670H200q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h168q13-36 43.5-58t68.5-22q38 0 68.5 22t43.5 58h168q33 0 56.5 23.5T840-760v245q-42-10-83.5-1.5T680-485v-35H280v80h349l-80 80H280v80h195q-23 35-31.5 76.5T445-120Z" />
                            </svg>
                            <span class="ml-3 font-medium">Recipes</span>
                        </a>
                    </li>
                @endif

                @if (in_array($role, ['Admin', 'Apoteker']))
                    <li>
                        <a href="/admin/obat-resep"
                            class="flex items-center p-2.5 rounded-lg text-gray-700 hover:bg-gray-100 group transition-all duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="{{ $colors['icon'] }} w-5 h-5 transition-all duration-200"
                                viewBox="0 -960 960 960" fill="currentColor">
                                <path
                                    d="m424-318 282-282-56-56-226 226-114-114-56 56 170 170ZM200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h168q13-36 43.5-58t68.5-22q38 0 68.5 22t43.5 58h168q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Zm280-590q13 0 21.5-8.5T510-820q0-13-8.5-21.5T480-850q-13 0-21.5 8.5T450-820q0 13 8.5 21.5T480-790ZM200-200v-560 560Z" />
                            </svg>
                            <span class="ml-3 font-medium">Recipe Verifications</span>
                        </a>
                    </li>
                @endif

                @if (in_array($role, ['Admin', 'Kasir']))
                    <li>
                        <a href="/admin/pesanan"
                            class="flex items-center p-2.5 rounded-lg text-gray-700 hover:bg-gray-100 group transition-all duration-200">
                            <svg class="{{ $colors['icon'] }} w-5 h-5 transition-all duration-200" fill="currentColor"
                                viewBox="0 0 18 21" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M15 12a1 1 0 0 0 .962-.726l2-7A1 1 0 0 0 17 3H3.77L3.175.745A1 1 0 0 0 2.208 0H1a1 1 0 0 0 0 2h.438l.6 2.255v.019l2 7 .746 2.986A3 3 0 1 0 9 17a2.966 2.966 0 0 0-.184-1h2.368c-.118.32-.18.659-.184 1a3 3 0 1 0 3-3H6.78l-.5-2H15Z" />
                            </svg>
                            <span class="ml-3 font-medium">Orders</span>
                        </a>
                    </li>
                @endif

                @if ($role === 'Admin')
                    <li>
                        <a href="/admin/laporan"
                            class="flex items-center p-2.5 rounded-lg text-gray-700 hover:bg-gray-100 group transition-all duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="{{ $colors['icon'] }} w-5 h-5 transition-all duration-200"
                                viewBox="0 -960 960 960" fill="currentColor">
                                <path
                                    d="M200-120q-33 0-56.5-23.5T120-200v-640h80v640h640v80H200Zm40-120v-360h160v360H240Zm200 0v-560h160v560H440Zm200 0v-200h160v200H640Z" />
                            </svg>
                            <span class="ml-3 font-medium">Reports & Analytics</span>
                        </a>
                    </li>
                    <li>
                        <a href="/admin/akun"
                            class="flex items-center p-2.5 rounded-lg text-gray-700 hover:bg-gray-100 group transition-all duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="{{ $colors['icon'] }} w-5 h-5 transition-all duration-200"
                                viewBox="0 -960 960 960" fill="currentColor">
                                <path
                                    d="m640-120-12-60q-12-5-22.5-10.5T584-204l-58 18-40-68 46-40q-2-14-2-26t2-26l-46-40 40-68 58 18q11-8 21.5-13.5T628-460l12-60h80l12 60q12 5 22.5 11t21.5 15l58-20 40 70-46 40q2 12 2 25t-2 25l46 40-40 68-58-18q-11 8-21.5 13.5T732-180l-12 60h-80ZM80-160v-112q0-33 17-62t47-44q51-26 115-44t141-18h14q6 0 12 2-29 72-24 143t48 135H80Zm600-80q33 0 56.5-23.5T760-320q0-33-23.5-56.5T680-400q-33 0-56.5 23.5T600-320q0 33 23.5 56.5T680-240ZM400-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47Z" />
                            </svg>
                            <span class="ml-3 font-medium">Accounts</span>
                        </a>
                    </li>
                @endif

                @if (in_array($role, ['Apoteker', 'Dokter']))
                    <li>
                        <a href="/admin/chat"
                            class="flex items-center p-2.5 rounded-lg text-gray-700 hover:bg-gray-100 group transition-all duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="{{ $colors['icon'] }} w-5 h-5 transition-all duration-200"
                                viewBox="0 -960 960 960" fill="currentColor">
                                <path
                                    d="M240-400h320v-80H240v80Zm0-120h480v-80H240v80Zm0-120h480v-80H240v80ZM80-80v-720q0-33 23.5-56.5T160-880h640q33 0 56.5 23.5T880-800v480q0 33-23.5 56.5T800-240H240L80-80Zm126-240h594v-480H160v525l46-45Zm-46 0v-480 480Z" />
                            </svg>
                            <span class="ml-3 font-medium">Chat</span>
                        </a>
                    </li>
                @endif

                <li>
                    <a href="/admin/setting"
                        class="flex items-center p-2.5 rounded-lg text-gray-700 hover:bg-gray-100 group transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="{{ $colors['icon'] }} w-5 h-5 transition-all duration-200"
                            viewBox="0 -960 960 960" fill="currentColor">
                            <path
                                d="m370-80-16-128q-13-5-24.5-12T307-235l-119 50L78-375l103-78q-1-7-1-13.5v-27q0-6.5 1-13.5L78-585l110-190 119 50q11-8 23-15t24-12l16-128h220l16 128q13 5 24.5 12t22.5 15l119-50 110 190-103 78q1 7 1 13.5v27q0 6.5-2 13.5l103 78-110 190-118-50q-11 8-23 15t-24 12L590-80H370Zm112-260q58 0 99-41t41-99q0-58-41-99t-99-41q-59 0-99.5 41T342-480q0 58 40.5 99t99.5 41Z" />
                        </svg>
                        <span class="ml-3 font-medium">Settings</span>
                    </a>
                </li>
            @endif
        </ul>
    </nav>

    {{-- Logout Section --}}
    <div class="px-4 py-4 mt-2 border-t border-gray-100">
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="w-full">
            @csrf
            <button type="submit"
                class="flex items-center w-full p-2 text-sm font-medium text-red-600 rounded-lg transition-colors hover:bg-red-50 group">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-500" viewBox="0 -960 960 960"
                    fill="currentColor">
                    <path
                        d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h280v80H200v560h280v80H200Zm440-160-55-58 102-102H360v-80h327L585-622l55-58 200 200-200 200Z" />
                </svg>
                <span class="ml-3">{{ __('Logout') }}</span>
            </button>
        </form>
    </div>
</aside>

{{-- Optional: Sidebar Toggle Button --}}
<button id="sidebarToggle"
    class="fixed z-20 p-2 text-gray-600 bg-white rounded-full shadow-md lg:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 left-4 top-4">
    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd"
            d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
            clip-rule="evenodd"></path>
    </svg>
</button>

<!-- Navbar -->
<nav class="bg-transparent float-end w-[85%]" x-data="{ isOpen: false, newOrders: 0 }">
    <div class="paddingX">
        <div class="flex h-16 items-center justify-between">
            <div class="shrink-0 leading-6 flex flex-col justify-center">
                <p class="text-[2rem] font-semibold">{{ $title }}</p>
                <div class="calendar-container flex italic text-[12px] text-gray-700">
                    <div class="calendar-date" id="calendarDate"></div>
                    <p class="me-1">,</p>
                    <div class="calendar-time" id="calendarTime"></div>
                </div>
            </div>
            <div class="flex items-center gap-5">
                <a href="{{ url('/') }}" class="border bg-white border-black px-2 py-1 rounded-full ">Front
                    Page</a>

                <!-- Notifikasi Order -->
                <div class="relative">
                    <x-fas-bell width="35" height="35"
                        class="border border-black rounded-full p-1 cursor-pointer" onclick="toggleNotifications()" />
                    <div id="notification-dot"
                        class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full hidden"></div>

                    <!-- Notifications dropdown -->
                    <div id="notifications-dropdown"
                        class="absolute right-0 mt-2 w-80 z-50 bg-white rounded-lg shadow-lg hidden">
                        <div class="p-4">
                            <h3 class="text-lg font-semibold mb-2">Notifications</h3>
                            <div id="notifications-list" class="space-y-2">
                                <!-- Notifications will be inserted here -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

<div class="lg:w-[80%] lg:float-end">
    <main>
        <div class="paddingXD">
            @yield('content')
        </div>
    </main>
</div>


<!-- CSS untuk menyembunyikan scrollbar -->
<style>
    .scrollbar-hidden::-webkit-scrollbar {
        display: none;
    }

    .scrollbar-hidden {
        -ms-overflow-style: none;
        /* Internet Explorer 10+ */
        scrollbar-width: none;
        /* Firefox */
    }
</style>
<script>
    // Fungsi untuk mengupdate tanggal, bulan, tahun, hari dan waktu
    function updateDateTime() {
        const now = new Date();

        // Format Hari
        const days = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
        const day = days[now.getDay()];

        // Format Tanggal, Bulan, Tahun
        const dayOfMonth = now.getDate();
        const month = now.getMonth() + 1; // Bulan dimulai dari 0 (Januari = 0)
        const year = now.getFullYear();
        const dateFormatted = `${dayOfMonth}-${month < 10 ? '0' + month : month}-${year}`;

        // Format Jam, Menit, Detik
        let hours = now.getHours();
        let minutes = now.getMinutes();
        let seconds = now.getSeconds();
        const ampm = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12;
        hours = hours ? hours : 12; // Jam 0 menjadi jam 12
        minutes = minutes < 10 ? '0' + minutes : minutes;
        seconds = seconds < 10 ? '0' + seconds : seconds;
        const timeFormatted = `${hours}:${minutes}:${seconds} ${ampm}`;

        // Menampilkan ke UI
        document.getElementById('calendarDate').innerHTML = dateFormatted;
        document.getElementById('calendarTime').innerHTML = timeFormatted;
    }

    // Update setiap detik
    setInterval(updateDateTime, 1000);
    updateDateTime(); // Panggil sekali saat pertama kali halaman dimuat


    function fetchNotifications() {
        fetch('/notifications')
            .then(response => response.json())
            .then(data => {
                let notifList = document.getElementById('notifications-list');
                let notifDot = document.getElementById('notification-dot');

                notifList.innerHTML = '';

                if (data.length > 0) {
                    notifDot.classList.remove('hidden');
                    data.forEach(notif => {
                        notifList.innerHTML += `
                    <div id="notif-${notif.id}" class="bg-gray-100 p-2 rounded flex justify-between items-center">
                        <span>${notif.data.message}</span>
                        <button onclick="markAsRead('${notif.id}')" class="text-blue-500 text-sm">Tandai Dibaca</button>
                    </div>`;
                    });
                } else {
                    notifDot.classList.add('hidden');
                    notifList.innerHTML = `<div class="text-center text-gray-500">Tidak ada notifikasi</div>`;
                }
            });
    }

    function markAsRead(id) {
        fetch(`/notifications/${id}/read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                if (response.ok) {
                    document.getElementById(`notif-${id}`).remove();
                }
            })
            .catch(error => console.error('Error:', error));
    }

    function toggleNotifications() {
        let dropdown = document.getElementById('notifications-dropdown');
        dropdown.classList.toggle('hidden');
    }

    // Panggil setiap 5 detik agar real-time
    setInterval(fetchNotifications, 2000);
    fetchNotifications();

    document.addEventListener('DOMContentLoaded', function() {
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');

        if (sidebarToggle && sidebar) {
            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('-translate-x-full');
            });

            // On mobile, initialize sidebar as hidden
            if (window.innerWidth < 1024) {
                sidebar.classList.add('-translate-x-full');
            }

            // Handle resize events
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 1024) {
                    sidebar.classList.remove('-translate-x-full');
                } else {
                    sidebar.classList.add('-translate-x-full');
                }
            });
        }
    });
</script>
