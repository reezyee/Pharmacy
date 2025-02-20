@extends('layouts.user')

@section('content')
    <!-- Header Section -->
    <div class="mb-8">
        <p class="text-gray-600">Manage your system users and their roles</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-full">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h2 class="text-2xl font-semibold text-gray-800">{{ $users->total() }}</h2>
                    <p class="text-gray-600">Total Users</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-full">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h2 class="text-2xl font-semibold text-gray-800">{{ $roles->count() }}</h2>
                    <p class="text-gray-600">User Roles</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-full">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h2 class="text-2xl font-semibold text-gray-800">{{ now()->format('d M Y') }}</h2>
                    <p class="text-gray-600">Last Updated</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Add User Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="relative w-full md:w-96">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" id="search"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5"
                    placeholder="Search users..." onkeyup="searchTable()">
            </div>

            <button onclick="openCreateModal()"
                class="w-full md:w-auto px-6 py-2.5 bg-blue-600 text-white font-medium text-sm rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Add New User
            </button>
        </div>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-4">Name</th>
                        <th scope="col" class="px-6 py-4">Email</th>
                        <th scope="col" class="px-6 py-4">Role</th>
                        <th scope="col" class="px-6 py-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium text-gray-900">
                                <div class="flex items-center gap-3">
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

                                    <img src="{{ $user->avatar
                                        ? asset('storage/' . $user->avatar)
                                        : 'https://ui-avatars.com/api/?name=' .
                                            urlencode($user->name) .
                                            '&background=' .
                                            $colors['avatar_bg'] .
                                            '&color=' .
                                            $colors['avatar_text'] }}"
                                        alt="Profile Picture"
                                        class="w-10 h-10 rounded-full border-2 {{ $colors['bg'] }} {{ $colors['text'] }} {{ $colors['border'] }}" />
                                    {{ $user->name }}
                                </div>
                            </td>
                            <td class="px-6 py-4">{{ $user->email }}</td>
                            <td class="px-6 py-4">
                                @php
                                    $roleName = strtolower($user->role->name);
                                    $badgeClass = match ($roleName) {
                                        'admin' => 'bg-purple-100 text-purple-600',
                                        'apoteker' => 'bg-green-100 text-green-600',
                                        'dokter' => 'bg-blue-100 text-blue-600',
                                        'kasir' => 'bg-orange-100 text-orange-600',
                                        default => 'bg-gray-100 text-gray-600',
                                    };
                                @endphp

                                <span class="px-3 py-1 text-xs font-medium rounded-full {{ $badgeClass }}">
                                    {{ ucfirst($user->role->name) }}
                                </span>
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex gap-2">
                                    <button
                                        onclick="openEditModal({{ $user->id }}, '{{ $user->name }}', '{{ $user->email }}', {{ $user->role_id }})"
                                        class="text-blue-600 hover:text-blue-900">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>
                                    <button onclick="openDeleteModal({{ $user->id }})"
                                        class="text-red-600 hover:text-red-900">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="p-4">
            {{ $users->links() }}
        </div>
    </div>

    <!-- Create Modal -->
    <div id="createModalBackdrop" onclick="closeCreateModal()" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40">
    </div>
    <div id="createModal" class="fixed inset-0 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-md mx-4" onclick="event.stopPropagation()">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-semibold text-gray-900">Add New User</h2>
                <button onclick="closeCreateModal()" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form action="{{ route('admin.akun.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                    <input type="text" id="name" name="name" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" id="email" name="email" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <div class="relative">
                        <input type="password" id="password" name="password" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <button type="button" onclick="togglePassword('password', 'createEyeIcon')"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <svg id="createEyeIcon" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div>
                    <label for="role_id" class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                    <select id="role_id" name="role_id" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select Role</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="closeCreateModal()"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-400">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Create User
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModalBackdrop" onclick="closeEditModal()" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40">
    </div>
    <div id="editModal" class="fixed inset-0 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-md mx-4" onclick="event.stopPropagation()">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-semibold text-gray-900">Edit User</h2>
                <button onclick="closeEditModal()" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form id="editForm" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label for="edit_name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                    <input type="text" id="edit_name" name="name" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label for="edit_email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" id="edit_email" name="email" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label for="edit_password" class="block text-sm font-medium text-gray-700 mb-1">
                        Password (Leave empty to keep current password)
                    </label>
                    <div class="relative">
                        <input type="password" id="edit_password" name="password"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <button type="button" onclick="togglePassword('edit_password', 'editEyeIcon')"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <svg id="editEyeIcon" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div>
                    <label for="edit_role_id" class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                    <select id="edit_role_id" name="role_id" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select Role</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="closeEditModal()"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-400">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Update User
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Modal -->
    <div id="deleteModalBackdrop" onclick="closeDeleteModal()" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40">
    </div>
    <div id="deleteModal" class="fixed inset-0 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-md mx-4" onclick="event.stopPropagation()">
            <div class="mb-6">
                <h2 class="text-xl font-semibold text-gray-900">Delete User</h2>
                <p class="mt-2 text-gray-600">Are you sure you want to delete this user? This action cannot be undone.
                </p>
            </div>

            <form id="deleteForm" method="POST" class="space-y-4">
                @csrf
                @method('DELETE')
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeDeleteModal()"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-400">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                        Delete User
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
<script>
    // Flash Message
    function showFlashMessage(message, type = 'success') {
        const flashDiv = document.createElement('div');
        flashDiv.className = `fixed top-4 right-4 p-4 rounded-lg z-50 transform transition-transform duration-300 ease-in-out ${
            type === 'success' ? 'bg-green-500' : 'bg-red-500'
        } text-white`;
        flashDiv.style.transform = 'translateY(-100%)';
        flashDiv.textContent = message;

        document.body.appendChild(flashDiv);

        // Animate in
        setTimeout(() => {
            flashDiv.style.transform = 'translateY(0)';
        }, 100);

        // Animate out and remove
        setTimeout(() => {
            flashDiv.style.transform = 'translateY(-100%)';
            setTimeout(() => {
                flashDiv.remove();
            }, 300);
        }, 3000);
    }

    // Modal Functions
    function openCreateModal() {
        document.getElementById('createModal').classList.remove('hidden');
        document.getElementById('createModalBackdrop').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeCreateModal() {
        document.getElementById('createModal').classList.add('hidden');
        document.getElementById('createModalBackdrop').classList.add('hidden');
        document.body.style.overflow = '';
    }

    function openEditModal(id, name, email, roleId) {
        document.getElementById('editModal').classList.remove('hidden');
        document.getElementById('editModalBackdrop').classList.remove('hidden');
        document.body.style.overflow = 'hidden';

        document.getElementById('editForm').action = `/admin/akun/${id}`;
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_email').value = email;
        document.getElementById('edit_role_id').value = roleId;
        document.getElementById('edit_password').value = '';
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
        document.getElementById('editModalBackdrop').classList.add('hidden');
        document.body.style.overflow = '';
    }

    function openDeleteModal(id) {
        document.getElementById('deleteModal').classList.remove('hidden');
        document.getElementById('deleteModalBackdrop').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        document.getElementById('deleteForm').action = `/admin/akun/${id}`;
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
        document.getElementById('deleteModalBackdrop').classList.add('hidden');
        document.body.style.overflow = '';
    }

    // Password Toggle
    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);

        if (input.type === 'password') {
            input.type = 'text';
            icon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
            `;
        } else {
            input.type = 'password';
            icon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            `;
        }
    }

    // Search Function
    function searchTable() {
        const input = document.getElementById('search').value.toLowerCase();
        const rows = document.querySelectorAll('tbody tr');

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(input) ? '' : 'none';
        });
    }

    // Form Submissions
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            fetch(this.action, {
                    method: this.method,
                    body: new FormData(this),
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showFlashMessage(data.message);
                        closeCreateModal();
                        closeEditModal();
                        closeDeleteModal();
                        window.location.reload();
                    } else {
                        showFlashMessage(data.message, 'error');
                    }
                })
                .catch(error => {
                    showFlashMessage('An error occurred. Please try again.', 'error');
                });
        });
    });

    // Close modals on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeCreateModal();
            closeEditModal();
            closeDeleteModal();
        }
    });
</script>
