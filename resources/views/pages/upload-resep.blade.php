@extends('layouts.user')

@section('content')
    <div
        class="w-full max-w-2xl mx-auto bg-white/90 backdrop-blur-sm mt-20 lg:mt-0 p-4 sm:p-8 rounded-xl shadow-lg border border-white/20">
        <h2 class="text-xl sm:text-2xl font-medium mb-4 sm:mb-6 text-gray-800">Upload Recipes</h2>

        @if (session('success'))
            <div
                class="mb-4 bg-green-100 border border-green-400 text-green-700 px-3 py-2 sm:px-4 sm:py-3 rounded relative text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div
                class="mb-4 bg-red-100 border border-red-400 text-red-700 px-3 py-2 sm:px-4 sm:py-3 rounded relative text-sm">
                {{ session('error') }}
            </div>
        @endif

        <form id="upload-form" action="{{ route('resep.upload') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Pilihan Pasien -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2 sm:mb-3">Patient Name</label>
                <div
                    class="flex flex-col sm:flex-row sm:items-center sm:space-x-6 space-y-3 sm:space-y-0 bg-gray-50/80 backdrop-blur-sm p-3 sm:p-4 rounded-lg shadow-sm">
                    <label class="flex items-center space-x-3">
                        <div class="relative">
                            <input type="radio" name="patient_type" value="self" checked
                                class="form-radio w-4 h-4 sm:w-5 sm:h-5 text-blue-500 focus:ring-blue-400">
                            <span
                                class="ripple absolute inset-0 w-8 h-8 sm:w-10 sm:h-10 -top-2 -left-2 sm:-top-2.5 sm:-left-2.5 rounded-full pointer-events-none"></span>
                        </div>
                        <span class="text-gray-800 text-sm sm:text-base">Self ({{ auth()->user()->name }})</span>
                    </label>
                    <label class="flex items-center space-x-3">
                        <div class="relative">
                            <input type="radio" name="patient_type" value="other"
                                class="form-radio w-4 h-4 sm:w-5 sm:h-5 text-blue-500 focus:ring-blue-400">
                            <span
                                class="ripple absolute inset-0 w-8 h-8 sm:w-10 sm:h-10 -top-2 -left-2 sm:-top-2.5 sm:-left-2.5 rounded-full pointer-events-none"></span>
                        </div>
                        <span class="text-gray-800 text-sm sm:text-base">Other Patient</span>
                    </label>
                </div>
                <div class="mt-3 sm:mt-4 relative">
                    <input type="text" id="patient_name" name="pasien_nama" placeholder="Other Patient Name"
                        class="hidden py-2 sm:py-3 px-3 sm:px-4 border-b border-gray-300 focus:border-blue-500 transition-all duration-300 bg-transparent w-full focus:outline-none text-sm sm:text-base"
                        disabled>
                    <div class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-500 transition-all duration-300 input-line">
                    </div>
                </div>
            </div>

            <!-- Unggah Foto -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2 sm:mb-3">Upload Photo/Scan Recipes</label>
                <div
                    class="relative bg-gray-50/80 backdrop-blur-sm p-4 sm:p-6 rounded-lg border border-gray-200 shadow-sm transition-all hover:shadow-md">
                    <input type="file" id="file-upload" name="foto_resep[]" multiple accept="image/png, image/jpeg"
                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" onchange="handleFileUpload(event)">
                    <div class="text-center">
                        <svg class="mx-auto h-8 w-8 sm:h-12 sm:w-12 text-gray-400" stroke="currentColor" fill="none"
                            viewBox="0 0 48 48" aria-hidden="true">
                            <path
                                d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <p class="mt-2 text-gray-500 text-sm sm:text-base">Click or drag file here</p>
                    </div>
                </div>
            </div>
            <div class="flex items-center justify-center mb-4">
                <hr class="w-[40%]">
                <p class="text-center text-gray-300 w-[20%] text-xs sm:text-sm">
                    Or
                </p>
                <hr class="w-[40%]">
            </div>
            <!-- Tombol Gunakan Kamera -->
            <button type="button" onclick="showCamera()"
                class="w-full flex items-center justify-center bg-blue-500 text-white px-4 sm:px-6 py-2 sm:py-3 rounded-lg text-sm sm:text-base font-medium shadow-md hover:bg-blue-600 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-opacity-50 transform hover:-translate-y-0.5">
                <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                    </path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                Use Camera
            </button>

            <!-- Video Kamera -->
            <div id="camera-section"
                class="hidden mt-6 sm:mt-8 bg-white/90 backdrop-blur-sm p-3 sm:p-5 rounded-lg border border-gray-200 shadow-lg">
                <video id="camera" class="w-full rounded-lg border overflow-hidden" playsinline></video>

                <div class="flex flex-col sm:flex-row sm:space-x-3 space-y-2 sm:space-y-0 mt-3 sm:mt-4">
                    <button type="button" onclick="switchCamera()"
                        class="flex-1 flex items-center justify-center bg-gray-500 text-white px-3 sm:px-4 py-2 rounded-lg text-sm sm:text-base font-medium shadow-md hover:bg-gray-600 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-opacity-50">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                        </svg>
                        Switch Camera
                    </button>
                    <div class="flex justify-center">
                        <button title="Take Photo" type="button" onclick="capturePhoto()"
                            class="border rounded-full flex items-center justify-center border-gray-700 text-gray-700 text-sm p-1">
                            <div
                                class="bg-white border border-gray-700 w-10 h-10 sm:w-12 sm:h-12 rounded-full hover:bg-slate-100">
                            </div>
                        </button>
                    </div>
                    <button type="button" onclick="closeCamera()"
                        class="flex-1 flex items-center justify-center bg-red-500 text-white px-3 sm:px-4 py-2 rounded-lg text-sm sm:text-base font-medium shadow-md hover:bg-red-600 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-red-300 focus:ring-opacity-50">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Close Camera
                    </button>
                </div>
            </div>

            <!-- Input Hidden untuk Foto -->
            <input type="hidden" id="final_photos" name="final_photos">

            <!-- Preview Foto -->
            <div id="photo-preview" class="mt-4 sm:mt-6 grid grid-cols-2 sm:grid-cols-3 gap-2 sm:gap-4"></div>

            <!-- Tombol Submit -->
            <button type="submit"
                class="w-full mt-6 sm:mt-8 flex items-center justify-center bg-green-500 text-white px-4 sm:px-6 py-2 sm:py-3 rounded-lg text-sm sm:text-base font-medium shadow-md hover:bg-green-600 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-green-300 focus:ring-opacity-50 transform hover:-translate-y-0.5">
                <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Upload
            </button>
        </form>
    </div>

    <style>
        /* Material Design & Glassmorphism Effects */
        .ripple {
            background-position: center;
            transition: background 0.8s;
        }

        .ripple:hover {
            background: radial-gradient(circle, rgba(0, 0, 0, .1) 1%, transparent 1%) center/15000%;
        }

        .ripple:active {
            background-color: rgba(0, 0, 0, .2);
            background-size: 100%;
            transition: background 0s;
        }

        input[type="radio"]:checked+.ripple,
        input[type="checkbox"]:checked+.ripple {
            background-color: rgba(59, 130, 246, 0.2);
        }

        input:not([type="radio"]):not([type="checkbox"]):focus~.input-line {
            width: 100%;
        }

        input:not([disabled]):not(.hidden)~.input-line {
            width: 0;
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const patientTypeRadios = document.querySelectorAll('input[name="patient_type"]');
            const patientNameInput = document.querySelector('input[name="pasien_nama"]');

            patientTypeRadios.forEach(radio => {
                radio.addEventListener("change", function() {
                    if (this.value === "other") {
                        patientNameInput.classList.remove("hidden");
                        patientNameInput.removeAttribute("disabled");
                        patientNameInput.setAttribute("required", "true");
                        patientNameInput.focus();
                    } else {
                        patientNameInput.classList.add("hidden");
                        patientNameInput.setAttribute("disabled", "true");
                        patientNameInput.removeAttribute("required");
                    }
                });
            });

            // Add ripple effect to radio buttons
            document.querySelectorAll('.ripple').forEach(button => {
                button.addEventListener('mousedown', function(e) {
                    const ripple = document.createElement('span');
                    const diameter = Math.max(this.clientWidth, this.clientHeight);
                    const radius = diameter / 2;

                    ripple.style.width = ripple.style.height = `${diameter}px`;
                    ripple.style.left =
                        `${e.clientX - (this.getBoundingClientRect().left + radius)}px`;
                    ripple.style.top =
                        `${e.clientY - (this.getBoundingClientRect().top + radius)}px`;
                    ripple.classList.add('ripple-effect');

                    this.appendChild(ripple);

                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });
            });
        });

        let isBackCamera = true; // Default pakai kamera belakang
        let videoStream = null; // Simpan stream aktif
        let uploadedPhotos = []; // Simpan foto dari file
        let capturedPhotos = []; // Simpan foto dari kamera

        function showCamera() {
            document.getElementById('camera-section').classList.remove('hidden');
            startCamera();
        }

        function startCamera() {
            let video = document.getElementById('camera');

            if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                alert('Browser Anda tidak mendukung akses kamera');
                return;
            }

            let constraints = {
                video: {
                    facingMode: isBackCamera ? "environment" : "user",
                    width: {
                        ideal: 1280
                    },
                    height: {
                        ideal: 720
                    }
                }
            };

            if (videoStream) {
                stopCamera();
            }

            navigator.mediaDevices.getUserMedia(constraints)
                .then(stream => {
                    videoStream = stream;
                    video.srcObject = stream;
                    return video.play();
                })
                .catch(err => {
                    console.error('Kamera error:', err);
                    alert('Tidak dapat mengakses kamera: ' + err.message);
                });
        }

        // Fungsi untuk menutup kamera
        function closeCamera() {
            stopCamera();
            document.getElementById('camera-section').classList.add('hidden');
        }

        // Fungsi untuk menghentikan kamera
        function stopCamera() {
            if (videoStream) {
                videoStream.getTracks().forEach(track => track.stop());
                videoStream = null;
            }
        }

        // Fungsi mengganti kamera (depan/belakang)
        function switchCamera() {
            isBackCamera = !isBackCamera;
            startCamera();
        }

        // Fungsi menangkap foto dari kamera
        function capturePhoto() {
            let video = document.getElementById('camera');
            let canvas = document.createElement('canvas');
            let context = canvas.getContext('2d');

            // Set ukuran canvas sesuai video dengan rasio aspek yang tepat
            let width = video.videoWidth;
            let height = video.videoHeight;

            canvas.width = width;
            canvas.height = height;

            // Gambar video ke canvas
            context.drawImage(video, 0, 0, width, height);

            // Konversi ke base64 dengan kualitas yang baik
            let imageData = canvas.toDataURL('image/jpeg', 0.8);

            if (isValidBase64Image(imageData)) {
                capturedPhotos.push(imageData);
                updatePreview();
            } else {
                alert('Gagal mengambil foto. Silakan coba lagi.');
            }
        }

        // Fungsi untuk mengunggah foto dari file
        function handleFileUpload(event) {
            let files = event.target.files;
            const maxSize = 2 * 1024 * 1024; // 2MB
            const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'application/pdf'];

            for (let file of files) {
                if (!allowedTypes.includes(file.type)) {
                    alert(`File ${file.name} tidak didukung. Gunakan format JPG, PNG, GIF, atau PDF.`);
                    continue;
                }

                if (file.size > maxSize) {
                    alert(`File ${file.name} terlalu besar. Maksimum ukuran file adalah 2MB.`);
                    continue;
                }

                let reader = new FileReader();
                reader.onload = function(e) {
                    uploadedPhotos.push(e.target.result);
                    updatePreview();
                };
                reader.readAsDataURL(file);
            }
        }

        // Fungsi untuk memperbarui preview foto
        function updatePreview() {
            let previewContainer = document.getElementById('photo-preview');
            previewContainer.innerHTML = '';

            [...uploadedPhotos, ...capturedPhotos].forEach((image, index) => {
                let imageContainer = document.createElement('div');
                imageContainer.classList.add('relative', 'inline-block', 'w-24', 'h-24', 'overflow-hidden',
                    'rounded-lg', 'shadow-md', 'transition-transform', 'hover:scale-105', 'duration-300');

                let imgElement = document.createElement('img');
                imgElement.src = image;
                imgElement.classList.add('w-full', 'h-full', 'object-cover');

                let deleteButton = document.createElement('button');
                deleteButton.innerHTML =
                    '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
                deleteButton.classList.add('absolute', 'top-0', 'right-0', 'bg-red-500', 'text-white',
                    'rounded-bl-lg', 'w-6', 'h-6', 'flex', 'items-center', 'justify-center',
                    'cursor-pointer', 'hover:bg-red-600', 'transition-colors');
                deleteButton.onclick = function() {
                    if (index < uploadedPhotos.length) {
                        uploadedPhotos.splice(index, 1);
                    } else {
                        capturedPhotos.splice(index - uploadedPhotos.length, 1);
                    }
                    updatePreview();
                };

                imageContainer.appendChild(imgElement);
                imageContainer.appendChild(deleteButton);
                previewContainer.appendChild(imageContainer);
            });
        }

        function isValidBase64Image(str) {
            if (!str || str.length === 0) return false;
            try {
                return str.match(/^data:image\/(jpg|jpeg|png|gif);base64,/);
            } catch (e) {
                return false;
            }
        }

        // Update form submit handler to prepare final_photos before submission
        document.getElementById('upload-form').addEventListener('submit', function(event) {
            // Don't prevent form submission anymore
            let allPhotos = [...uploadedPhotos, ...capturedPhotos];

            // Validate photos
            if (allPhotos.length === 0) {
                event.preventDefault();
                alert("Silakan unggah atau ambil minimal satu foto resep!");
                return;
            }

            allPhotos = allPhotos.filter(photo => isValidBase64Image(photo));
            if (allPhotos.length === 0) {
                event.preventDefault();
                alert("Tidak ada foto valid yang dapat diunggah!");
                return;
            }

            document.getElementById('final_photos').value = JSON.stringify(allPhotos);
        });
    </script>
@endsection
