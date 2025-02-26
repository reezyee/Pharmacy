@extends('layouts.user')
@section('content')
    <div class="max-w-lg mx-auto p-4 bg-white shadow-md rounded-lg">
        <h2 class="text-xl font-bold mb-4">Live Chat</h2>

        <!-- Daftar User -->
        <div class="space-y-2">
            @foreach ($users as $user)
                <a href="{{ route('chat.show', $user->id) }}"
                    class="flex items-center p-3 rounded-lg shadow-sm border hover:bg-gray-100 transition">
                    @php
                        $role = $user->role->name ?? 'Pelanggan'; // Default ke Pelanggan jika tidak ada role

                        // Warna sesuai role
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

                        // Ambil warna berdasarkan role, jika tidak ada pakai default 'Pelanggan'
                        $colors = $roleColors[$role] ?? $roleColors['Pelanggan'];
                    @endphp

                    <div class="w-10 h-10 rounded-full overflow-hidden">
                        <img src="{{ $user->avatar
                            ? asset('storage/' . $user->avatar)
                            : 'https://ui-avatars.com/api/?name=' .
                                urlencode($user->name) .
                                '&background=' .
                                $colors['avatar_bg'] .
                                '&color=' .
                                $colors['avatar_text'] }}"
                            class="w-full h-full rounded-full object-cover {{ $colors['border'] }}" alt="Profile Picture">
                    </div>
                    <div class="ml-3">
                        <p class="text-md font-semibold">{{ $user->name }}</p>
                        <p class="text-sm text-gray-500">{{ $user->role->name }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endsection
