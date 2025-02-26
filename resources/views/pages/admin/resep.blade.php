@extends('layouts.user')

@section('content')
    <!-- pages/admin/resep.blade.php -->
    <div class="container mx-auto px-4 py-8 max-w-5xl">
        <!-- Header -->
        <h2 class="text-3xl font-light text-gray-800 mb-8 flex items-center">
            <svg class="w-7 h-7 text-purple-500 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 16l4-4 4 4M12 12v8"></path>
            </svg>
            Manajemen Resep Obat
        </h2>

        <!-- Success Message -->
        @if (session('success'))
            <div
                class="bg-green-500 bg-opacity-10 backdrop-blur-sm border border-green-200 text-green-700 px-6 py-4 rounded-lg mb-8 shadow-sm transition-all duration-300 transform hover:scale-[1.01]">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 gap-8">
            <!-- Add Recipe Form -->
            <div
                class="bg-white bg-opacity-80 backdrop-blur-sm rounded-xl shadow-md border border-gray-100 p-8 mb-8 transition-all duration-300 transform hover:shadow-lg">
                <h3 class="text-xl font-normal text-gray-800 mb-6 border-b pb-3" id="form-title">Tambah Resep Baru</h3>
                <form id="resepForm" action="{{ route('admin.resep.store') }}" method="POST">
                    @csrf
                    <div id="method-update"></div>
                    <div class="space-y-6">
                        <!-- Patient Selection -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Pasien</label>
                            <div class="relative">
                                <select name="pasien" id="pasien"
                                    class="w-full px-4 py-3 rounded-lg border-0 bg-gray-50 focus:ring-2 focus:ring-purple-500 transition-all appearance-none">
                                    <option value="">Pilih Pasien</option>
                                    @foreach ($pasiens as $pasien)
                                        <option value="{{ $pasien->id }}">{{ $pasien->name }}</option>
                                    @endforeach
                                </select>
                                <div
                                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Medicine Selection -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Obat</label>
                            <div id="obat-container" class="space-y-3" data-options='@json($obats)'>
                                <div class="flex items-center space-x-3">
                                    <div class="relative flex-1">
                                        <select name="obats[0][id]"
                                            class="w-full px-4 py-3 rounded-lg border-0 bg-gray-50 focus:ring-2 focus:ring-purple-500 transition-all appearance-none">
                                            <option value="">Pilih Obat</option>
                                            @foreach ($obats as $obat)
                                                <option value="{{ $obat->id }}">{{ $obat->nama }} -
                                                    {{ $obat->kekuatan_obat }}</option>
                                            @endforeach
                                        </select>
                                        <div
                                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <input type="text" name="obats[0][dosis]" placeholder="Dosis"
                                        class="w-32 px-4 py-3 rounded-lg border-0 bg-gray-50 focus:ring-2 focus:ring-purple-500 transition-all">
                                    <button type="button"
                                        class="remove-obat h-12 w-12 flex items-center justify-center rounded-full bg-red-50 text-red-500 hover:bg-red-100 transition-all hover:shadow-md">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <button type="button" id="add-obat"
                                class="mt-4 inline-flex items-center px-4 py-2 rounded-full text-sm font-medium text-purple-600 bg-purple-50 hover:bg-purple-100 transition-all shadow-sm hover:shadow">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Tambah Obat
                            </button>
                        </div>

                        <div class="flex space-x-3 pt-4">
                            <button type="submit"
                                class="flex-1 px-6 py-3 rounded-lg bg-purple-600 text-white font-medium hover:bg-purple-700 transition-all shadow-sm hover:shadow-md">
                                <div class="flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Simpan Resep
                                </div>
                            </button>
                            <button type="button" id="cancelEdit"
                                class="hidden px-6 py-3 rounded-lg bg-gray-500 text-white font-medium hover:bg-gray-600 transition-all shadow-sm hover:shadow-md">
                                Batal
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Recipe List -->
            <div
                class="bg-white bg-opacity-80 backdrop-blur-sm rounded-xl shadow-md border border-gray-100 p-8 transition-all duration-300 transform hover:shadow-lg">
                <h3 class="text-xl font-normal text-gray-800 mb-6 border-b pb-3">Daftar Resep</h3>

                <!-- Filters -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" id="search" placeholder="Cari pasien..."
                            class="pl-10 w-full px-4 py-3 rounded-lg border-0 bg-gray-50 focus:ring-2 focus:ring-purple-500 transition-all">
                    </div>
                    <div class="relative">
                        <select id="filter-dokter"
                            class="w-full px-4 py-3 rounded-lg border-0 bg-gray-50 focus:ring-2 focus:ring-purple-500 transition-all appearance-none">
                            <option value="">Semua Dokter</option>
                            @foreach ($dokters as $dokter)
                                <option value="{{ $dokter->name }}">{{ $dokter->name }}</option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        <input type="date" id="filter-date"
                            class="pl-10 w-full px-4 py-3 rounded-lg border-0 bg-gray-50 focus:ring-2 focus:ring-purple-500 transition-all">
                    </div>
                </div>

                <!-- Recipe Cards -->
                <div class="space-y-4" id="resep-list">
                    @forelse($reseps as $resep)
                        <div class="recipe-card bg-gradient-to-br from-white to-gray-50 backdrop-blur-sm rounded-xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition-all duration-300"
                            data-resep-id="{{ $resep->id }}">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h4 class="font-medium text-gray-800 text-lg">
                                        {{ $resep->pasien->name ?? 'Tidak Ada' }}</h4>
                                    <div class="flex items-center text-sm text-gray-500 mt-1">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                            </path>
                                        </svg>
                                        <span>{{ $resep->dokter->name ?? 'Tidak Ada' }}</span>
                                    </div>
                                    <div class="flex items-center text-sm text-gray-500 mt-1">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        <span>{{ $resep->created_at->format('d M Y') }}</span>
                                    </div>
                                </div>
                                <div class="flex space-x-2">
                                    <button
                                        class="edit-resep-btn h-10 w-10 flex items-center justify-center rounded-full bg-purple-50 text-purple-600 hover:bg-purple-100 transition-all hover:shadow-sm"
                                        data-resep='@json($resep)'>
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                    </button>
                                    <form action="{{ route('admin.resep.destroy', $resep->id) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="h-10 w-10 flex items-center justify-center rounded-full bg-red-50 text-red-600 hover:bg-red-100 transition-all hover:shadow-sm"
                                            onclick="return confirm('Yakin ingin menghapus?')">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <ul class="space-y-2">
                                @if (!empty($resep->obats))
                                    @foreach ($resep->obats as $obat)
                                        <li
                                            class="flex justify-between items-center bg-white px-4 py-3 rounded-lg border border-gray-100 hover:shadow-sm transition-all">
                                            <div class="flex items-center">
                                                <svg class="w-5 h-5 text-purple-500 mr-2" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                                    </path>
                                                </svg>
                                                <span class="text-gray-800">{{ $obat['nama'] }}</span>
                                            </div>
                                            <span
                                                class="text-purple-600 font-medium px-3 py-1 bg-purple-50 rounded-full">{{ $obat['dosis'] }}</span>
                                        </li>
                                    @endforeach
                                @else
                                    <p class="text-gray-500 p-4 bg-gray-50 rounded-lg text-center">Tidak ada obat dalam
                                        resep ini.</p>
                                @endif
                            </ul>
                        </div>
                    @empty
                        <div class="text-center py-12 bg-gray-50 rounded-xl">
                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                            <p class="text-gray-500">Tidak ada resep ditemukan.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Modal Edit Resep -->
        <div id="editResepModal"
            class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 backdrop-blur-sm hidden z-50 transition-opacity duration-300">
            <div
                class="bg-white bg-opacity-90 rounded-xl shadow-lg border border-gray-100 p-8 w-full max-w-2xl m-4 transition-all duration-300 transform">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-normal text-gray-800">Edit Resep</h3>
                    <button id="closeEditModal" class="text-gray-500 hover:text-gray-700 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <form id="editResepForm" action="" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="space-y-6">
                        <!-- Patient Selection -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Pasien</label>
                            <div class="relative">
                                <select name="pasien" id="edit-pasien"
                                    class="w-full px-4 py-3 rounded-lg border-0 bg-gray-50 focus:ring-2 focus:ring-purple-500 transition-all appearance-none">
                                    <option value="">Pilih Pasien</option>
                                    @foreach ($pasiens as $pasien)
                                        <option value="{{ $pasien->id }}">{{ $pasien->name }}</option>
                                    @endforeach
                                </select>
                                <div
                                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Medicine Selection -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Obat</label>

                            @php
                                $obatOptions = $obats->map(
                                    fn($obat) => [
                                        'id' => $obat->id,
                                        'nama' => $obat->nama,
                                        'kekuatan_obat' => $obat->kekuatan_obat,
                                    ],
                                );
                            @endphp

                            <!-- Tambahkan ini di dalam modal edit -->
                            <div id="obat-container" data-options='@json($obatOptions)'></div>

                            <div id="edit-obat-container" class="space-y-3">
                                <!-- Obat akan ditampilkan melalui JavaScript -->
                            </div>
                            <button type="button" id="edit-add-obat"
                                class="mt-4 inline-flex items-center px-4 py-2 rounded-full text-sm font-medium text-purple-600 bg-purple-50 hover:bg-purple-100 transition-all shadow-sm hover:shadow">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Tambah Obat
                            </button>
                        </div>

                        <div class="flex space-x-3 pt-4">
                            <button type="submit"
                                class="flex-1 px-6 py-3 rounded-lg bg-purple-600 text-white font-medium hover:bg-purple-700 transition-all shadow-sm hover:shadow-md">
                                <div class="flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Simpan Perubahan
                                </div>
                            </button>
                            <button type="button" id="closeEditModalBtn"
                                class="px-6 py-3 rounded-lg bg-gray-500 text-white font-medium hover:bg-gray-600 transition-all shadow-sm hover:shadow-md">
                                Batal
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Add Medicine functionality
        document.getElementById('add-obat').addEventListener('click', function() {
            let index = document.querySelectorAll('#obat-container .flex').length;
            let container = document.getElementById('obat-container');
            let obatOptions = JSON.parse(container.dataset.options || '[]');

            let selectOptions = `<option value="">Pilih Obat</option>`;
            obatOptions.forEach(obat => {
                selectOptions += `<option value="${obat.id}">${obat.nama} - ${obat.kekuatan_obat}</option>`;
            });

            let html = `
            <div class="flex items-center space-x-3">
                <div class="relative flex-1">
                    <select name="obats[${index}][id]" class="w-full px-4 py-3 rounded-lg border-0 bg-gray-50 focus:ring-2 focus:ring-purple-500 transition-all appearance-none">
                        ${selectOptions}
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>
                <input type="text" name="obats[${index}][dosis]" placeholder="Dosis" class="w-32 px-4 py-3 rounded-lg border-0 bg-gray-50 focus:ring-2 focus:ring-purple-500 transition-all">
                <button type="button" class="remove-obat h-12 w-12 flex items-center justify-center rounded-full bg-red-50 text-red-500 hover:bg-red-100 transition-all hover:shadow-md">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>`;

            container.insertAdjacentHTML('beforeend', html);
            updateRemoveButtons();
        });

        function updateRemoveButtons() {
            document.querySelectorAll('.remove-obat').forEach(button => {
                button.addEventListener('click', function() {
                    this.parentElement.remove();
                });
            });
        }
        updateRemoveButtons();

        document.addEventListener("DOMContentLoaded", function() {
            const editModal = document.getElementById("editResepModal");
            const closeEditBtn = document.getElementById("closeEditModal");
            const closeEditModalBtn = document.getElementById("closeEditModalBtn");
            const editObatContainer = document.getElementById("edit-obat-container");
            const editResepForm = document.getElementById("editResepForm");
            const addEditObatBtn = document.getElementById("edit-add-obat");

            // Event untuk membuka modal edit
            document.querySelectorAll(".edit-resep-btn").forEach(button => {
                button.addEventListener("click", function() {
                    try {
                        let resep = JSON.parse(this.dataset.resep);
                        openEditModal(resep);
                    } catch (error) {
                        console.error("Gagal parsing JSON:", error);
                    }
                });
            });

            function openEditModal(resep) {
                editResepForm.action = `/admin/resep/${resep.id}`;
                document.getElementById("edit-pasien").value = resep.pasien_id;
                document.getElementById("method-update").innerHTML =
                    `<input type="hidden" name="_method" value="PUT">`;

                editObatContainer.innerHTML = "";
                let obats = Array.isArray(resep.obats) ? resep.obats : Object.values(resep.obats || {});
                let obatOptions = JSON.parse(document.getElementById("obat-container").dataset.options || '[]');

                obats.forEach((obat, index) => {
                    addEditObatField(index, obat.id, obat.dosis, obatOptions);
                });

                editModal.classList.remove("hidden");
                editModal.classList.add("flex");

                // Add animation classes
                setTimeout(() => {
                    editModal.querySelector('div').classList.add('scale-100');
                    editModal.querySelector('div').classList.remove('scale-95');
                }, 10);
            }

            function addEditObatField(index, selectedId = "", dosis = "", obatOptions) {
                let selectOptions = obatOptions.map(obat => {
                    // Format teks yang akan ditampilkan di opsi
                    let obatText = `${obat.nama} - ${obat.kekuatan_obat}`;
                    return `<option value="${obat.id}" ${obat.id == selectedId ? "selected" : ""}>${obatText}</option>`;
                }).join("");

                let html = `
                <div class="flex items-center space-x-3">
                    <div class="relative flex-1">
                        <select name="obats[${index}][id]" class="w-full px-4 py-3 rounded-lg border-0 bg-gray-50 focus:ring-2 focus:ring-purple-500 transition-all appearance-none">
                            <option value="">Pilih Obat</option>
                            ${selectOptions}
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                    <input type="text" name="obats[${index}][dosis]" value="${dosis}" class="w-32 px-4 py-3 rounded-lg border-0 bg-gray-50 focus:ring-2 focus:ring-purple-500 transition-all">
                    <button type="button" class="remove-edit-obat h-12 w-12 flex items-center justify-center rounded-full bg-red-50 text-red-500 hover:bg-red-100 transition-all hover:shadow-md">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
    </svg>
</button>
</div>`;

                editObatContainer.insertAdjacentHTML('beforeend', html);
                updateEditRemoveButtons();
            }

            function updateEditRemoveButtons() {
                document.querySelectorAll('.remove-edit-obat').forEach(button => {
                    button.addEventListener('click', function() {
                        this.parentElement.remove();
                    });
                });
            }

            // Add more medicines to the edit form
            addEditObatBtn.addEventListener('click', function() {
                let index = document.querySelectorAll('#edit-obat-container .flex').length;
                let obatOptions = JSON.parse(document.getElementById("obat-container").dataset.options ||
                    '[]');
                addEditObatField(index, "", "", obatOptions);
            });

            // Close modal events
            closeEditBtn.addEventListener("click", closeEditModal);
            closeEditModalBtn.addEventListener("click", closeEditModal);

            // Close when clicking outside the modal content
            editModal.addEventListener("click", function(e) {
                if (e.target === editModal) {
                    closeEditModal();
                }
            });

            function closeEditModal() {
                // Add animation before hiding
                editModal.querySelector('div').classList.add('scale-95');
                editModal.querySelector('div').classList.remove('scale-100');

                setTimeout(() => {
                    editModal.classList.add("hidden");
                    editModal.classList.remove("flex");
                }, 200);
            }

            // Search and filter functionality
            const searchInput = document.getElementById('search');
            const filterDokter = document.getElementById('filter-dokter');
            const filterDate = document.getElementById('filter-date');
            const resepList = document.getElementById('resep-list');

            function applyFilters() {
                const searchTerm = searchInput.value.toLowerCase();
                const dokterFilter = filterDokter.value;
                const dateFilter = filterDate.value;

                document.querySelectorAll('.recipe-card').forEach(card => {
                    const pasienName = card.querySelector('h4').textContent.toLowerCase();
                    const dokterName = card.querySelector('.text-gray-500 span').textContent;
                    const cardDate = new Date(card.querySelector('.text-gray-500:nth-child(3) span')
                        .textContent);

                    let showCard = true;

                    if (searchTerm && !pasienName.includes(searchTerm)) {
                        showCard = false;
                    }

                    if (dokterFilter && dokterName !== dokterFilter) {
                        showCard = false;
                    }

                    if (dateFilter) {
                        const filterDateObj = new Date(dateFilter);
                        if (cardDate.toDateString() !== filterDateObj.toDateString()) {
                            showCard = false;
                        }
                    }

                    card.style.display = showCard ? 'block' : 'none';
                });
            }

            searchInput.addEventListener('input', applyFilters);
            filterDokter.addEventListener('change', applyFilters);
            filterDate.addEventListener('change', applyFilters);

            // Cancel edit button for the main form
            document.getElementById('cancelEdit').addEventListener('click', function() {
                document.getElementById('resepForm').reset();
                document.getElementById('form-title').textContent = 'Tambah Resep Baru';
                document.getElementById('resepForm').action = "{{ route('admin.resep.store') }}";
                document.getElementById('method-update').innerHTML = '';
                this.classList.add('hidden');
            });
        });
    </script>
@endsection
