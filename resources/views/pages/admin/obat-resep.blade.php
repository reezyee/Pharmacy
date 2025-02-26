@extends('layouts.user')

@section('content')
    <div class="container mx-auto px-6 py-8">
        <h1 class="text-3xl font-semibold text-gray-900 mb-6">📝 Verifikasi Resep</h1>

        @if (session('success'))
            <div class="flex items-center p-4 mb-4 text-sm text-green-800 bg-green-100 rounded-xl shadow-sm">
                ✅ {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="flex items-center p-4 mb-4 text-sm text-red-800 bg-red-100 rounded-xl shadow-sm">
                ❌ {{ session('error') }}
            </div>
        @endif

        <!-- Statistik Resep -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
            <div class="bg-white shadow-xl rounded-2xl p-6 text-center">
                <p class="text-gray-500 text-sm">Total Resep</p>
                <p class="text-2xl font-bold text-gray-900">{{ $totalResep }}</p>
            </div>
            <div class="bg-yellow-100 shadow-xl rounded-2xl p-6 text-center">
                <p class="text-gray-500 text-sm">Menunggu Diverifikasi</p>
                <p class="text-2xl font-bold text-yellow-600">{{ $menunggu }}</p>
            </div>
            <div class="bg-green-100 shadow-xl rounded-2xl p-6 text-center">
                <p class="text-gray-500 text-sm">Terverifikasi</p>
                <p class="text-2xl font-bold text-green-600">{{ $terverifikasi }}</p>
            </div>
            <div class="bg-red-100 shadow-xl rounded-2xl p-6 text-center">
                <p class="text-gray-500 text-sm">Ditolak</p>
                <p class="text-2xl font-bold text-red-600">{{ $ditolak }}</p>
            </div>
        </div>

        <!-- Search dan Filter -->
        <div class="mb-6">
            <input type="text" id="search" placeholder="Cari resep..."
                class="w-full p-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
        </div>
        <div class="flex space-x-4 mb-6">
            <button type="button" onclick="loadResep('Menunggu Verifikasi')"
                class="tab-btn bg-blue-500 text-white px-4 py-2 rounded-xl shadow-md hover:bg-blue-600 transition">
                Menunggu Verifikasi
            </button>
            <button type="button" onclick="loadResep('Terverifikasi')"
                class="tab-btn bg-green-500 text-white px-4 py-2 rounded-xl shadow-md hover:bg-green-600 transition">
                Terverifikasi
            </button>
            <button type="button" onclick="loadResep('Ditolak')"
                class="tab-btn bg-red-500 text-white px-4 py-2 rounded-xl shadow-md hover:bg-red-600 transition">
                Ditolak
            </button>
        </div>

        <!-- Resep Container -->
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3" id="resepContainer">
            <!-- Data will be loaded here -->
        </div>
        <div id="paginationContainer" class="mt-6 flex justify-center space-x-2"></div>
    </div>

    <!-- Modal Verifikasi -->
    <div id="verifikasiModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="fixed inset-0 flex items-center justify-center">
            <div class="bg-white rounded-2xl p-6 w-full max-w-4xl mx-4">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-semibold">Verifikasi Resep</h3>
                    <button type="button" onclick="closeModal()" class="text-gray-500 hover:text-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form id="verifikasiForm" onsubmit="handleVerifikasiSubmit(event)">
                    @csrf
                    <input type="hidden" id="resepId" name="resep_id">

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Pasien</label>
                        <p id="modalPasienNama" class="mt-1 text-lg font-semibold"></p>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Daftar Obat</label>
                        <div id="obatListContainer" class="space-y-4"></div>
                        <button type="button" onclick="addObatField()"
                            class="mt-4 w-full py-2 px-4 border border-blue-500 text-blue-500 rounded-xl hover:bg-blue-50">
                            + Tambah Obat
                        </button>
                    </div>

                    <div class="mb-4">
                        <label for="catatan" class="block text-sm font-medium text-gray-700">Catatan</label>
                        <textarea id="catatan" name="catatan" rows="3" class="mt-1 w-full rounded-xl border-gray-300 shadow-sm"></textarea>
                    </div>

                    <div class="flex space-x-3">
                        <button type="submit"
                            class="flex-1 bg-green-500 text-white py-2 px-4 rounded-xl hover:bg-green-600">
                            Verifikasi
                        </button>
                        <button type="button" onclick="closeModal()"
                            class="flex-1 bg-gray-300 text-gray-700 py-2 px-4 rounded-xl hover:bg-gray-400">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const obatData = @json($obats);
        let currentStatus = 'Menunggu Verifikasi';
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        if (!csrfToken) {
            console.error('CSRF token not found');
        }

        // Load resep data
        async function loadResep(status = 'Menunggu Verifikasi', page = 1) {
            const container = document.getElementById('resepContainer');
            const paginationContainer = document.getElementById('paginationContainer');
            currentStatus = status;

            try {
                container.innerHTML = '<p class="col-span-full text-center">Loading...</p>';

                const searchQuery = document.getElementById('search').value;
                const response = await fetch(
                    `/admin/obat-resep/fetch?status=${status}&page=${page}&search=${searchQuery}`, {
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        }
                    });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();

                if (!data.data || data.data.length === 0) {
                    container.innerHTML =
                        '<p class="col-span-full text-center text-gray-500">Tidak ada resep yang ditemukan.</p>';
                    return;
                }

                container.innerHTML = '';
                data.data.forEach(resep => {
                    const card = createResepCard(resep);
                    container.appendChild(card);
                });

                updatePagination(data);
            } catch (error) {
                console.error('Error:', error);
                container.innerHTML =
                    '<p class="col-span-full text-center text-red-500">Terjadi kesalahan saat memuat data.</p>';
            }
        }

        function createResepCard(resep) {
            const div = document.createElement('div');
            div.className = 'bg-white shadow-xl rounded-2xl p-6 space-y-4';
            div.setAttribute('data-resep-id', resep.id);

            const content = `
        <div>
            <p class="text-gray-500 text-sm">Pasien</p>
            <p class="text-lg font-semibold">${resep.pasien?.name || resep.pasien_nama || '-'}</p>
        </div>
        <div>
            <p class="text-gray-500 text-sm">Dokter</p>
            <p class="text-lg font-semibold">${resep.dokter?.name || 'Resep Upload'}</p>
        </div>
        <div>
            <p class="text-gray-500 text-sm">Resep</p>
            ${renderResepContent(resep)}
        </div>
        ${currentStatus === 'Menunggu Verifikasi' ? `
                                            <div class="flex space-x-2">
                                                <button onclick="openVerifikasiModal('${resep.id}', ${JSON.stringify(resep).replace(/"/g, '&quot;')})" 
                                                    class="flex-1 bg-green-500 text-white px-4 py-2 rounded-xl hover:bg-green-600 transition">
                                                    ✅ Verifikasi
                                                </button>
                                                <button onclick="rejectResep('${resep.id}')" 
                                                    class="flex-1 bg-red-500 text-white px-4 py-2 rounded-xl hover:bg-red-600 transition">
                                                    ❌ Tolak
                                                </button>
                                            </div>
                                        ` : ''}
    `;

            div.innerHTML = content;
            return div;
        }

        function renderResepContent(resep) {
            if (resep.obats && Array.isArray(resep.obats) && resep.obats.length > 0) {
                return `
            <ul class="space-y-2">
                ${resep.obats.map(obat => `
                                                    <li>
                                                        <strong>R/ ${obat.nama || 'Nama tidak tersedia'}</strong>
                                                        ${obat.dosis ? `, ${obat.dosis}` : ''}
                                                    </li>
                                                `).join('')}
            </ul>
        `;
            } else if (resep.foto_resep) {
                const fotos = Array.isArray(resep.foto_resep) ? resep.foto_resep : [resep.foto_resep];
                return `
            <div class="flex space-x-2 overflow-x-auto scrollbar-hidden">
                ${fotos.map(foto => `
                                                    <img src="/storage/${foto}" 
                                                        alt="Resep" 
                                                        class="w-20 h-20 object-cover rounded-lg cursor-pointer hover:opacity-75 transition"
                                                        onclick="showImage('/storage/${foto}')">
                                                `).join('')}
            </div>
        `;
            }
            return '<p class="text-gray-500 text-center">Tidak ada data obat atau foto resep.</p>';
        }

        function updatePagination(data) {
            const container = document.getElementById('paginationContainer');
            if (!data.links || data.links.length <= 3) {
                container.innerHTML = '';
                return;
            }

            container.innerHTML = data.links
                .filter(link => link.url)
                .map(link => {
                    const page = new URL(link.url).searchParams.get('page');
                    return `
                <button 
                    onclick="loadResep('${currentStatus}', ${page})"
                    class="px-4 py-2 rounded-xl ${link.active 
                        ? 'bg-blue-500 text-white' 
                        : 'bg-white text-blue-500 border border-blue-500'}"
                >
                    ${link.label}
                </button>
            `;
                })
                .join('');
        }

        function openVerifikasiModal(resepId, resep) {
            const modal = document.getElementById('verifikasiModal');
            document.getElementById('resepId').value = resepId;
            document.getElementById('modalPasienNama').textContent = resep.pasien?.name || resep.pasien_nama || '-';

            const container = document.getElementById('obatListContainer');
            container.innerHTML = '';

            if (resep.obats && Array.isArray(resep.obats) && resep.obats.length > 0) {
                resep.obats.forEach(obat => addObatField(obat));
            } else {
                addObatField();
            }

            modal.classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('verifikasiModal').classList.add('hidden');
            document.getElementById('verifikasiForm').reset();
        }

        function addObatField(existingObat = null) {
            const container = document.getElementById('obatListContainer');
            const div = document.createElement('div');
            div.className = 'flex items-center space-x-2';

            div.innerHTML = `
        <select name="obat[]" class="flex-1 rounded-xl border-gray-300" required>
            <option value="">Pilih Obat</option>
            ${obatData.map(obat => `
                                                <option value="${obat.id}" ${existingObat && existingObat.id == obat.id ? 'selected' : ''}>
                                                    ${obat.nama} - ${obat.kekuatan_obat}
                                                </option>
                                            `).join('')}
        </select>
        <input 
            type="text" 
            name="dosis[]" 
            value="${existingObat?.dosis || ''}"
            placeholder="Dosis" 
            class="flex-1 rounded-xl border-gray-300" 
            required
        >
        <button type="button" onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    `;

            container.appendChild(div);
        }

        async function handleVerifikasiSubmit(event) {
            event.preventDefault();
            const form = event.target;
            const resepId = document.getElementById('resepId').value;

            if (!resepId) {
                showAlert('error', 'ID resep tidak ditemukan');
                return;
            }

            const formData = new FormData(form);

            // **Tambahkan log untuk melihat data sebelum dikirim**
            console.log("Data yang akan dikirim:");
            for (let pair of formData.entries()) {
                console.log(pair[0], pair[1]);
            }

            try {
                const response = await fetch(`/admin/obat-resep/verify/${resepId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                const result = await response.json();
                console.log("Response dari server:", result);

                if (result.success) {
                    showAlert('success', 'Resep berhasil diverifikasi');
                    closeModal();
                    loadResep(currentStatus);
                } else {
                    throw new Error(result.message || 'Gagal memverifikasi resep');
                }
            } catch (error) {
                console.error('Error:', error);
                showAlert('error', error.message || 'Terjadi kesalahan saat memverifikasi resep');
            }
        }

        async function rejectResep(resepId) {
            if (!resepId) {
                showAlert('error', 'ID resep tidak ditemukan');
                return;
            }

            if (!confirm('Apakah Anda yakin ingin menolak resep ini?')) {
                return;
            }

            try {
                const response = await fetch(`/admin/obat-resep/reject/${resepId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    // Tidak perlu Content-Type: application/json karena tidak ada body
                });

                if (!response.ok) {
                    const errorData = await response.json();
                    throw new Error(errorData.message || `HTTP error! status: ${response.status}`);
                }

                const result = await response.json();

                if (result.success) {
                    showAlert('success', 'Resep berhasil ditolak');
                    loadResep(currentStatus);
                } else {
                    throw new Error(result.message || 'Gagal menolak resep');
                }
            } catch (error) {
                console.error('Error:', error);
                showAlert('error', error.message || 'Terjadi kesalahan saat menolak resep');
            }
        }

        function showAlert(type, message) {
            // Remove existing alerts
            const existingAlerts = document.querySelectorAll('.alert-message');
            existingAlerts.forEach(alert => alert.remove());

            const alertDiv = document.createElement('div');
            alertDiv.className = `fixed top-4 right-4 p-4 rounded-xl shadow-lg z-50 alert-message ${
        type === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'
    }`;

            const icon = type === 'success' ? '✅' : '❌';
            alertDiv.textContent = `${icon} ${message}`;

            document.body.appendChild(alertDiv);

            // Remove the alert after 3 seconds
            setTimeout(() => {
                alertDiv.remove();
            }, 3000);
        }

        function showImage(url) {
            const modal = document.createElement('div');
            modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
            modal.onclick = () => modal.remove();

            const img = document.createElement('img');
            img.src = url;
            img.className = 'max-w-[90%] max-h-[90vh] object-contain';
            img.onclick = (e) => e.stopPropagation();

            modal.appendChild(img);
            document.body.appendChild(modal);
        }

        // Setup event listeners when document is ready
        document.addEventListener('DOMContentLoaded', function() {
            // Initial load
            loadResep();

            // Setup search functionality with debounce
            const searchInput = document.getElementById('search');
            let searchTimeout;

            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    loadResep(currentStatus);
                }, 500);
            });
        });
    </script>
@endsection
