@extends('layouts.user')

@section('content')
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:p>{{ $title }}</x-slot:p>

    <div class="container mx-auto px-4 py-6 bg-gray-50">
        <!-- Search and Filter Section -->
        <div class="mb-6 space-y-4">
            <!-- Search Bar - iOS Style -->
            <div class="relative">
                <div class="absolute inset-y-0 start-0 mt-14 lg:mt-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
                <input type="search" id="medicine-search"
                    class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-200 rounded-xl bg-white focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Search medicines...">
            </div>

            <!-- Filter Section -->
            <div class="flex flex-wrap gap-3">
                <select id="sort-filter"
                    class="bg-white border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-2.5">
                    <option value="latest">Latest</option>
                    <option value="oldest">Oldest</option>
                </select>

                <select id="availability-filter"
                    class="bg-white border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-2.5">
                    <option value="all">All Status</option>
                    <option value="available">Available</option>
                    <option value="unavailable">Unavailable</option>
                </select>

                <select id="category-filter"
                    class="bg-white border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-2.5">
                    <option value="">All Categories</option>
                    @foreach ($kategoris as $kategori)
                        <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Add Medicine Button - iOS Style -->
        <button data-modal-target="obatModal" data-modal-toggle="obatModal"
            class="fixed bottom-6 right-6 w-14 h-14 bg-blue-500 text-white rounded-full shadow-lg hover:bg-blue-600 transition-all flex items-center justify-center">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
        </button>

        <!-- Success Message -->
        @if (session('success'))
            <div id="alert-success" class="flex items-center p-4 mb-4 text-green-800 rounded-xl bg-green-50" role="alert">
                <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                </svg>
                <span class="sr-only">Success</span>
                <div class="ms-3 text-sm font-medium">{{ session('success') }}</div>
                <button type="button"
                    class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8"
                    data-dismiss-target="#alert-success" aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>
        @endif

        <!-- Medicine Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse ($obats as $obat)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <img src="{{ asset('storage/' . $obat->foto) }}" alt="Foto_{{ $obat->nama }}"
                        class="w-full h-48 object-cover">
                    <div class="p-4">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-lg font-semibold text-gray-900">{{ $obat->nama }}</h3>
                            <span
                                class="px-2.5 py-1 text-xs font-medium rounded-full {{ $obat->is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $obat->is_available ? 'Available' : 'Out of Stock' }}
                            </span>
                        </div>

                        <div class="space-y-2 text-sm text-gray-600">
                            <p><span class="font-medium">Category:</span>
                                {{ $obat->kategori ? $obat->kategori->nama : 'Uncategorized' }}</p>
                            <p><span class="font-medium">Type:</span>
                                {{ $obat->jenisObat ? $obat->jenisObat->nama_jenis_obat : 'N/A' }}</p>
                            <p><span class="font-medium">Stock:</span> {{ $obat->banyak }}</p>
                            <p><span class="font-medium">Price:</span> Rp{{ number_format($obat->harga, 2, ',', '.') }}</p>
                        </div>

                        <div class="mt-4 flex gap-2">
                            <button data-modal-target="viewModal-{{ $obat->id }}"
                                data-modal-toggle="viewModal-{{ $obat->id }}"
                                class="flex-1 px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-gray-100">
                                View Details
                            </button>
                            <button data-modal-target="editModal-{{ $obat->id }}"
                                data-modal-toggle="editModal-{{ $obat->id }}"
                                class="flex-1 px-4 py-2 text-sm font-medium text-white bg-blue-500 rounded-lg hover:bg-blue-600 focus:ring-4 focus:ring-blue-300">
                                Edit
                            </button>
                            <form action="{{ route('obat.destroy', $obat) }}" method="POST" class="inline delete-form">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="flex-1 px-4 py-2 text-sm font-medium text-white bg-red-500 rounded-lg hover:bg-red-600 focus:ring-4 focus:ring-red-300"
                                    onclick="return confirm('Are you sure you want to delete this medicine?')">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- View Modal -->
                <div id="viewModal-{{ $obat->id }}" tabindex="-1" aria-hidden="true"
                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative p-4 w-full max-w-2xl max-h-full">
                        <div class="relative bg-white rounded-xl shadow">
                            <!-- Modal header -->
                            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                                <h3 class="text-xl font-semibold text-gray-900">
                                    Medicine Details
                                </h3>
                                <button type="button"
                                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                    data-modal-hide="viewModal-{{ $obat->id }}">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                    </svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                            </div>
                            <!-- Modal body -->
                            <div class="p-4 md:p-5 space-y-4">
                                <img src="{{ asset('storage/' . $obat->foto) }}" alt="Foto_{{ $obat->nama }}"
                                    class="w-full h-64 object-cover rounded-lg mb-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Name</p>
                                        <p class="text-base text-gray-900">{{ $obat->nama }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Registration Number</p>
                                        <p class="text-base text-gray-900">{{ $obat->nie }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Category</p>
                                        <p class="text-base text-gray-900">
                                            {{ $obat->kategori ? $obat->kategori->nama : 'Uncategorized' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Type</p>
                                        <p class="text-base text-gray-900">
                                            {{ $obat->jenisObat ? $obat->jenisObat->nama_jenis_obat : 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Form</p>
                                        <p class="text-base text-gray-900">
                                            {{ $obat->bentukObat ? $obat->bentukObat->nama_bentuk_obat : 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Composition</p>
                                        <p class="text-base text-gray-900">{{ $obat->komposisi_obat }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Dosage</p>
                                        <p class="text-base text-gray-900">{{ $obat->dosis_obat }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Weight</p>
                                        <p class="text-base text-gray-900">{{ $obat->kekuatan_obat }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Stock</p>
                                        <p class="text-base text-gray-900">{{ $obat->banyak }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Price</p>
                                        <p class="text-base text-gray-900">
                                            Rp{{ number_format($obat->harga, 2, ',', '.') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Expiry Date</p>
                                        <p class="text-base text-gray-900">
                                            {{ \Carbon\Carbon::parse($obat->tanggal_kedaluwarsa)->format('d-m-Y') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Status</p>
                                        <p class="text-base text-gray-900">
                                            {{ $obat->is_available ? 'Available' : 'Not Available' }}</p>
                                    </div>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Description</p>
                                    <p class="text-base text-gray-900">{{ $obat->deskripsi_obat }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Edit Medicine Modal -->
                <div id="editModal-{{ $obat->id }}" tabindex="-1" aria-hidden="true"
                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative p-4 w-full max-w-4xl max-h-full">
                        <div class="relative bg-white rounded-xl shadow">
                            <!-- Modal header -->
                            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                                <h3 class="text-xl font-semibold text-gray-900">Add New Medicine</h3>
                                <button type="button"
                                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                    data-modal-hide="editModal-{{ $obat->id }}">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                    </svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                            </div>

                            <!-- Modal body -->
                            @if (isset($obat))
                                <form action="{{ route('obat.update', $obat->id) }}" method="POST"
                                    enctype="multipart/form-data"  class="p-4 md:p-5">
                                    @method('PUT')
                                @else
                                    <form action="{{ route('obat.store') }}" method="POST"
                                        enctype="multipart/form-data">
                            @endif
                            @csrf
                            <div class="grid gap-4 mb-4 grid-cols-2">
                                <div class="col-span-2">
                                    <label for="foto-{{ $obat->id }}"
                                        class="block mb-2 text-sm font-medium text-gray-900">Medicine Photo</label>
                                    <div class="flex items-center justify-center w-full">
                                        <div class="image-upload-container w-full">
                                            <div
                                                class="preview-container w-full h-64 relative {{ $obat->foto ? '' : 'hidden' }}">
                                                <img src="{{ $obat->foto ? asset('storage/' . $obat->foto) : '' }}"
                                                    alt="Preview" class="w-full h-full object-cover rounded-lg">
                                                <button type="button"
                                                    class="remove-image absolute top-2 right-2 p-1 bg-red-500 text-white rounded-full hover:bg-red-600">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                            <label for="foto-{{ $obat->id }}"
                                                class="upload-label flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 {{ $obat->foto ? 'hidden' : '' }}">
                                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                    <svg class="w-8 h-8 mb-4 text-gray-500" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 20 16">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                                    </svg>
                                                    <p class="mb-2 text-sm text-gray-500"><span
                                                            class="font-semibold">Click to upload</span> or drag and
                                                        drop</p>
                                                    <p class="text-xs text-gray-500">PNG, JPG or JPEG (MAX. 2MB)</p>
                                                </div>
                                                <input type="file" id="foto-{{ $obat->id }}" name="foto"
                                                    class="hidden" accept="image/*" />
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-span-2 sm:col-span-1">
                                    <label for="nama" class="block mb-2 text-sm font-medium text-gray-900">Medicine
                                        Name</label>
                                    <input type="text" name="nama" id="nama"
                                        value="{{ old('nama', isset($obat) ? $obat->nama : '') }}"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                        required>
                                </div>

                                <div class="col-span-2 sm:col-span-1">
                                    <label for="nie"
                                        class="block mb-2 text-sm font-medium text-gray-900">Registration
                                        Number</label>
                                    <input type="text" name="nie" id="nie"
                                        value="{{ old('nie', isset($obat) ? $obat->nie : '') }}"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                        required>
                                </div>

                                <div class="col-span-2 sm:col-span-1">
                                    <label for="kategori_id"
                                        class="block mb-2 text-sm font-medium text-gray-900">Category</label>
                                    <select name="kategori_id" id="kategori_id"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                        <option value="">Select Category</option>
                                        @foreach ($kategoris as $kategori)
                                            <option value="{{ $kategori->id }}"
                                                {{ old('kategori_id', isset($obat) ? $obat->kategori_id : '') == $kategori->id ? 'selected' : '' }}>
                                                {{ $kategori->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-span-2 sm:col-span-1">
                                    <label for="jenis_obat_id"
                                        class="block mb-2 text-sm font-medium text-gray-900">Medicine
                                        Type</label>
                                    <select name="jenis_obat_id" id="jenis_obat_id"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                        <option value="">Select Type</option>
                                        @foreach ($jenis_obat as $jo)
                                            <option value="{{ $jo->id }}"
                                                {{ old('jenis_obat_id', isset($obat) ? $obat->jenis_obat_id : '') == $jo->id ? 'selected' : 'jenis_obat_id' }}>
                                                {{ $jo->nama_jenis_obat }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-span-2 sm:col-span-1">
                                    <label for="bentuk_obat_id"
                                        class="block mb-2 text-sm font-medium text-gray-900">Medicine
                                        Appearance</label>
                                    <select name="bentuk_obat_id" id="bentuk_obat_id"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                        <option value="">Select Appearance </option>
                                        @foreach ($bentuk_obat as $bo)
                                            <option value="{{ $bo->id }}"
                                                {{ old('bentuk_obat_id', isset($obat) ? $obat->bentuk_obat_id : '') == $bo->id ? 'selected' : 'bentuk_obat_id' }}>
                                                {{ $bo->nama_bentuk_obat }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="col-span-2 sm:col-span-1">
                                    <label for="is_available"
                                        class="block mb-2 text-sm font-medium text-gray-900">Availability</label>
                                    <select name="is_available" id="is_available"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                        <option value="1" {{ old('is_available', isset($obat) ? $obat->is_available : '') == 1 ? 'selected' : '' }}>Available</option>
                                        <option value="0" {{ old('is_available', isset($obat) ? $obat->is_available : '') == 0 ? 'selected' : '' }}>Not Available</option>
                                    </select>
                                </div>

                                <div class="col-span-2">
                                    <label for="deskripsi_obat"
                                        class="block mb-2 text-sm font-medium text-gray-900">Description</label>
                                    <textarea name="deskripsi_obat" id="deskripsi_obat" rows="4"
                                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                        required>{{ old('deskripsi_obat', isset($obat) ? $obat->deskripsi_obat : '') }}</textarea>
                                </div>

                                <div class="col-span-2 sm:col-span-1">
                                    <label for="dosis_obat"
                                        class="block mb-2 text-sm font-medium text-gray-900">Dose</label>
                                        <input type="text" name="dosis_obat" id="dosis_obat"
                                        value="{{ old('dosis_obat', isset($obat) ? $obat->dosis_obat : '') }}"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                                </div>
                                
                                <div class="col-span-2 sm:col-span-1">
                                    <label for="kekuatan_obat"
                                        class="block mb-2 text-sm font-medium text-gray-900">Mass</label>
                                        <input type="text" name="kekuatan_obat" id="kekuatan_obat"
                                        value="{{ old('kekuatan_obat', isset($obat) ? $obat->kekuatan_obat : '') }}"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                                </div>
                                
                                <div class="col-span-2 sm:col-span-1">
                                    <label for="komposisi_obat"
                                        class="block mb-2 text-sm font-medium text-gray-900">Composition</label>
                                        <input type="text" name="komposisi_obat" id="komposisi_obat"
                                        value="{{ old('komposisi_obat', isset($obat) ? $obat->komposisi_obat : '') }}"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                                </div>

                                <div class="col-span-2 sm:col-span-1">
                                    <label for="banyak"
                                        class="block mb-2 text-sm font-medium text-gray-900">Stock</label>
                                    <input type="number" name="banyak" id="banyak" min="0"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                        value="{{ old('banyak', isset($obat) ? $obat->banyak : '') }}" required>
                                </div>

                                <div class="col-span-2 sm:col-span-1">
                                    <label for="harga"
                                        class="block mb-2 text-sm font-medium text-gray-900">Price</label>
                                    <input type="number" name="harga" id="harga" min="0"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                         value="{{ old('harga', isset($obat) ? $obat->harga : '') }}" required>
                                </div>

                                <div class="col-span-2 sm:col-span-1">
                                    <label for="tanggal_kedaluwarsa"
                                        class="block mb-2 text-sm font-medium text-gray-900">Expiry Date</label>
                                    <input type="date" name="tanggal_kedaluwarsa" id="tanggal_kedaluwarsa"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                        value="{{ old('tanggal_kedaluwarsa', isset($obat) ? $obat->tanggal_kedaluwarsa : '') }}" required>
                                </div>

                            </div>
                            <div class="flex items-center justify-end space-x-4">
                                <button type="button"
                                    class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10"
                                    data-modal-hide="editModal-{{ $obat->id }}">Cancel</button>
                                <button type="submit"
                                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Save
                                    Update</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4M12 4v16" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No medicines found</h3>
                    <p class="mt-1 text-sm text-gray-500">Get started by adding a new medicine.</p>
                </div>
            @endforelse
        </div>

        <!-- Add Medicine Modal -->
        <div id="obatModal" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-4xl max-h-full">
                <div class="relative bg-white rounded-xl shadow">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                        <h3 class="text-xl font-semibold text-gray-900">Add New Medicine</h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                            data-modal-hide="obatModal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>

                    <!-- Modal body -->
                    <form action="{{ route('obat.store') }}" method="POST" enctype="multipart/form-data"
                        class="p-4 md:p-5">
                        @csrf
                        <div class="grid gap-4 mb-4 grid-cols-2">
                            <div class="col-span-2">
                                <label for="foto" class="block mb-2 text-sm font-medium text-gray-900">Medicine
                                    Photo</label>
                                <div class="flex items-center justify-center w-full">
                                    <div class="image-upload-container w-full">
                                        <div class="preview-container hidden w-full h-64 relative">
                                            <img src="" alt="Preview"
                                                class="w-full h-full object-cover rounded-lg">
                                            <button type="button"
                                                class="remove-image absolute top-2 right-2 p-1 bg-red-500 text-white rounded-full hover:bg-red-600">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                        </div>
                                        <label for="foto"
                                            class="upload-label flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                <svg class="w-8 h-8 mb-4 text-gray-500" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 20 16">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                                </svg>
                                                <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click to
                                                        upload</span> or drag and drop</p>
                                                <p class="text-xs text-gray-500">PNG, JPG or JPEG (MAX. 2MB)</p>
                                            </div>
                                            <input type="file" id="foto" name="foto" class="hidden"
                                                accept="image/*" />
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-span-2 sm:col-span-1">
                                <label for="nama" class="block mb-2 text-sm font-medium text-gray-900">Medicine
                                    Name</label>
                                <input type="text" name="nama" id="nama"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    required>
                            </div>

                            <div class="col-span-2 sm:col-span-1">
                                <label for="nie" class="block mb-2 text-sm font-medium text-gray-900">Registration
                                    Number</label>
                                <input type="text" name="nie" id="nie"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    required>
                            </div>

                            <div class="col-span-2 sm:col-span-1">
                                <label for="kategori_id"
                                    class="block mb-2 text-sm font-medium text-gray-900">Category</label>
                                <select name="kategori_id" id="kategori_id"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                    <option value="">Select Category</option>
                                    @foreach ($kategoris as $kategori)
                                        <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-span-2 sm:col-span-1">
                                <label for="jenis_obat_id" class="block mb-2 text-sm font-medium text-gray-900">Medicine
                                    Type</label>
                                <select name="jenis_obat_id" id="jenis_obat_id"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                    <option value="">Select Type</option>
                                    @foreach ($jenis_obat as $jo)
                                        <option value="{{ $jo->id }}">{{ $jo->nama_jenis_obat }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-span-2 sm:col-span-1">
                                <label for="bentuk_obat_id"
                                    class="block mb-2 text-sm font-medium text-gray-900">Medicine
                                    Appearance</label>
                                <select name="bentuk_obat_id" id="bentuk_obat_id"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                    <option value="">Select Appearance </option>
                                    @foreach ($bentuk_obat as $bo)
                                        <option value="{{ $bo->id }}">
                                            {{ $bo->nama_bentuk_obat }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-span-2 sm:col-span-1">
                                <label for="is_available"
                                    class="block mb-2 text-sm font-medium text-gray-900">Availability</label>
                                <select name="is_available" id="is_available"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                    <option value="1">Available</option>
                                    <option value="0">Not Available</option>
                                </select>
                            </div>

                            <div class="col-span-2">
                                <label for="deskripsi_obat"
                                    class="block mb-2 text-sm font-medium text-gray-900">Description</label>
                                <textarea name="deskripsi_obat" id="deskripsi_obat" rows="4"
                                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                    required></textarea>
                            </div>

                            <div class="col-span-2 sm:col-span-1">
                                <label for="dosis_obat"
                                    class="block mb-2 text-sm font-medium text-gray-900">Dose</label>
                                <input type="text" name="dosis_obat" id="dosis_obat" min="0"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                            </div>
                            
                            <div class="col-span-2 sm:col-span-1">
                                <label for="kekuatan_obat"
                                    class="block mb-2 text-sm font-medium text-gray-900">Mass</label>
                                <input type="text" name="kekuatan_obat" id="kekuatan_obat" min="0"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                            </div>
                            
                            <div class="col-span-2 sm:col-span-1">
                                <label for="komposisi_obat"
                                    class="block mb-2 text-sm font-medium text-gray-900">Composition</label>
                                <input type="text" name="komposisi_obat" id="komposisi_obat" min="0"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                            </div>

                            <div class="col-span-2 sm:col-span-1">
                                <label for="banyak" class="block mb-2 text-sm font-medium text-gray-900">Stock</label>
                                <input type="number" name="banyak" id="banyak" min="0"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    required>
                            </div>

                            <div class="col-span-2 sm:col-span-1">
                                <label for="harga" class="block mb-2 text-sm font-medium text-gray-900">Price</label>
                                <input type="number" name="harga" id="harga" min="0"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    required>
                            </div>

                            <div class="col-span-2 sm:col-span-1">
                                <label for="tanggal_kedaluwarsa"
                                    class="block mb-2 text-sm font-medium text-gray-900">Expiry Date</label>
                                <input type="date" name="tanggal_kedaluwarsa" id="tanggal_kedaluwarsa"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    required>
                            </div>

                        </div>
                        <div class="flex items-center justify-end space-x-4">
                            <button type="button"
                                class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10"
                                data-modal-hide="obatModal">Cancel</button>
                            <button type="submit"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Add
                                Medicine</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for Search and Filter Functionality -->
    <script>
        // Wait for the DOM to be fully loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Flowbite
            initFlowbite();

            // Get all filter elements
            const searchInput = document.getElementById('medicine-search');
            const sortFilter = document.getElementById('sort-filter');
            const availabilityFilter = document.getElementById('availability-filter');
            const categoryFilter = document.getElementById('category-filter');
            const medicineContainer = document.querySelector('.grid');

            // Function to get all medicine cards
            const getMedicineCards = () => document.querySelectorAll('.grid > div[class*="bg-white rounded-xl"]');

            // Main filter function
            function filterMedicines() {
                const searchTerm = searchInput.value.toLowerCase();
                const sortBy = sortFilter.value;
                const availability = availabilityFilter.value;
                const category = categoryFilter.value;

                // Get all medicine cards
                const medicineCards = getMedicineCards();

                medicineCards.forEach(card => {
                    // Get relevant data from the card
                    const name = card.querySelector('h3').textContent.toLowerCase();
                    const statusElement = card.querySelector('span[class*="rounded-full"]');
                    const isAvailable = statusElement.textContent.trim() === 'Available';
                    const categoryElement = card.querySelector('p:nth-child(1)');
                    const medicineCategory = categoryElement.textContent.replace('Category:', '').trim();

                    // Apply filters
                    let show = name.includes(searchTerm);

                    // Availability filter
                    if (availability !== 'all') {
                        show = show && (
                            (availability === 'available' && isAvailable) ||
                            (availability === 'unavailable' && !isAvailable)
                        );
                    }

                    // Category filter
                    if (category !== '') {
                        show = show && medicineCategory === document.querySelector(
                            `#category-filter option[value="${category}"]`).textContent;
                    }

                    // Show/hide the card
                    card.style.display = show ? '' : 'none';
                });

                // Sort cards
                const visibleCards = Array.from(medicineCards).filter(card => card.style.display !== 'none');
                sortCards(visibleCards, sortBy);
            }

            // Function to sort cards
            function sortCards(cards, sortBy) {
                cards.sort((a, b) => {
                    const nameA = a.querySelector('h3').textContent.toLowerCase();
                    const nameB = b.querySelector('h3').textContent.toLowerCase();

                    if (sortBy === 'latest') {
                        return nameA < nameB ? 1 : -1;
                    } else {
                        return nameA > nameB ? 1 : -1;
                    }
                });

                // Reorder cards in the DOM
                cards.forEach(card => {
                    medicineContainer.appendChild(card);
                });
            }

            // Add event listeners to all filter inputs
            searchInput?.addEventListener('input', filterMedicines);
            sortFilter?.addEventListener('change', filterMedicines);
            availabilityFilter?.addEventListener('change', filterMedicines);
            categoryFilter?.addEventListener('change', filterMedicines);

            // Image preview functionality
            const imageInput = document.getElementById('foto');
            if (imageInput) {
                imageInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (!file) return;

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const container = imageInput.closest('label');
                        container.innerHTML = `
                    <img src="${e.target.result}" class="w-full h-64 object-cover rounded-lg" alt="Preview">
                `;
                        // Re-add the hidden input
                        container.appendChild(imageInput);
                    };
                    reader.readAsDataURL(file);
                });
            }

            // Delete confirmation
            document.querySelectorAll('.delete-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    if (!confirm('Are you sure you want to delete this medicine?')) {
                        e.preventDefault();
                    }
                });
            });

            // Auto-hide alerts after 5 seconds
            const alerts = document.querySelectorAll('[role="alert"]');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.display = 'none';
                }, 5000);
            });
        });
    </script>
@endsection
