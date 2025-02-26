@extends('layouts.user')

@section('content')
    <div class="container mx-auto px-4 md:px-6 py-8">
        <h1 class="mb-8 p-6 bg-white/60 backdrop-b  lur-md rounded-xl shadow-md border-l-4 border-purple-500">
            <span class="material-icons align-bottom mr-2">assignment</span>Verifikasi Resep
        </h1>

        @if (session('success'))
            <div class="flex items-center p-4 mb-4 rounded-lg bg-green-50 border-l-4 border-green-500 shadow-sm">
                <span class="material-icons text-green-500 mr-2">check_circle</span>
                <span class="text-green-800">{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="flex items-center p-4 mb-4 rounded-lg bg-red-50 border-l-4 border-red-500 shadow-sm">
                <span class="material-icons text-red-500 mr-2">error</span>
                <span class="text-red-800">{{ session('error') }}</span>
            </div>
        @endif

        <!-- Statistik Resep Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-lg shadow p-5 text-center transition-shadow hover:shadow-md">
                <p class="text-gray-600 text-sm mb-1">Total Resep</p>
                <p class="text-2xl font-medium text-gray-900">{{ $totalResep }}</p>
            </div>
            <div class="bg-white rounded-lg shadow p-5 text-center transition-shadow hover:shadow-md">
                <p class="text-gray-600 text-sm mb-1">Menunggu Verifikasi</p>
                <p class="text-2xl font-medium text-amber-600">{{ $menunggu }}</p>
                <div class="w-full h-1 bg-amber-500 mt-2 rounded-full"></div>
            </div>
            <div class="bg-white rounded-lg shadow p-5 text-center transition-shadow hover:shadow-md">
                <p class="text-gray-600 text-sm mb-1">Terverifikasi</p>
                <p class="text-2xl font-medium text-green-600">{{ $terverifikasi }}</p>
                <div class="w-full h-1 bg-green-500 mt-2 rounded-full"></div>
            </div>
            <div class="bg-white rounded-lg shadow p-5 text-center transition-shadow hover:shadow-md">
                <p class="text-gray-600 text-sm mb-1">Ditolak</p>
                <p class="text-2xl font-medium text-red-600">{{ $ditolak }}</p>
                <div class="w-full h-1 bg-red-500 mt-2 rounded-full"></div>
            </div>
        </div>

        <!-- Search Input with Material Design -->
        <div class="mb-6 relative">
            <div class="flex items-center bg-white rounded-lg shadow overflow-hidden">
                <span class="material-icons text-gray-400 ml-3">search</span>
                <input type="text" id="search" placeholder="Cari resep..."
                    class="w-full p-3 border-0 focus:ring-0 focus:outline-none">
            </div>
        </div>

        <!-- Tab Buttons with Material Design -->
        <div class="flex flex-wrap space-x-0 space-y-2 md:space-x-4 md:space-y-0 mb-6">
            <button onclick="fetchResep('dokter')"
                class="tab-btn group bg-white text-gray-700 px-4 py-2 rounded-lg shadow transition-all hover:shadow-md flex items-center">
                <span class="material-icons mr-2 text-sm group-hover:text-blue-600">local_hospital</span>Resep dari Dokter
            </button>
            <button onclick="fetchResep('Menunggu Verifikasi')"
                class="tab-btn group bg-white text-gray-700 px-4 py-2 rounded-lg shadow transition-all hover:shadow-md flex items-center">
                <span class="material-icons mr-2 text-sm group-hover:text-amber-600">hourglass_empty</span>Menunggu Verifikasi
            </button>
            <button onclick="fetchResep('Terverifikasi')"
                class="tab-btn group bg-white text-gray-700 px-4 py-2 rounded-lg shadow transition-all hover:shadow-md flex items-center">
                <span class="material-icons mr-2 text-sm group-hover:text-green-500" >check_circle</span>Terverifikasi
            </button>
            <button onclick="fetchResep('Ditolak')"
                class="tab-btn group bg-white text-gray-700 px-4 py-2 rounded-lg shadow transition-all hover:shadow-md flex items-center">
                <span class="material-icons mr-2 text-sm group-hover:text-red-500">cancel</span>Ditolak
            </button>
        </div>

        <!-- Resep Container -->
        <div id="resepContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"></div>
    </div>

    <!-- Image Modal with Material Design -->
    <div id="imageModal" class="hidden fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50">
        <div id="modalContainer" class="relative bg-white rounded-lg p-2 max-w-[90%] max-h-[90vh]">
            <button class="absolute top-2 right-2 bg-white rounded-full p-1 shadow-md z-10" onclick="closeModal()">
                <span class="material-icons text-gray-600">close</span>
            </button>
            <img id="modalImage" src="" class="max-w-full max-h-[85vh] object-contain rounded">
        </div>
    </div>

    <script>
        // Ensure Material Icons is loaded
        document.addEventListener("DOMContentLoaded", function() {
            // If Material Icons isn't already included in your layout, add it here
            if (!document.querySelector('link[href*="material-icons"]')) {
                const link = document.createElement('link');
                link.rel = 'stylesheet';
                link.href = 'https://fonts.googleapis.com/icon?family=Material+Icons';
                document.head.appendChild(link);
            }
        });

        function openModal(imageUrl) {
            let modal = document.getElementById("imageModal");
            let modalImage = document.getElementById("modalImage");
            if (modal && modalImage) {
                modalImage.src = imageUrl;
                modal.classList.remove("hidden");
                // Add animation
                document.getElementById("modalContainer").classList.add("animate-fadeIn");
            } else {
                console.error("Modal tidak ditemukan!");
            }
        }

        function closeModal() {
            let modal = document.getElementById("imageModal");
            if (modal) {
                modal.classList.add("hidden");
            }
        }

        // Tutup modal saat klik di luar gambar
        if (document.getElementById("imageModal")) {
            document.getElementById("imageModal").addEventListener("click", function(event) {
                let modalContainer = document.getElementById("modalContainer");
                if (!modalContainer.contains(event.target)) {
                    closeModal();
                }
            });
        }

        // Tab selection with ripple effect
        document.querySelectorAll(".tab-btn").forEach(btn => {
            btn.addEventListener("click", function() {
                document.querySelectorAll(".tab-btn").forEach(b => {
                    b.classList.remove("bg-primary-500");
                    b.classList.add("bg-white");
                });
                this.classList.add("bg-primary-500");
                this.classList.remove("bg-white");

                // Add ripple effect
                let ripple = document.createElement("span");
                ripple.classList.add("ripple");
                this.appendChild(ripple);
                setTimeout(() => ripple.remove(), 600);
            });
        });

        // Filter pencarian resep
        if (document.getElementById("search")) {
            document.getElementById("search").addEventListener("input", function() {
                let query = this.value.toLowerCase().trim();
                document.querySelectorAll(".resep-item").forEach(item => {
                    let nama = item.getAttribute("data-name").toLowerCase();
                    item.style.display = nama.includes(query) ? "block" : "none";
                });
            });
        }

        document.addEventListener("DOMContentLoaded", function() {
            fetchResep('Menunggu Verifikasi', 1);

            // Set the initial active tab
            document.querySelectorAll(".tab-btn").forEach(btn => {
                if (btn.textContent.includes("Menunggu Verifikasi")) {
                    btn.classList.add("bg-primary-600");
                    btn.classList.add("text-gray-700");
                    btn.classList.remove("bg-white");
                    btn.classList.remove("text-gray-600");
                }
            });
        });

        function fetchResep(status, page = 1) {
            let container = document.getElementById("resepContainer");
            container.innerHTML = `
                <div class="col-span-full flex justify-center items-center py-8">
                    <div class="animate-spin rounded-full h-10 w-10 border-b-2 border-primary-500"></div>
                </div>`;

            fetch("{{ route('user.resep.fetch') }}?status=" + encodeURIComponent(status), {
                    headers: {
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (!data || !Array.isArray(data.data) || data.data.length === 0) {
                        container.innerHTML = `
                            <div class="col-span-full text-center py-8">
                                <span class="material-icons text-4xl text-gray-400">search_off</span>
                                <p class="text-gray-500 mt-2">Tidak ada resep ditemukan.</p>
                            </div>`;
                        return;
                    }

                    container.innerHTML = "";

                    data.data.filter(resep => status !== 'dokter' || (resep.sumber && resep.sumber.toLowerCase() ===
                            'dokter'))
                        .forEach(resep => {
                            let fotoResepHtml = (resep.foto_resep || []).map(foto => `
                                <img class="w-20 h-20 object-cover rounded-lg cursor-pointer hover:opacity-75 transition" 
                                    src="/storage/${foto}" 
                                    onclick="openModal('/storage/${foto}')" 
                                    alt="Foto Resep">
                            `).join("");

                            let obats = (resep.obats && Object.keys(resep.obats).length > 0) ?
                                Object.values(resep.obats).map(obat => `
                                    <div class="flex justify-between border-b pb-2">
                                        <div class="flex items-center">
                                            <span class="material-icons text-primary-500 text-sm mr-1">medication</span>
                                            <span class="text-gray-900">${obat.nama}</span>
                                        </div>
                                        <span class="text-gray-600">${obat.dosis}</span>
                                    </div>
                                `).join("") : `
                                    <div class="text-center py-4">
                                        <span class="material-icons text-gray-400">inventory_2</span>
                                        <p class='text-gray-500'>Tidak ada obat.</p>
                                    </div>`;

                            let statusInfo = {
                                "pending": {
                                    color: "amber",
                                    icon: "hourglass_empty",
                                    text: "Pending"
                                },
                                "Menunggu Verifikasi": {
                                    color: "blue",
                                    icon: "pending_actions",
                                    text: "Menunggu Verifikasi"
                                },
                                "Terverifikasi": {
                                    color: "green",
                                    icon: "check_circle",
                                    text: "Terverifikasi"
                                },
                                "Ditolak": {
                                    color: "red",
                                    icon: "cancel",
                                    text: "Ditolak"
                                }
                            } [resep.status] || {
                                color: "gray",
                                icon: "help",
                                text: resep.status
                            };

                            let resepHtml = `
                                <div class="bg-white rounded-lg shadow hover:shadow-md transition-shadow p-6 space-y-4 resep-item" data-name="${resep.pasien_nama}">
                                    <div class="flex justify-between items-center">
                                        <div class="flex items-center">
                                            <span class="material-icons text-gray-400 mr-1">person</span>
                                            <p class="text-gray-500 text-sm">Pasien</p>
                                        </div>
                                        <div class="flex items-center text-${statusInfo.color}-600 bg-${statusInfo.color}-50 px-2 py-1 rounded-full">
                                            <span class="material-icons text-${statusInfo.color}-600 text-xs mr-1">${statusInfo.icon}</span>
                                            <span class="text-xs">${statusInfo.text}</span>
                                        </div>
                                    </div>
                                    <p class="text-lg font-medium text-gray-900">${resep.pasien_nama || '-'}</p>
                                    
                                    <div class="flex items-center">
                                        <span class="material-icons text-gray-400 mr-1">medical_services</span>
                                        <p class="text-gray-500 text-sm">Dokter</p>
                                    </div>
                                    <p class="text-lg font-medium text-gray-900">${resep.dokter || 'Resep Upload'}</p>
                                    
                                    <div class="flex items-center">
                                        <span class="material-icons text-gray-400 mr-1">photo_library</span>
                                        <p class="text-gray-500 text-sm">Foto Resep</p>
                                    </div>
                                    <div class="flex space-x-2 overflow-x-auto py-1 scrollbar-thin scrollbar-thumb-gray-300">${fotoResepHtml}</div>
                                    
                                    <div class="flex items-center">
                                        <span class="material-icons text-gray-400 mr-1">medication</span>
                                        <p class="text-gray-500 text-sm">Obat yang Diresepkan</p>
                                    </div>
                                    <div class="space-y-2">${obats}</div>
                                    
                                    ${resep.status === 'pending' && resep.sumber.toLowerCase() === 'dokter' ? `
                                            <button onclick="ajukanVerifikasi(${resep.id})" 
                                                class="w-full mt-2 flex items-center justify-center bg-amber-500 text-white px-4 py-2 rounded-lg shadow hover:bg-amber-600 transition">
                                                <span class="material-icons mr-1">send</span>
                                                Ajukan Verifikasi
                                            </button>
                                        ` : ''}
                                    
                                    ${resep.status === 'Terverifikasi' ? `
                                            <a href="{{ url('/checkout/resep') }}/${resep.id}" 
                                                class="w-full mt-2 flex items-center justify-center bg-green-500 text-white px-4 py-2 rounded-lg shadow hover:bg-green-600 transition">
                                                <span class="material-icons mr-1">shopping_cart</span>
                                                Tebus Obat
                                            </a>
                                        ` : ''}
                                </div>`;

                            container.innerHTML += resepHtml;
                        });
                })
                .catch(error => {
                    console.error("Error fetching data:", error);
                    container.innerHTML = `
                        <div class="col-span-full text-center py-8">
                            <span class="material-icons text-4xl text-red-500">error</span>
                            <p class='text-red-500 mt-2'>Gagal mengambil data. Coba lagi.</p>
                        </div>`;
                });
        }

        window.fetchResep = fetchResep;

        function ajukanVerifikasi(resepId) {
            // Add loading state to button
            const btn = event.target.closest('button');
            const originalHtml = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = `
                <span class="inline-block animate-spin mr-2">
                    <span class="material-icons">sync</span>
                </span>
                Processing...
            `;

            fetch(`/user/resep/${resepId}/verifikasi`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        status: 'Menunggu Verifikasi'
                    })
                })
                .then(response => response.json())
                .then(data => {
                    // Show Material Design Snackbar instead of alert
                    showSnackbar(data.success ? 'Resep berhasil diajukan untuk verifikasi!' :
                        'Terjadi kesalahan saat mengajukan verifikasi!');
                    fetchResep('dokter');
                })
                .catch(error => {
                    console.error('Error:', error);
                    showSnackbar('Terjadi kesalahan pada sistem.');
                })
                .finally(() => {
                    btn.disabled = false;
                    btn.innerHTML = originalHtml;
                });
        }

        // Add Material Design Snackbar
        function showSnackbar(message) {
            // Remove existing snackbar if any
            const existingSnackbar = document.getElementById('snackbar');
            if (existingSnackbar) {
                existingSnackbar.remove();
            }

            // Create snackbar element
            const snackbar = document.createElement('div');
            snackbar.id = 'snackbar';
            snackbar.className =
                'fixed bottom-4 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white py-3 px-6 rounded-lg shadow-lg z-50 flex items-center';
            snackbar.innerHTML = `
                <span>${message}</span>
                <button class="ml-4 text-white" onclick="this.parentElement.remove()">
                    <span class="material-icons">close</span>
                </button>
            `;

            // Add to document
            document.body.appendChild(snackbar);

            // Auto remove after 5 seconds
            setTimeout(() => {
                if (document.getElementById('snackbar')) {
                    document.getElementById('snackbar').remove();
                }
            }, 5000);
        }

        // Add this to your stylesheet (or add inline in head)
        const style = document.createElement('style');
        style.textContent = `
            .animate-fadeIn {
                animation: fadeIn 0.3s ease-out;
            }
            
            @keyframes fadeIn {
                from { opacity: 0; transform: scale(0.95); }
                to { opacity: 1; transform: scale(1); }
            }
            
            /* Material Design Ripple Effect */
            .ripple {
                position: absolute;
                border-radius: 50%;
                background-color: rgba(255, 255, 255, 0.7);
                transform: scale(0);
                animation: ripple 0.6s linear;
                pointer-events: none;
            }
            
            @keyframes ripple {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
            
            /* Custom Scrollbar */
            .scrollbar-thin::-webkit-scrollbar {
                height: 4px;
            }
            
            .scrollbar-thin::-webkit-scrollbar-track {
                background: #f1f1f1;
                border-radius: 2px;
            }
            
            .scrollbar-thin::-webkit-scrollbar-thumb {
                background: #cecece;
                border-radius: 2px;
            }
            
            .scrollbar-thin::-webkit-scrollbar-thumb:hover {
                background: #a1a1a1;
            }
        `;
        document.head.appendChild(style);
    </script>
@endsection
