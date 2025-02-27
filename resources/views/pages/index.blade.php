@extends('layouts.app')
@section('content')
    <style>
        /* Refined glass morphism effect with updated color scheme */
        .neo-glass {
            backdrop-filter: blur(16px);
            border-radius: 24px;
            transition: all 0.5s cubic-bezier(0.25, 0.8, 0.25, 1);
            overflow: hidden;
            position: relative;
            background: rgba(34, 211, 238, 0.07);
            /* cyan-400 with transparency */
            border: 1px solid rgba(34, 211, 238, 0.18);
        }

        .neo-glass:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 10px 0 rgba(34, 211, 238, 0.5);
        }

        /* Updated button style with cyan and lime accents */
        .holo-button {
            position: relative;
            background: linear-gradient(135deg, rgba(34, 211, 238, 0.4) 0%, rgba(163, 230, 53, 0.4) 100%);
            color: white;
            border: 1px solid rgba(34, 211, 238, 0.3);
            border-radius: 12px;
            padding: 0.8em 2.2em;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-shadow: 0 0 8px rgba(34, 211, 238, 0.8);
            box-shadow: 0 0 15px rgba(34, 211, 238, 0.3);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .holo-button:hover {
            background: linear-gradient(135deg, rgba(34, 211, 238, 0.6) 0%, rgba(163, 230, 53, 0.6) 100%);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 0 20px rgba(34, 211, 238, 0.5);
        }

        /* Enhanced animations */
        @keyframes float {
            0% {
                transform: translateY(0px) translateX(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-10px) translateX(5px) rotate(2deg);
            }

            100% {
                transform: translateY(0px) translateX(0px) rotate(0deg);
            }
        }

        @keyframes pulse {
            0% {
                opacity: 0.3;
                transform: scale(1);
            }

            50% {
                opacity: 0.7;
                transform: scale(1.05);
            }

            100% {
                opacity: 0.3;
                transform: scale(1);
            }
        }

        .floating {
            animation: float 12s ease-in-out infinite;
        }

        /* Updated product card styling with cyan-400 and lime-400 theme */
        .glass-card {
            background: rgba(34, 211, 238, 0.07);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            border: 1px solid rgba(34, 211, 238, 0.18);
            box-shadow: 0 8px 32px 0 rgba(34, 211, 238, 0.118);
            transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        .glass-card:hover {
            box-shadow: 0 10px 40px 0 rgba(34, 211, 238, 0.3);
            transform: translateY(-5px);
        }

        .category-item {
            background: rgba(163, 230, 53, 0.7);
            transition: all 0.3s ease;
            border: 1px solid rgba(163, 230, 53, 0.3);
        }

        .category-item:hover {
            background: rgba(163, 230, 53, 0.9);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(163, 230, 53, 0.4);
        }

        .view-all-btn {
            background: rgba(34, 211, 238, 0.8);
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }

        .view-all-btn:hover {
            background: rgba(34, 211, 238, 1);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(34, 211, 238, 0.4);
        }

        .gradient-text {
            background: linear-gradient(135deg, #22d3ee 0%, #a3e635 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            color: transparent;
        }

        .product-card {
            transition: all 0.3s ease;
            border: 1px solid rgba(34, 211, 238, 0.2);
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(34, 211, 238, 0.3);
        }

        .product-btn {
            background: rgba(34, 211, 238, 0.8);
            transition: all 0.3s ease;
        }

        .product-btn:hover {
            background: rgba(34, 211, 238, 1);
            transform: translateY(-2px);
        }

        .health-category {
            transition: all 0.3s ease;
        }

        .health-category:hover li {
            color: #22d3ee;
        }
    </style>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="relative">
        <div class="hero-parallax">
            <div class="flex flex-col items-center justify-center h-[80vh] mx-auto max-w-2xl">
                <div class="neo-glass px-6 py-3 mb-8 floating">
                    <div class="text-sm/6">
                        Tidak tahu obat untuk atasi masalahmu? <a href="/user/chat"
                            class="font-semibold text-cyan-400 hover:text-cyan-300 transition-colors">Konsultasi<span
                                aria-hidden="true" class="ml-1">&rarr;</span></a>
                    </div>
                </div>
                <div class="text-center">
                    <h1 class="text-balance text-5xl font-semibold tracking-tight text-gray-900 sm:text-7xl">Selamat Datang
                        di Apotek Kami </h1>
                    <p class="mt-8 text-pretty text-lg font-medium text-gray-500 sm:text-xl/8">Anim aute id magna aliqua ad
                        ad non deserunt sunt. Qui irure qui lorem cupidatat commodo. Elit sunt amet fugiat veniam occaecat.
                    </p>
                    <div
                        class="flex flex-col justify-between py-5 px-10 mt-20 bg-white w-[80vw] h-auto shadow-lg rounded-lg">
                        <p class="text-center text-[22px] font-semibold text-gray-800 mb-6">Obat & Vitamin</p>
                        <div class="flex flex-wrap justify-center gap-5 items-center">
                            @foreach ($kategoris as $k)
                                <a href="{{ route('shop.filter', ['kategori' => $k->id]) }}" class="category-item">
                                    <div
                                        class="flex justify-center gap-3 px-4 py-2 rounded-lg cursor-pointer h-fit items-center">
                                        <img class="max-h-12 w-full mix-blend-darken"
                                            src="{{ asset('storage/' . $k->image) }}" alt="{{ $k->nama }}"
                                            width="158" height="48">
                                        <p class="text-nowrap font-medium">{{ $k->nama }}</p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                        <div class="flex justify-center mt-6">
                            <a href="/shop" class="view-all-btn flex items-center gap-2">
                                Lihat Semua <span>&rarr;</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="my-12">
            <table class="flex justify-center">
                <tr class="">
                    <td class="health-category General border-e border-cyan-200 px-10">
                        <p class="text-[22px] font-semibold text-gray-800 mb-2">
                            Masalah Kesehatan Umum
                        </p>
                        <ol class="mt-5">
                            <li
                                class="{{ request()->is('td') ? 'underline decoration-2 text-cyan-400' : 'text-gray-700 hover:text-cyan-400 hover:underline hover:decoration-2' }} rounded-md px-3 py-2 text-sm cursor-pointer font-medium transition-all">
                                Tes Darah</li>
                            <li
                                class="{{ request()->is('bb') ? 'underline decoration-2 text-cyan-400' : 'text-gray-700 hover:text-cyan-400 hover:underline hover:decoration-2' }} rounded-md px-3 py-2 text-sm cursor-pointer font-medium transition-all">
                                Penurunan Berat Badan</li>
                            <li
                                class="{{ request()->is('sti') ? 'underline decoration-2 text-cyan-400' : 'text-gray-700 hover:text-cyan-400 hover:underline hover:decoration-2' }} rounded-md px-3 py-2 text-sm cursor-pointer font-medium transition-all">
                                STI Tes</li>
                            <li
                                class="{{ request()->is('dll') ? 'underline decoration-2 text-cyan-400' : 'text-gray-700 hover:text-cyan-400 hover:underline hover:decoration-2' }} rounded-md px-3 py-2 text-sm cursor-pointer font-medium transition-all">
                                Lihat Semua</li>
                        </ol>
                    </td>
                    <td class="health-category Women border-e border-cyan-200 px-10">
                        <p class="text-[22px] font-semibold text-gray-800 mb-2">
                            Masalah Kesehatan Wanita
                        </p>
                        <ol class="mt-5">
                            <li
                                class="{{ request()->is('td') ? 'underline decoration-2 text-cyan-400' : 'text-gray-700 hover:text-cyan-400 hover:underline hover:decoration-2' }} rounded-md px-3 py-2 text-sm cursor-pointer font-medium transition-all">
                                Tes Darah</li>
                            <li
                                class="{{ request()->is('bb') ? 'underline decoration-2 text-cyan-400' : 'text-gray-700 hover:text-cyan-400 hover:underline hover:decoration-2' }} rounded-md px-3 py-2 text-sm cursor-pointer font-medium transition-all">
                                Penurunan Berat Badan</li>
                            <li
                                class="{{ request()->is('sti') ? 'underline decoration-2 text-cyan-400' : 'text-gray-700 hover:text-cyan-400 hover:underline hover:decoration-2' }} rounded-md px-3 py-2 text-sm cursor-pointer font-medium transition-all">
                                STI Tes</li>
                            <li
                                class="{{ request()->is('dll') ? 'underline decoration-2 text-cyan-400' : 'text-gray-700 hover:text-cyan-400 hover:underline hover:decoration-2' }} rounded-md px-3 py-2 text-sm cursor-pointer font-medium transition-all">
                                Lihat Semua</li>
                        </ol>
                    </td>
                    <td class="health-category Men px-10">
                        <p class="text-[22px] font-semibold text-gray-800 mb-2">
                            Masalah Kesehatan Pria
                        </p>
                        <ol class="mt-5">
                            <li
                                class="{{ request()->is('td') ? 'underline decoration-2 text-cyan-400' : 'text-gray-700 hover:text-cyan-400 hover:underline hover:decoration-2' }} rounded-md px-3 py-2 text-sm cursor-pointer font-medium transition-all">
                                Tes Darah</li>
                            <li
                                class="{{ request()->is('bb') ? 'underline decoration-2 text-cyan-400' : 'text-gray-700 hover:text-cyan-400 hover:underline hover:decoration-2' }} rounded-md px-3 py-2 text-sm cursor-pointer font-medium transition-all">
                                Penurunan Berat Badan</li>
                            <li
                                class="{{ request()->is('sti') ? 'underline decoration-2 text-cyan-400' : 'text-gray-700 hover:text-cyan-400 hover:underline hover:decoration-2' }} rounded-md px-3 py-2 text-sm cursor-pointer font-medium transition-all">
                                STI Tes</li>
                            <li
                                class="{{ request()->is('dll') ? 'underline decoration-2 text-cyan-400' : 'text-gray-700 hover:text-cyan-400 hover:underline hover:decoration-2' }} rounded-md px-3 py-2 text-sm cursor-pointer font-medium transition-all">
                                Lihat Semua</li>
                        </ol>
                    </td>
                </tr>
            </table>
        </div>
        <!-- AI-powered consultation section with enhanced visuals -->
        <div id="konsultasi" class="py-20">
            <div class="container mx-auto px-4">
                <div class="max-w-6xl mx-auto glass-card p-10">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-center">
                        <div>
                            <h2 class="text-3xl font-bold mb-6">
                                <span class="gradient-text">Konsultasi Kesehatan Virtual</span>
                            </h2>
                            <p class="text-gray-900 mb-8">
                                Dapatkan saran kesehatan dari apoteker profesional kami melalui konsultasi virtual. Kami
                                menggunakan teknologi AI untuk membantu diagnosis awal dan rekomendasi obat yang tepat
                                untuk kondisi Anda.
                            </p>
                            <a href="/user/chat" class="holo-button inline-flex items-center gap-2">
                                Mulai Konsultasi
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </a>
                        </div>
                        <div class="relative">
                            <div
                                class="h-80 w-80 mx-auto bg-cyan-300/50 bg-opacity-20 rounded-full flex items-center justify-center">
                                <div
                                    class="h-64 w-64 bg-cyan-400 bg-opacity-20 rounded-full flex items-center justify-center animate-pulse">
                                    <div
                                        class="h-48 w-48 bg-gradient-to-br from-lime-400 to-cyan-400 rounded-full flex items-center justify-center neon-border">
                                        <svg class="w-24 h-24 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <!-- Enhanced floating elements -->
                            <div class="absolute top-0 left-0 w-10 h-10 bg-lime-400 rounded-full opacity-70 animate-bounce"
                                style="animation-duration: 3s;"></div>
                            <div class="absolute bottom-10 right-0 w-16 h-16 bg-cyan-400 rounded-full opacity-50 floating"
                                style="animation-delay: -2s;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dynamic carousel with data from database -->
        @if (isset($obatsByKategori) && count($obatsByKategori) > 0)
            @foreach ($obatsByKategori as $kategoriId => $obats)
                @if (count($obats) > 0)
                    <div id="carousel-{{ $kategoriId }}" class="relative w-full mt-12 duration-150"
                        data-carousel="static">
                        <p class="text-[22px] font-semibold ms-5 text-gray-800">
                            {{ $kategoris->where('id', $kategoriId)->first()->nama ?? 'Produk' }}
                        </p>
                        <!-- Carousel wrapper -->
                        <div class="relative overflow-hidden rounded-lg h-[400px]">
                            <!-- Items -->
                            <div class="flex justify-around w-full duration-700 ease-in-out" data-carousel-item>
                                @foreach ($obats as $obat)
                                    <div
                                        class="w-72 product-card bg-white border border-cyan-100 rounded-lg shadow flex flex-col">
                                        <a href="{{ route('obat.detail', $obat->id) }}" class="flex justify-center w-full">
                                            <img class="rounded-t-lg w-64 h-64 object-cover"
                                                src="{{ asset('storage/' . ($obat->foto ?? 'images/default-medicine.jpg')) }}"
                                                alt="{{ $obat->nama }}" />
                                        </a>
                                        <div class="p-5 flex flex-col h-full justify-between">
                                            <a href="{{ route('obat.detail', $obat->id) }}">
                                                <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900">
                                                    {{ $obat->nama }}</h5>
                                            </a>
                                            <div class="mt-2 text-sm text-gray-500">
                                                <p>Rp {{ number_format($obat->harga, 0, ',', '.') }}</p>
                                            </div>
                                            <a href="{{ route('obat.detail', $obat->id) }}"
                                                class="mt-4 inline-flex w-fit items-center px-3 py-2 text-sm font-medium text-center text-white product-btn rounded-lg hover:bg-cyan-500 focus:ring-4 focus:outline-none focus:ring-cyan-300">
                                                Lihat
                                                <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 14 10">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="M1 5h12m0 0L9 1m4 4L9 9" />
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <!-- Slider controls -->
                        <button type="button"
                            class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                            data-carousel-prev>
                            <span
                                class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-cyan-400/30 group-hover:bg-cyan-400/50 group-focus:bg-cyan-400/70">
                                <svg class="w-4 h-4 text-white rtl:rotate-180" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M5 1 1 5l4 4" />
                                </svg>
                                <span class="sr-only">Previous</span>
                            </span>
                        </button>
                        <button type="button"
                            class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                            data-carousel-next>
                            <span
                                class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-cyan-400/30 group-hover:bg-cyan-400/50 group-focus:bg-cyan-400/70">
                                <svg class="w-4 h-4 text-white rtl:rotate-180" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 9 4-4-4-4" />
                                </svg>
                                <span class="sr-only">Next</span>
                            </span>
                        </button>
                    </div>
                @endif
            @endforeach
        @else
            <!-- Fallback static carousel if no dynamic data is available -->
            <div id="controls-carousel" class="relative w-full mt-12 duration-150" data-carousel="static">
                <p class="text-[22px] font-semibold ms-5 text-gray-800">Demam, Flu & Batuk</p>
                <!-- Carousel wrapper -->
                <div class="relative overflow-hidden rounded-lg h-[400px]">
                    <!-- Item 1 -->
                    <div class="flex justify-around w-full duration-700 ease-in-out" data-carousel-item>
                        <div class="w-72 product-card bg-white border border-cyan-100 rounded-lg shadow flex flex-col">
                            <a href="#" class="flex justify-center w-full">
                                <img class="rounded-t-lg w-64 h-64" src="{{ asset('storage/images/b1.jpeg') }}"
                                    alt="" />
                            </a>
                            <div class="p-5 flex flex-col h-full justify-between">
                                <a href="#">
                                    <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900">
                                        Siladex</h5>
                                </a>
                                <a href="#"
                                    class="inline-flex w-fit items-center px-3 py-2 text-sm font-medium text-center text-white product-btn rounded-lg">
                                    Lihat
                                    <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <div class="w-72 product-card bg-white border border-cyan-100 rounded-lg shadow flex flex-col">
                            <a href="#" class="flex justify-center w-full">
                                <img class="rounded-t-lg w-64 h-64" src="{{ asset('storage/images/b2.jpeg') }}"
                                    alt="" />
                            </a>
                            <div class="p-5 flex flex-col h-full justify-between">
                                <a href="#">
                                    <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900">
                                        Vicks Formula 44</h5>
                                </a>
                                <a href="#"
                                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-center w-fit text-white product-btn rounded-lg">
                                    Lihat
                                    <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <div class="w-72 product-card bg-white border border-cyan-100 rounded-lg shadow flex flex-col">
                            <a href="#" class="flex justify-center w-full">
                                <img class="rounded-t-lg w-64 h-64" src="{{ asset('storage/images/b2.jpeg') }}"
                                    alt="" />
                            </a>
                            <div class="p-5 flex flex-col h-full justify-between">
                                <a href="#">
                                    <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900">
                                        Vicks Formula 44</h5>
                                </a>
                                <a href="#"
                                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-center w-fit text-white product-btn rounded-lg">
                                    Lihat
                                    <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <div class="w-72 product-card bg-white border border-cyan-100 rounded-lg shadow flex flex-col">
                            <a href="#" class="flex justify-center w-full">
                                <img class="rounded-t-lg w-64 h-64" src="{{ asset('storage/images/b3.jpeg') }}"
                                    alt="" />
                            </a>
                            <div class="p-5 flex flex-col h-full justify-between">
                                <a href="#">
                                    <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900">
                                        Bodrex flu & batuk berdahak</h5>
                                </a>
                                <a href="#"
                                    class="inline-flex w-fit items-center px-3 py-2 text-sm font-medium text-center text-white product-btn rounded-lg">
                                    Lihat
                                    <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Slider controls -->
                <button type="button"
                    class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                    data-carousel-prev>
                    <span
                        class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-cyan-400/30 group-hover:bg-cyan-400/50 group-focus:bg-cyan-400/70">
                        <svg class="w-4 h-4 text-white rtl:rotate-180" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 1 1 5l4 4" />
                        </svg>
                        <span class="sr-only">Previous</span>
                    </span>
                </button>
                <button type="button"
                    class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                    data-carousel-next>
                    <span
                        class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-cyan-400/30 group-hover:bg-cyan-400/50 group-focus:bg-cyan-400/70">
                        <svg class="w-4 h-4 text-white rtl:rotate-180" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>
                        <span class="sr-only">Next</span>
                    </span>
                </button>
            </div>
        @endif
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Enhanced parallax effect
            const heroLayers = document.querySelectorAll('.hero-layer');

            function updateParallax() {
                const scrollPosition = window.pageYOffset;

                heroLayers.forEach(layer => {
                    const speed = layer.getAttribute('data-speed');
                    const yPos = -(scrollPosition * speed);
                    layer.style.transform = `translateY(${yPos}px)`;
                });
            }

            // Initialize parallax effect
            window.addEventListener('scroll', updateParallax);

            // Initialize carousel functionality
            const carouselItems = document.querySelectorAll('[data-carousel="static"]');

            carouselItems.forEach(carousel => {
                const items = carousel.querySelectorAll('[data-carousel-item]');
                const nextButton = carousel.querySelector('[data-carousel-next]');
                const prevButton = carousel.querySelector('[data-carousel-prev]');
                let currentIndex = 0;

                function showItem(index) {
                    items.forEach((item, i) => {
                        if (i === index) {
                            item.classList.remove('hidden');
                            item.classList.add('block');
                        } else {
                            item.classList.add('hidden');
                            item.classList.remove('block');
                        }
                    });
                    currentIndex = index;
                }

                // Show first item initially
                showItem(0);

                // Add event listeners for next/prev buttons
                if (nextButton) {
                    nextButton.addEventListener('click', () => {
                        let newIndex = currentIndex + 1;
                        if (newIndex >= items.length) {
                            newIndex = 0;
                        }
                        showItem(newIndex);
                    });
                }

                if (prevButton) {
                    prevButton.addEventListener('click', () => {
                        let newIndex = currentIndex - 1;
                        if (newIndex < script 0) {
                            newIndex = items.length - 1;
                        }
                        showItem(newIndex);
                    });
                }

                // Auto slide every 5 seconds
                setInterval(() => {
                    let newIndex = currentIndex + 1;
                    if (newIndex >= items.length) {
                        newIndex = 0;
                    }
                    showItem(newIndex);
                }, 5000);
            });

            // Add glass morphism hover effect
            const glassCards = document.querySelectorAll('.neo-glass, .glass-card');

            glassCards.forEach(card => {
                card.addEventListener('mousemove', (e) => {
                    const rect = card.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;

                    const centerX = rect.width / 2;
                    const centerY = rect.height / 2;

                    const angleX = (y - centerY) / 10;
                    const angleY = (centerX - x) / 10;

                    card.style.transform =
                        `perspective(1000px) rotateX(${angleX}deg) rotateY(${angleY}deg) scale3d(1.05, 1.05, 1.05)`;
                });

                card.addEventListener('mouseleave', () => {
                    card.style.transform = '';
                    setTimeout(() => {
                        card.style.transition = '';
                    }, 500);
                });
            });

            // Add smooth scroll for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();

                    const targetId = this.getAttribute('href');
                    const targetElement = document.querySelector(targetId);

                    if (targetElement) {
                        window.scrollTo({
                            top: targetElement.offsetTop,
                            behavior: 'smooth'
                        });
                    }
                });
            });
        });
    </script>
@endsection
