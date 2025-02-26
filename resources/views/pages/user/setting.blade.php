@extends('layouts.user')

@section('content')
    <div class="max-w-7xl mx-auto p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Profile Section -->
            <div class="bg-white p-4 rounded-lg shadow">
                <h2 class="text-xl font-semibold">Profile</h2>
                <form action="{{ route('settings.updateProfile') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mt-4 flex justify-around items-center">
                        <div class="w-40 h-40 rounded-full border-2 p-1 overflow-hidden">
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
                                        'border' => 'border-gray-500',
                                        'avatar_bg' => 'd1d5db',
                                        'avatar_text' => '374151',
                                    ],
                                ];
                                $colors = $roleColors[$role] ?? $roleColors['Pelanggan'];
                            @endphp

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
                                class="w-full h-full rounded-full object-cover {{ $colors['bg'] }} {{ $colors['text'] }} {{ $colors['border'] }}" />
                        </div>
                        <div class="">
                            <label for="avatar" class="block text-gray-700">Profile Picture</label>
                            <input type="file" id="avatar" name="avatar" accept="image/*"
                                class="mt-1 block w-full border border-gray-300 rounded-lg p-2" />
                            <p id="errorMsg" class="text-red-500 text-sm mt-1 hidden">Format file tidak valid. Harap unggah
                                gambar.</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <label for="name" class="block text-gray-700">Name</label>
                        <input type="text" id="name" name="name" value="{{ Auth::user()->name }}"
                            class="mt-1 block w-full border border-gray-300 rounded-lg p-2" required />
                    </div>
                    <div class="mt-4">
                        <label for="email" class="block text-gray-700">Email</label>
                        <input type="email" id="email" name="email" value="{{ Auth::user()->email }}"
                            class="mt-1 block w-full border border-gray-300 rounded-lg p-2" required />
                    </div>
                    <div class="mt-4">
                        <label for="phone" class="block text-gray-700">Phone Number</label>
                        <input type="tel" id="phone" name="phone" value="{{ Auth::user()->phone }}"
                            class="mt-1 block w-full border border-gray-300 rounded-lg p-2" required />
                    </div>
                    <div class="mt-4">
                        <label for="address" class="block text-gray-700">Address</label>
                        <textarea id="address" name="address" class="mt-1 block w-full border border-gray-300 rounded-lg p-2" required>{{ Auth::user()->address }}</textarea>
                    </div>
                    <button type="submit" class="mt-4 w-full bg-blue-500 text-white py-2 rounded-lg">Update
                        Profile</button>
                </form>
            </div>

            <!-- Notification Settings Section -->
            <div class="bg-white p-4 rounded-lg shadow">
                <h2 class="text-xl font-semibold">Notification Settings</h2>
                <form action="{{ route('settings.updateNotifications') }}" method="POST">
                    @csrf
                    <div class="mt-4">
                        <label for="email_notifications" class="inline-flex items-center">
                            <input type="checkbox" name="email_notifications" id="email_notifications"
                                {{ Auth::user()->email_notifications ? 'checked' : '' }} class="mr-2" />
                            Email Notifications
                        </label>
                    </div>
                    <div class="mt-4">
                        <label for="sms_notifications" class="inline-flex items-center">
                            <input type="checkbox" name="sms_notifications" id="sms_notifications"
                                {{ Auth::user()->sms_notifications ? 'checked' : '' }} class="mr-2" />
                            SMS Notifications
                        </label>
                    </div>
                    <button type="submit" class="mt-4 w-full bg-blue-500 text-white py-2 rounded-lg">Update
                        Notifications</button>
                </form>
            </div>
        </div>

        <!-- Change Password Section -->
        <div class="bg-white p-4 mt-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold">Change Password</h2>
            <form action="{{ route('settings.updatePassword') }}" method="POST">
                @csrf
                <div class="mt-4">
                    <label for="current_password" class="block text-gray-700">Current Password</label>
                    <input type="password" id="current_password" name="current_password"
                        class="mt-1 block w-full border border-gray-300 rounded-lg p-2" required />
                </div>
                <div class="mt-4">
                    <label for="new_password" class="block text-gray-700">New Password</label>
                    <input type="password" id="new_password" name="new_password"
                        class="mt-1 block w-full border border-gray-300 rounded-lg p-2" required />
                </div>
                <div class="mt-4">
                    <label for="new_password_confirmation" class="block text-gray-700">Confirm New Password</label>
                    <input type="password" id="new_password_confirmation" name="new_password_confirmation"
                        class="mt-1 block w-full border border-gray-300 rounded-lg p-2" required />
                </div>
                <button type="submit" class="mt-4 w-full bg-blue-500 text-white py-2 rounded-lg">Update Password</button>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const avatarInput = document.getElementById('avatar');
            const avatarPreview = document.getElementById('avatarPreview');
            const errorMsg = document.getElementById('errorMsg');

            // Simpan avatar default
            const defaultAvatar = avatarPreview.src;

            avatarInput.addEventListener('change', function(event) {
                const file = event.target.files[0];

                if (file) {
                    if (!file.type.startsWith('image/')) {
                        errorMsg.classList.remove('hidden');
                        event.target.value = ''; // Reset input file
                        avatarPreview.src = defaultAvatar; // Kembali ke avatar default
                        return;
                    }

                    errorMsg.classList.add('hidden');

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        avatarPreview.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                } else {
                    // Jika tidak ada file yang dipilih, kembali ke avatar sebelumnya
                    avatarPreview.src = defaultAvatar;
                }
            });
        });
    </script>
@endsection
