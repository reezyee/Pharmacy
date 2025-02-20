@extends('layouts.user')

@section('content')
    <!-- pages/admin/resep.blade.php -->
    <div class="container mx-auto px-4 py-6 max-w-4xl">
        <!-- Header -->
        <h2 class="text-2xl font-medium text-gray-800 mb-6 flex items-center">
            <svg class="w-6 h-6 text-blue-500 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 16l4-4 4 4M12 12v8"></path>
            </svg>
            Manajemen Resep Obat
        </h2>

        <!-- Success Message -->
        @if (session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- Add Recipe Form -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
            <h3 class="text-lg font-medium text-gray-800 mb-4" id="form-title">Tambah Resep Baru</h3>
            <form id="resepForm" action="{{ route('admin.resep.store') }}" method="POST">
                @csrf
                <div id="method-update"></div>
                <div class="space-y-6">
                    <!-- Patient Selection -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pasien</label>
                        <select name="pasien" id="pasien"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-colors">
                        <option value="">Pilih Pasien</option>
                            @foreach ($pasiens as $pasien)
                                <option value="{{ $pasien->id }}">{{ $pasien->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Medicine Selection -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Obat</label>
                        <div id="obat-container" class="space-y-3">
                            <div class="flex items-center space-x-3">
                                <select name="obats[0][id]"
                                    class="flex-1 px-4 py-2.5 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-colors">
                                    <option value="">Pilih Obat</option>
                                    @foreach ($obats as $obat)
                                        <option value="{{ $obat->id }}">{{ $obat->nama }}</option>
                                    @endforeach
                                </select>
                                <input type="text" name="obats[0][dosis]" placeholder="Dosis"
                                    class="w-32 px-4 py-2.5 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-colors">
                                <button type="button"
                                    class="remove-obat h-10 w-10 flex items-center justify-center rounded-full bg-red-50 text-red-500 hover:bg-red-100 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <button type="button" id="add-obat"
                            class="mt-3 inline-flex items-center px-4 py-2 rounded-xl text-sm font-medium text-blue-600 bg-blue-50 hover:bg-blue-100 transition-colors">
                            <svg class="w-5 h-5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Tambah Obat
                        </button>
                    </div>

                    <div class="flex space-x-3">
                        <button type="submit"
                            class="flex-1 px-4 py-3 rounded-xl bg-blue-500 text-white font-medium hover:bg-blue-600 transition-colors">
                            Simpan Resep
                        </button>
                        <button type="button" id="cancelEdit"
                            class="hidden px-4 py-3 rounded-xl bg-gray-500 text-white font-medium hover:bg-gray-600 transition-colors">
                            Batal
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Recipe List -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-medium text-gray-800 mb-4">Daftar Resep</h3>

            <!-- Filters -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <input type="text" id="search" placeholder="Cari pasien..."
                    class="px-4 py-2.5 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-colors">
                <select id="filter-dokter"
                    class="px-4 py-2.5 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-colors">
                    <option value="">Semua Dokter</option>
                    @foreach ($dokters as $dokter)
                        <option value="{{ $dokter->name }}">{{ $dokter->name }}</option>
                    @endforeach
                </select>
                <input type="date" id="filter-date"
                    class="px-4 py-2.5 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-colors">
            </div>

            <!-- Recipe Cards -->
            <div class="grid md:grid-cols-2 gap-4" id="resep-list">
                @forelse($reseps as $resep)
                    <div class="recipe-card bg-gray-50 rounded-xl p-4 border border-gray-100"
                        data-resep-id="{{ $resep->id }}">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <h4 class="font-medium text-gray-800">{{ $resep->pasien->name ?? 'Tidak Ada' }}</h4>
                                <p class="text-sm text-gray-500">{{ $resep->dokter->name ?? 'Tidak Ada' }}</p>
                                <p class="text-sm text-gray-500">{{ $resep->created_at->format('d M Y') }}</p>
                            </div>
                            <div class="flex space-x-2">
                                <button class="edit-resep-btn" data-resep='@json($resep)'>Edit</button>
                                <form action="{{ route('admin.resep.destroy', $resep->id) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="h-8 w-8 flex items-center justify-center rounded-full bg-red-50 text-red-600 hover:bg-red-100 transition-colors"
                                        onclick="return confirm('Yakin ingin menghapus?')">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <ul class="space-y-2">
                            @foreach (json_decode($resep->obats, true) as $obat)
                                <li
                                    class="flex justify-between items-center bg-white px-4 py-2 rounded-lg border border-gray-100">
                                    <span class="text-gray-800">{{ $obat['nama'] }}</span>
                                    <span class="text-blue-600 font-medium">{{ $obat['dosis'] }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @empty
                    <p class="text-center col-span-2 py-8 text-gray-500">Tidak ada resep ditemukan.</p>
                @endforelse
            </div>

            <!-- Modal Edit Resep -->
            <div id="editResepModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-30 hidden">
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 w-full max-w-lg">
                    <h3 class="text-lg font-medium text-gray-800 mb-4">Edit Resep</h3>
                    <form id="editResepForm" action="{{ route('admin.resep.update', $resep->id) }}" method="POST">
                        @csrf
                        @method('PUT') <!-- This is crucial for method overriding -->
                        <div class="space-y-6">
                            <!-- Patient Selection -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Pasien</label>
                                <select name="pasien" id="edit-pasien"
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-colors">
                                    <option value="">Pilih Pasien</option>
                                    @foreach ($pasiens as $pasien)
                                        <option value="{{ $pasien->id }}">{{ $pasien->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Medicine Selection -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Obat</label>
                                <div id="edit-obat-container" class="space-y-3">
                                    <!-- Obat akan ditampilkan melalui JavaScript -->
                                </div>
                                <button type="button" id="edit-add-obat"
                                    class="mt-3 inline-flex items-center px-4 py-2 rounded-xl text-sm font-medium text-blue-600 bg-blue-50 hover:bg-blue-100 transition-colors">
                                    <svg class="w-5 h-5 mr-1.5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    Tambah Obat
                                </button>
                            </div>

                            <div class="flex space-x-3">
                                <button type="submit"
                                    class="flex-1 px-4 py-3 rounded-xl bg-blue-500 text-white font-medium hover:bg-blue-600 transition-colors">
                                    Simpan Perubahan
                                </button>
                                <button type="button" id="closeEditModal"
                                    class="px-4 py-3 rounded-xl bg-gray-500 text-white font-medium hover:bg-gray-600 transition-colors">
                                    Batal
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <script>
        // Add Medicine functionality
        document.getElementById('add-obat').addEventListener('click', function() {
            let index = document.querySelectorAll('#obat-container .flex').length;
            let container = document.getElementById('obat-container');
            let html = `
            <div class="flex items-center space-x-3">
                <select name="obats[${index}][id]" class="flex-1 px-4 py-2.5 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-colors">
                    @foreach ($obats as $obat)
                        <option value="{{ $obat->id }}">{{ $obat->nama }}</option>
                    @endforeach
                </select>
                <input type="text" name="obats[${index}][dosis]" placeholder="Dosis" class="w-32 px-4 py-2.5 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-colors">
                <button type="button" class="remove-obat h-10 w-10 flex items-center justify-center rounded-full bg-red-50 text-red-500 hover:bg-red-100 transition-colors">
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
            const editObatContainer = document.getElementById("edit-obat-container");
            const editResepForm = document.getElementById("editResepForm");

            // Function to show modal
            function openEditModal(resep) {
                editResepForm.action = "{{ route('admin.resep.update', '') }}/" + resep.id;
                document.getElementById("edit-pasien").value = resep.pasien_id;
                document.getElementById("method-update").innerHTML =
                    `<input type="hidden" name="_method" value="PUT">`;

                // Clear existing obat fields
                editObatContainer.innerHTML = "";

                // Ensure `resep.obats` is an array
                const obats = Array.isArray(resep.obats) ? resep.obats : JSON.parse(resep.obats);

                // Populate obat fields
                obats.forEach((obat, index) => {
                    addEditObatField(index, obat.id, obat.dosis);
                });

                editModal.classList.remove("hidden");
            }

            // Function to add medicine input field
            function addEditObatField(index, selectedId = "", dosis = "") {
                const obatOptions = `{!! json_encode($obats->map(fn($obat) => ['id' => $obat->id, 'nama' => $obat->nama])) !!}`;
                let obatList = JSON.parse(obatOptions);

                let obatField = document.createElement("div");
                obatField.classList.add("flex", "items-center", "space-x-3");

                let select = document.createElement("select");
                select.name = `obats[${index}][id]`;
                select.classList.add("flex-1", "px-4", "py-2.5", "rounded-xl", "border", "border-gray-200",
                    "focus:border-blue-500", "focus:ring-2", "focus:ring-blue-200", "transition-colors");
                obatList.forEach(obat => {
                    let option = document.createElement("option");
                    option.value = obat.id;
                    option.textContent = obat.nama;
                    if (obat.id == selectedId) option.selected = true;
                    select.appendChild(option);
                });

                let input = document.createElement("input");
                input.type = "text";
                input.name = `obats[${index}][dosis]`;
                input.placeholder = "Dosis";
                input.value = dosis;
                input.classList.add("w-32", "px-4", "py-2.5", "rounded-xl", "border", "border-gray-200",
                    "focus:border-blue-500", "focus:ring-2", "focus:ring-blue-200", "transition-colors");

                let removeBtn = document.createElement("button");
                removeBtn.type = "button";
                removeBtn.innerHTML = `
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 18L18 6M6 6l12 12" />
                </svg>`;
                removeBtn.classList.add("remove-obat", "h-10", "w-10", "flex", "items-center", "justify-center",
                    "rounded-full", "bg-red-50", "text-red-500", "hover:bg-red-100", "transition-colors");

                removeBtn.addEventListener("click", function() {
                    obatField.remove();
                });

                obatField.appendChild(select);
                obatField.appendChild(input);
                obatField.appendChild(removeBtn);
                editObatContainer.appendChild(obatField);
            }

            // Handle add new medicine field
            document.getElementById("edit-add-obat").addEventListener("click", function() {
                let index = editObatContainer.children.length;
                addEditObatField(index);
            });

            // Handle close modal
            closeEditBtn.addEventListener("click", function() {
                editModal.classList.add("hidden");
            });

            // Handle open modal (attach to edit buttons dynamically)
            document.querySelectorAll(".edit-resep-btn").forEach(button => {
                button.addEventListener("click", function() {
                    let resep = JSON.parse(this.getAttribute("data-resep"));
                    openEditModal(resep);
                });
            });
        });

        // Enhanced filtering system
        const searchInput = document.getElementById('search');
        const doctorFilter = document.getElementById('filter-dokter');
        const dateFilter = document.getElementById('filter-date');
        const recipeCards = document.querySelectorAll('.recipe-card');

        function filterRecipes() {
            const searchText = searchInput.value.toLowerCase();
            const selectedDoctor = doctorFilter.value.toLowerCase();
            const selectedDate = dateFilter.value;

            recipeCards.forEach(card => {
                const patientName = card.querySelector('h4').textContent.toLowerCase();
                const doctorName = card.querySelector('p').textContent.toLowerCase();
                const cardDate = card.querySelector('p:nth-child(3)').textContent;

                const matchesSearch = patientName.includes(searchText);
                const matchesDoctor = !selectedDoctor || doctorName.includes(selectedDoctor);
                const matchesDate = !selectedDate || cardDate.includes(selectedDate);

                card.style.display = (matchesSearch && matchesDoctor && matchesDate) ? '' : 'none';
            });
        }

        // Add event listeners for all filters
        searchInput.addEventListener('input', filterRecipes);
        doctorFilter.addEventListener('change', filterRecipes);
        dateFilter.addEventListener('input', filterRecipes);
    </script>
@endsection
