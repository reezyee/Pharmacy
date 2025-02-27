@extends('layouts.user')

@section('content')
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <h1
            class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-cyan-500 to-blue-600 mb-8 text-center">
            Admin Control Panel</h1>

        <!-- Session Status Message -->
        @if (session('success'))
            <div
                class="bg-gradient-to-r from-green-500 to-emerald-500 text-white p-4 rounded-lg mb-6 shadow-lg transform transition-all duration-300 hover:scale-102 backdrop-blur-sm bg-opacity-90">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Sticky Sidebar Navigation -->
            <div class="col-span-1">
                <div class="sticky top-4" id="stickyNav">
                    <div
                        class="bg-gradient-to-br from-gray-900 to-blue-900 backdrop-blur-lg bg-opacity-80 rounded-2xl shadow-xl overflow-hidden transition-all duration-300 hover:shadow-blue-500/20 border border-gray-800 border-opacity-50">
                        <div class="p-6">
                            <h2 class="text-2xl font-bold text-white mb-6">Settings Panel</h2>

                            <nav class="space-y-2">
                                <a href="#profile"
                                    class="flex items-center p-3 rounded-xl bg-blue-600 bg-opacity-50 text-white hover:bg-blue-700 hover:bg-opacity-70 transition-all duration-200 group nav-link">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5 mr-3 text-blue-200 group-hover:text-white transition-colors"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Personal Profile
                                </a>

                                @if (Auth::user()->role->name === 'Admin')
                                    <a href="#pharmacy"
                                        class="flex items-center p-3 rounded-xl bg-cyan-600 bg-opacity-80 text-white hover:bg-cyan-700 hover:bg-opacity-90 transition-all duration-200 group">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5 mr-3 text-cyan-200 group-hover:text-white transition-colors"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4zm3 1h6v4H7V5zm8 8V7h2v6h-2zM9 5h2v4H9V5zM7 9h2v1H7V9zm0 2h2v1H7v-1zm0 2h2v1H7v-1zm6-6h2v1h-2V7zm0 2h2v1h-2V9zm0 2h2v1h-2v-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Pharmacy Management
                                    </a>
                                @endif

                                <a href="#security"
                                    class="flex items-center p-3 rounded-xl bg-gray-700 bg-opacity-50 text-white hover:bg-gray-600 transition-all duration-200 group nav-link">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5 mr-3 text-gray-300 group-hover:text-white transition-colors"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Security Settings
                                </a>
                            </nav>

                            <!-- Admin Info -->
                            <div class="mt-8 pt-6 border-t border-blue-800">
                                <div class="flex items-center">
                                    @php
                                        $role = Auth::user()->role->name ?? 'Pelanggan';
                                        $roleColors = [
                                            'Admin' => [
                                                'bg' => 'bg-purple-100',
                                                'text' => 'text-purple-700',
                                                'border' => 'border-purple-700',
                                                'avatar_bg' => 'd8b4fe',
                                                'avatar_text' => '6b21a8',
                                            ],
                                            'Apoteker' => [
                                                'bg' => 'bg-green-100',
                                                'text' => 'text-green-700',
                                                'border' => 'border-green-700',
                                                'avatar_bg' => 'a3e635',
                                                'avatar_text' => '166534',
                                            ],
                                            'Dokter' => [
                                                'bg' => 'bg-blue-100',
                                                'text' => 'text-blue-700',
                                                'border' => 'border-blue-700',
                                                'avatar_bg' => '93c5fd',
                                                'avatar_text' => '1e3a8a',
                                            ],
                                            'Kasir' => [
                                                'bg' => 'bg-orange-100',
                                                'text' => 'text-orange-700',
                                                'border' => 'border-orange-700',
                                                'avatar_bg' => 'fdba74',
                                                'avatar_text' => '9a3412',
                                            ],
                                            'Pelanggan' => [
                                                'bg' => 'bg-gray-100',
                                                'text' => 'text-gray-700',
                                                'border' => 'border-gray-700',
                                                'avatar_bg' => 'd1d5db',
                                                'avatar_text' => '374151',
                                            ],
                                        ];
                                        $colors = $roleColors[$role] ?? $roleColors['Pelanggan'];
                                    @endphp
                                    <div class="relative">
                                        <img src="{{ Auth::user()->avatar
                                            ? asset('storage/' . Auth::user()->avatar)
                                            : 'https://ui-avatars.com/api/?name=' .
                                                urlencode(Auth::user()->name) .
                                                '&background=' .
                                                $colors['avatar_bg'] .
                                                '&color=' .
                                                $colors['avatar_text'] }}"
                                            alt="Avatar"
                                            class="w-12 h-12 rounded-full object-cover {{ $colors['bg'] }} {{ $colors['text'] }} {{ $colors['border'] }} shadow-lg" />

                                        <div
                                            class="absolute -bottom-1 -right-1 bg-green-500 w-4 h-4 rounded-full border-2 border-gray-900">
                                        </div>
                                    </div>

                                    <div class="ml-4">
                                        <p class="text-white font-medium">{{ Auth::user()->name }}</p>
                                        @if (Auth::user()->role_id === 'Admin')
                                            <p class="text-blue-300 text-sm">Administrator</p>
                                        @elseif (Auth::user()->role_id === 'Apoteker')
                                            <p class="text-blue-300 text-sm">Pharmacist</p>
                                        @elseif (Auth::user()->role_id === 'Kasir')
                                            <p class="text-blue-300 text-sm">Cashier</p>
                                        @elseif (Auth::user()->role_id === 'Dokter')
                                            <p class="text-blue-300 text-sm">Doctor</p>
                                        @else
                                            <p class="text-blue-300 text-sm">Customer</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Area (2 Columns Wide) -->
            <div class="col-span-2 space-y-8">
                <!-- User Profile Section (Same as original) -->
                <div id="profile"
                    class="bg-white bg-opacity-10 backdrop-blur-lg rounded-2xl shadow-xl overflow-hidden transition-all duration-300 hover:shadow-blue-500/10 border border-gray-200 border-opacity-20">
                    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 py-4 px-6">
                        <h2 class="text-xl font-semibold text-white">Personal Profile</h2>
                    </div>

                    <form action="{{ route('settings.updateProfile') }}" method="POST" enctype="multipart/form-data"
                        class="p-6">
                        @csrf
                        <div class="flex flex-col md:flex-row items-center gap-6 mb-6">
                            <div class="relative group">
                                <div
                                    class="w-32 h-32 rounded-full shadow-md overflow-hidden border-2 {{ $colors['border'] }} transition-all duration-300 group-hover:scale-105">
                                    <img id="avatarPreview"
                                        src="{{ Auth::user()->avatar
                                            ? asset('storage/' . Auth::user()->avatar)
                                            : 'https://ui-avatars.com/api/?name=' .
                                                urlencode(Auth::user()->name) .
                                                '&background=' .
                                                $colors['avatar_bg'] .
                                                '&color=' .
                                                $colors['avatar_text'] }}"
                                        alt="Profile Picture"
                                        class="w-full h-full object-cover {{ $colors['bg'] }} {{ $colors['text'] }}" />
                                </div>

                                <div class="absolute bottom-0 right-0">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $colors['bg'] }} {{ $colors['text'] }}">
                                        @if (Auth::user()->role->name === 'Admin')
                                            <p class="">Administrator</p>
                                        @elseif (Auth::user()->role->name === 'Apoteker')
                                            <p class="">Pharmacist</p>
                                        @elseif (Auth::user()->role->name === 'Kasir')
                                            <p class="">Cashier</p>
                                        @elseif (Auth::user()->role->name === 'Dokter')
                                            <p class="">Doctor</p>
                                        @else
                                            <p class="">Customer</p>
                                        @endif
                                    </span>
                                </div>
                            </div>
                            <div class="flex-1">
                                <label for="avatar" class="block text-sm font-medium text-gray-700 mb-1">Update Profile
                                    Picture</label>
                                <div class="mt-1 flex items-center">
                                    <input type="file" id="avatar" name="avatar" accept="image/*"
                                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                                </div>
                                <p id="errorMsg" class="text-red-500 text-sm mt-1 hidden">Invalid file format. Please
                                    upload an image.</p>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full
                                    Name</label>
                                <input type="text" id="name" name="name" value="{{ Auth::user()->name }}"
                                    class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                    required />
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email
                                    Address</label>
                                <input type="email" id="email" name="email" value="{{ Auth::user()->email }}"
                                    class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                    required />
                            </div>

                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone
                                    Number</label>
                                <input type="tel" id="phone" name="phone" value="{{ Auth::user()->phone }}"
                                    class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                    required />
                            </div>

                            <div>
                                <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                                <textarea id="address" name="address" rows="3"
                                    class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                    required>{{ Auth::user()->address }}</textarea>
                            </div>
                        </div>

                        <div class="mt-6">
                            <button type="submit"
                                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z"
                                        clip-rule="evenodd" />
                                </svg>
                                Save Profile Changes
                            </button>
                        </div>
                    </form>
                </div>

                <!-- New Pharmacy Profile Section -->
                @if (Auth::user()->role->name === 'Admin')
                    <div id="pharmacy"
                        class="bg-white bg-opacity-10 backdrop-blur-lg rounded-2xl shadow-xl overflow-hidden transition-all duration-300 hover:shadow-cyan-500/10 border border-gray-200 border-opacity-20">
                        <div class="bg-gradient-to-r from-cyan-600 to-blue-700 py-4 px-6">
                            <h2 class="text-xl font-semibold text-white">Pharmacy Profile Management</h2>
                        </div>

                        <form action="{{ route('admin.updatePharmacy') }}" method="POST" class="p-6">
                            @csrf

                            <!-- Pharmacy Info -->
                            <div class="bg-cyan-50 bg-opacity-20 rounded-xl p-4 mb-6 shadow-inner">
                                <div class="flex items-center mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-cyan-600" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    <h3 class="ml-2 text-lg font-medium text-gray-900">Pharmacy General Information</h3>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="pharmacy_name"
                                            class="block text-sm font-medium text-gray-700 mb-1">Pharmacy Name</label>
                                        <input type="text" id="pharmacy_name" name="name"
                                            value="{{ $pharmacy->name ?? '' }}"
                                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-all duration-200"
                                            required />
                                    </div>

                                    <div>
                                        <label for="nomor_izin_apotek"
                                            class="block text-sm font-medium text-gray-700 mb-1">Pharmacy License
                                            Number</label>
                                        <input type="text" id="nomor_izin_apotek" name="nomor_izin_apotek"
                                            value="{{ $pharmacy->nomor_izin_apotek ?? '' }}"
                                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-all duration-200"
                                            required />
                                    </div>
                                </div>
                            </div>

                            <!-- Pharmacist Info -->
                            <div class="bg-blue-50 bg-opacity-20 rounded-xl p-4 mb-6 shadow-inner">
                                <div class="flex items-center mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <h3 class="ml-2 text-lg font-medium text-gray-900">Pharmacist Information</h3>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="nama_apoteker"
                                            class="block text-sm font-medium text-gray-700 mb-1">Pharmacist Name</label>
                                        <input type="text" id="nama_apoteker" name="nama_apoteker"
                                            value="{{ $pharmacy->nama_apoteker ?? '' }}"
                                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                            required />
                                    </div>

                                    <div>
                                        <label for="sipa" class="block text-sm font-medium text-gray-700 mb-1">SIPA
                                            (Pharmacist Practice License)</label>
                                        <input type="text" id="sipa" name="sipa"
                                            value="{{ $pharmacy->sipa ?? '' }}"
                                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                            required />
                                    </div>

                                    <div class="md:col-span-2">
                                        <label for="jadwal_praktik"
                                            class="block text-sm font-medium text-gray-700 mb-1">Practice Schedule</label>
                                        <input type="text" id="jadwal_praktik" name="jadwal_praktik"
                                            value="{{ $pharmacy->jadwal_praktik ?? '' }}"
                                            placeholder="Example: Monday-Friday: 08:00-20:00, Saturday: 09:00-17:00"
                                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                            required />
                                    </div>
                                </div>
                            </div>

                            <!-- Location Info -->
                            <div class="bg-indigo-50 bg-opacity-20 rounded-xl p-4 mb-6 shadow-inner">
                                <div class="flex items-center mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-600"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <h3 class="ml-2 text-lg font-medium text-gray-900">Location Information</h3>
                                </div>

                                <div class="space-y-4">
                                    <div>
                                        <label for="address"
                                            class="block text-sm font-medium text-gray-700 mb-1">Pharmacy
                                            Address</label>
                                        <textarea id="pharmacy_address" name="address" rows="3"
                                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200"
                                            required>{{ $pharmacy->address ?? '' }}</textarea>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label for="latitude"
                                                class="block text-sm font-medium text-gray-700 mb-1">Latitude</label>
                                            <input type="text" id="latitude" name="latitude"
                                                value="{{ $pharmacy->latitude ?? '' }}" placeholder="Example: -6.2088"
                                                class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200" />
                                        </div>

                                        <div>
                                            <label for="longitude"
                                                class="block text-sm font-medium text-gray-700 mb-1">Longitude</label>
                                            <input type="text" id="longitude" name="longitude"
                                                value="{{ $pharmacy->longitude ?? '' }}" placeholder="Example: 106.8456"
                                                class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200" />
                                        </div>
                                    </div>

                                    <div class="flex items-center">
                                        <button type="button" id="getLocationBtn"
                                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            Get Current Location
                                        </button>
                                        <span id="locationStatus" class="ml-3 text-sm text-gray-500"></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Status Toggle -->
                            <div class="bg-green-50 bg-opacity-20 rounded-xl p-4 mb-6 shadow-inner">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <h3 class="ml-2 text-lg font-medium text-gray-900">Pharmacy Status</h3>
                                    </div>

                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" name="is_active" value="1" class="sr-only peer"
                                            {{ isset($pharmacy->is_active) && $pharmacy->is_active ? 'checked' : '' }}>
                                        <div
                                            class="w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-green-600">
                                        </div>
                                        <span
                                            class="ml-3 text-sm font-medium text-gray-900">{{ isset($pharmacy->is_active) && $pharmacy->is_active ? 'Active' : 'Inactive' }}</span>
                                    </label>
                                </div>
                            </div>

                            <div class="mt-6">
                                <button type="submit"
                                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-cyan-600 to-blue-600 hover:from-cyan-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500 transition-all duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Save Pharmacy Information
                                </button>
                            </div>
                        </form>
                    </div>
                @endif
                <!-- Security Settings Section -->
                <div id="security"
                    class="bg-white bg-opacity-10 backdrop-blur-lg rounded-2xl shadow-xl overflow-hidden transition-all duration-300 hover:shadow-blue-500/10 border border-gray-200 border-opacity-20">
                    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 py-4 px-6">
                        <h2 class="text-xl font-semibold text-white">Security Settings</h2>
                    </div>

                    <form action="{{ route('password.update.auth') }}" method="POST" class="p-6">
                        @csrf

                        <!-- Status Messages -->
                        @if (session('status'))
                            <div
                                class="bg-gradient-to-r from-green-500 to-emerald-500 text-white p-4 rounded-lg mb-6 shadow-lg transform transition-all duration-300 hover:scale-102 backdrop-blur-sm bg-opacity-90">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>{{ session('status') }}</span>
                                </div>
                            </div>
                        @endif

                        <!-- Error Messages -->
                        @error('current_password')
                            <div
                                class="bg-gradient-to-r from-red-500 to-pink-500 text-white p-4 rounded-lg mb-6 shadow-lg transform transition-all duration-300 hover:scale-102 backdrop-blur-sm bg-opacity-90">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                    <span>{{ $message }}</span>
                                </div>
                            </div>
                        @enderror
                        @error('password')
                            <div
                                class="bg-gradient-to-r from-red-500 to-pink-500 text-white p-4 rounded-lg mb-6 shadow-lg transform transition-all duration-300 hover:scale-102 backdrop-blur-sm bg-opacity-90">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                    <span>{{ $message }}</span>
                                </div>
                            </div>
                        @enderror

                        <div class="space-y-4">
                            <div>
                                <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Current
                                    Password</label>
                                <div class="relative">
                                    <input type="password" id="current_password" name="current_password"
                                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                        required />
                                    <button type="button"
                                        class="toggle-password absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 cursor-pointer"
                                        data-target="current_password">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 eye-icon"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                            <path fill-rule="evenodd"
                                                d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 eye-off-icon hidden"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z"
                                                clip-rule="evenodd" />
                                            <path
                                                d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">New
                                    Password</label>
                                <div class="relative">
                                    <input type="password" id="password" name="password"
                                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                        required />
                                    <button type="button"
                                        class="toggle-password absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 cursor-pointer"
                                        data-target="password">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 eye-icon"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                            <path fill-rule="evenodd"
                                                d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 eye-off-icon hidden"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z"
                                                clip-rule="evenodd" />
                                            <path
                                                d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z" />
                                        </svg>
                                    </button>
                                </div>
                                <div class="mt-1">
                                    <div class="password-strength-meter flex mt-2">
                                        <div class="h-1 w-1/4 rounded-l-full bg-gray-300 strength-segment"
                                            id="strength-1"></div>
                                        <div class="h-1 w-1/4 bg-gray-300 strength-segment" id="strength-2"></div>
                                        <div class="h-1 w-1/4 bg-gray-300 strength-segment" id="strength-3"></div>
                                        <div class="h-1 w-1/4 rounded-r-full bg-gray-300 strength-segment"
                                            id="strength-4"></div>
                                    </div>
                                    <p class="text-xs mt-1 text-gray-500" id="password-strength-text">Password
                                        strength</p>
                                </div>
                            </div>

                            <div>
                                <label for="password_confirmation"
                                    class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                                <div class="relative">
                                    <input type="password" id="password_confirmation" name="password_confirmation"
                                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                        required />
                                    <button type="button"
                                        class="toggle-password absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 cursor-pointer"
                                        data-target="password_confirmation">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 eye-icon"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                            <path fill-rule="evenodd"
                                                d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 eye-off-icon hidden"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z"
                                                clip-rule="evenodd" />
                                            <path
                                                d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z" />
                                        </svg>
                                    </button>
                                </div>
                                <p id="match-status" class="text-xs mt-1 hidden">Passwords do not match</p>
                            </div>
                        </div>

                        <div class="mt-6">
                            <button type="submit" id="submit-btn"
                                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                Update Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Avatar preview functionality
            const avatarInput = document.getElementById('avatar');
            const avatarPreview = document.getElementById('avatarPreview');
            const errorMsg = document.getElementById('errorMsg');

            // Save default avatar
            const defaultAvatar = avatarPreview.src;

            avatarInput.addEventListener('change', function(event) {
                const file = event.target.files[0];

                if (file) {
                    if (!file.type.startsWith('image/')) {
                        errorMsg.classList.remove('hidden');
                        event.target.value = ''; // Reset input file
                        avatarPreview.src = defaultAvatar; // Return to default avatar
                        return;
                    }

                    errorMsg.classList.add('hidden');

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        avatarPreview.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                } else {
                    // If no file selected, return to previous avatar
                    avatarPreview.src = defaultAvatar;
                }
            });

            // Geolocation functionality
            const getLocationBtn = document.getElementById('getLocationBtn');
            const latitudeInput = document.getElementById('latitude');
            const longitudeInput = document.getElementById('longitude');
            const locationStatus = document.getElementById('locationStatus');

            getLocationBtn.addEventListener('click', function() {
                locationStatus.textContent = 'Getting location...';

                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        function(position) {
                            latitudeInput.value = position.coords.latitude.toFixed(8);
                            longitudeInput.value = position.coords.longitude.toFixed(8);
                            locationStatus.textContent = 'Location acquired successfully!';
                            locationStatus.className = 'ml-3 text-sm text-green-600';

                            // Add animation effect to inputs
                            latitudeInput.classList.add('ring-2', 'ring-green-500');
                            longitudeInput.classList.add('ring-2', 'ring-green-500');

                            setTimeout(() => {
                                latitudeInput.classList.remove('ring-2', 'ring-green-500');
                                longitudeInput.classList.remove('ring-2', 'ring-green-500');
                            }, 2000);
                        },
                        function(error) {
                            locationStatus.textContent = 'Error: ' + error.message;
                            locationStatus.className = 'ml-3 text-sm text-red-600';
                        }
                    );
                } else {
                    locationStatus.textContent = 'Geolocation is not supported by this browser.';
                    locationStatus.className = 'ml-3 text-sm text-red-600';
                }
            });

            // Toggle functionality for pharmacy status
            const statusToggle = document.querySelector('input[name="is_active"]');
            const statusLabel = statusToggle.nextElementSibling.nextElementSibling;

            statusToggle.addEventListener('change', function() {
                statusLabel.textContent = this.checked ? 'Active' : 'Inactive';
            });

            // Toggle password visibility
            const toggleButtons = document.querySelectorAll('.toggle-password');
            toggleButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-target');
                    const passwordInput = document.getElementById(targetId);
                    const eyeIcon = this.querySelector('.eye-icon');
                    const eyeOffIcon = this.querySelector('.eye-off-icon');

                    if (passwordInput.type === 'password') {
                        passwordInput.type = 'text';
                        eyeIcon.classList.add('hidden');
                        eyeOffIcon.classList.remove('hidden');
                    } else {
                        passwordInput.type = 'password';
                        eyeIcon.classList.remove('hidden');
                        eyeOffIcon.classList.add('hidden');
                    }
                });
            });

            // Password strength meter
            const passwordInput = document.getElementById('password');
            const strengthSegments = [
                document.getElementById('strength-1'),
                document.getElementById('strength-2'),
                document.getElementById('strength-3'),
                document.getElementById('strength-4')
            ];
            const strengthText = document.getElementById('password-strength-text');

            passwordInput.addEventListener('input', function() {
                const password = this.value;
                let strength = 0;

                // Reset all segments
                strengthSegments.forEach(segment => {
                    segment.className = 'h-1 w-1/4 bg-gray-300 strength-segment';
                });

                if (password.length >= 8) strength++;
                if (password.match(/[A-Z]/)) strength++;
                if (password.match(/[0-9]/)) strength++;
                if (password.match(/[^a-zA-Z0-9]/)) strength++;

                // Update strength meter colors
                const colors = ['red-500', 'orange-500', 'yellow-500', 'green-500'];
                const texts = ['Weak', 'Fair', 'Good', 'Strong'];

                if (password.length > 0) {
                    for (let i = 0; i < strength; i++) {
                        strengthSegments[i].classList.remove('bg-gray-300');
                        strengthSegments[i].classList.add(`bg-${colors[strength-1]}`);
                    }
                    strengthText.textContent = texts[strength - 1] + ' password';
                    strengthText.classList.remove('text-gray-500');
                    strengthText.classList.add(`text-${colors[strength-1]}`);
                } else {
                    strengthText.textContent = 'Password strength';
                    strengthText.classList.remove('text-red-500', 'text-orange-500', 'text-yellow-500',
                        'text-green-500');
                    strengthText.classList.add('text-gray-500');
                }
            });

            // Password confirmation match check
            const confirmInput = document.getElementById('password_confirmation');
            const matchStatus = document.getElementById('match-status');

            function checkPasswordMatch() {
                if (confirmInput.value === '') {
                    matchStatus.classList.add('hidden');
                    return;
                }

                if (passwordInput.value === confirmInput.value) {
                    matchStatus.textContent = 'Passwords match';
                    matchStatus.classList.remove('hidden', 'text-red-500');
                    matchStatus.classList.add('text-green-500');
                } else {
                    matchStatus.textContent = 'Passwords do not match';
                    matchStatus.classList.remove('hidden', 'text-green-500');
                    matchStatus.classList.add('text-red-500');
                }
            }

            passwordInput.addEventListener('input', checkPasswordMatch);
            confirmInput.addEventListener('input', checkPasswordMatch);

            // Get all section elements
            const sections = document.querySelectorAll('div[id]');
            const navLinks = document.querySelectorAll('.nav-link');

            // Function to highlight active nav item based on scroll position
            function highlightActiveNav() {
                let scrollPosition = window.scrollY;

                // Add offset for better UX when scrolling
                const offset = 100;

                // Check the position of each section
                sections.forEach(section => {
                    const sectionTop = section.offsetTop - offset;
                    const sectionHeight = section.offsetHeight;
                    const sectionId = section.getAttribute('id');

                    if (scrollPosition >= sectionTop && scrollPosition < sectionTop + sectionHeight) {
                        // Remove active class from all links
                        navLinks.forEach(link => {
                            link.classList.remove('bg-blue-600', 'bg-opacity-50');
                            link.classList.add('bg-gray-700', 'bg-opacity-50');
                        });

                        // Add active class to current section link
                        const activeLink = document.querySelector(`.nav-link[href="#${sectionId}"]`);
                        if (activeLink) {
                            activeLink.classList.remove('bg-gray-700', 'bg-opacity-50');
                            activeLink.classList.add('bg-blue-600', 'bg-opacity-50');
                        }
                    }
                });

                // Apply smooth transition for sticky nav
                const stickyNav = document.getElementById('stickyNav');
                if (scrollPosition > 50) {
                    stickyNav.classList.add('transition-shadow', 'shadow-2xl');
                } else {
                    stickyNav.classList.remove('transition-shadow', 'shadow-2xl');
                }
            }

            // Smooth scrolling for navigation links
            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();

                    const targetId = this.getAttribute('href');
                    const targetSection = document.querySelector(targetId);

                    if (targetSection) {
                        // Offset for fixed header if needed
                        const offset = 20;
                        const targetPosition = targetSection.offsetTop - offset;

                        window.scrollTo({
                            top: targetPosition,
                            behavior: 'smooth'
                        });

                        // Update URL hash without jumping
                        history.pushState(null, null, targetId);

                        // Manually update active nav
                        navLinks.forEach(navLink => {
                            navLink.classList.remove('bg-blue-600', 'bg-opacity-50');
                            navLink.classList.add('bg-gray-700', 'bg-opacity-50');
                        });

                        this.classList.remove('bg-gray-700', 'bg-opacity-50');
                        this.classList.add('bg-blue-600', 'bg-opacity-50');
                    }
                });
            });

            // Add scroll event listener
            window.addEventListener('scroll', highlightActiveNav);

            // Run on initial load
            highlightActiveNav();
        });
    </script>
@endsection
