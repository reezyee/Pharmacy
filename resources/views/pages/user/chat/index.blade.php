@extends('layouts.user')

@section('content')
    <div class="max-w-lg mx-auto p-4 mt-20 lg:mt-0 bg-white shadow-md rounded-lg">
        <h2 class="text-xl font-bold mb-4">Live Chat</h2>

        <!-- Daftar Dokter & Apoteker -->
        <div class="space-y-2">
            @foreach ($users as $user)
                @php
                    $role = $user->role->name;
                    $roleColors = [
                        'Dokter' => [
                            'bg' => 'bg-blue-100',
                            'text' => 'text-blue-700',
                            'border' => 'border-blue-700',
                            'avatar_bg' => '93c5fd',
                            'avatar_text' => '1e3a8a',
                        ],
                        'Apoteker' => [
                            'bg' => 'bg-green-100',
                            'text' => 'text-green-700',
                            'border' => 'border-green-700',
                            'avatar_bg' => 'a3e635',
                            'avatar_text' => '166534',
                        ],
                    ];
                    $colors = $roleColors[$role] ?? $roleColors['Dokter'];
                @endphp

                <a href="{{ route('user.chat.show', $user->id) }}"
                    class="flex items-center p-3 rounded-lg shadow-sm border hover:bg-gray-100 transition">
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
                        <p class="text-sm text-gray-500">{{ $role }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endsection
