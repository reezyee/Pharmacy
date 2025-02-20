@extends('layouts.app')
@section('content')
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="relative">
        <div class="flex flex-col items-center justify-center h-[80vh] mx-auto max-w-2xl">
            <div class="hidden sm:mb-8 sm:flex sm:justify-center">
                <div
                    class="relative rounded-full px-3 py-1 text-sm/6 text-gray-600 ring-1 ring-gray-900/10 hover:ring-gray-900/20">
                    Tidak tahu obat untuk atasi masalahmu? <a href="#"
                        class="font-semibold text-cyan-600">Konsultasi<span aria-hidden="true">&rarr;</span></a>
                </div>
            </div>
            <div class="text-center">
                <h1 class="text-balance text-5xl font-semibold tracking-tight text-gray-900 sm:text-7xl">Selamat Datang
                    di Apotek Kami </h1>
                <p class="mt-8 text-pretty text-lg font-medium text-gray-500 sm:text-xl/8">Anim aute id magna aliqua ad
                    ad non deserunt sunt. Qui irure qui lorem cupidatat commodo. Elit sunt amet fugiat veniam occaecat.
                </p>
                <div class="flex flex-col justify-between py-5 px-10 mt-20 bg-white w-[80vw] h-[25vh]">
                    <p class="text-center text-[22px] font-semibold">Obat & Vitamin</p>
                    <div class="flex flex-wrap justify-between items-center">
                        @foreach ($kategoris as $k)
                            <div
                                class="flex justify-center gap-3 bg-lime-300 px-4 py-2 rounded-lg cursor-pointer h-fit items-center">
                                <img class="col-span-2 max-h-12 w-full mix-blend-darken"
                                    src="{{ asset('storage/' . $k->image) }}" alt="{{ $k->nama }}" width="158"
                                    height="48">
                                <p class="text-nowrap">{{ $k->nama }}</p>
                            </div>
                        @endforeach
                    </div>
                    <div class="flex justify-center">
                        <a href="" class="text-cyan-600">Lihat Semua <span>&rarr;</span></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="">
            <table class="flex justify-center">
                <tr class="">
                    <td class="General border-e border-black px-10">
                        <p class="text-[22px] font-semibold">
                            Masalah Kesehatan Umum
                        </p>
                        <ol class="mt-5">
                            <li
                                class="{{ request()->is('td') ? 'underline decoration-2 text-black' : 'text-black hover:underline hover:decoration-2' }} rounded-md px-3 py-2 text-sm cursor-pointer font-medium">
                                Tes Darah</li>
                            <li
                                class="{{ request()->is('bb') ? 'underline decoration-2 text-black' : 'text-black hover:underline hover:decoration-2' }} rounded-md px-3 py-2 text-sm cursor-pointer font-medium">
                                Penurunan Berat Badan</li>
                            <li
                                class="{{ request()->is('sti') ? 'underline decoration-2 text-black' : 'text-black hover:underline hover:decoration-2' }} rounded-md px-3 py-2 text-sm cursor-pointer font-medium">
                                STI Tes</li>
                            <li
                                class="{{ request()->is('dll') ? 'underline decoration-2 text-black' : 'text-black hover:underline hover:decoration-2' }} rounded-md px-3 py-2 text-sm cursor-pointer font-medium">
                                Lihat Semua</li>
                        </ol>
                    </td>
                    <td class="Women border-e border-black px-10">
                        <p class="text-[22px] font-semibold">
                            Masalah Kesehatan Wanita
                        </p>
                        <ol class="mt-5">
                            <li
                                class="{{ request()->is('td') ? 'underline decoration-2 text-black' : 'text-black hover:underline hover:decoration-2' }} rounded-md px-3 py-2 text-sm cursor-pointer font-medium">
                                Tes Darah</li>
                            <li
                                class="{{ request()->is('bb') ? 'underline decoration-2 text-black' : 'text-black hover:underline hover:decoration-2' }} rounded-md px-3 py-2 text-sm cursor-pointer font-medium">
                                Penurunan Berat Badan</li>
                            <li
                                class="{{ request()->is('sti') ? 'underline decoration-2 text-black' : 'text-black hover:underline hover:decoration-2' }} rounded-md px-3 py-2 text-sm cursor-pointer font-medium">
                                STI Tes</li>
                            <li
                                class="{{ request()->is('dll') ? 'underline decoration-2 text-black' : 'text-black hover:underline hover:decoration-2' }} rounded-md px-3 py-2 text-sm cursor-pointer font-medium">
                                Lihat Semua</li>
                        </ol>
                    </td>
                    <td class="Men px-10">
                        <p class="text-[22px] font-semibold">
                            Masalah Kesehatan Pria
                        </p>
                        <ol class="mt-5">
                            <li
                                class="{{ request()->is('td') ? 'underline decoration-2 text-black' : 'text-black hover:underline hover:decoration-2' }} rounded-md px-3 py-2 text-sm cursor-pointer font-medium">
                                Tes Darah</li>
                            <li
                                class="{{ request()->is('bb') ? 'underline decoration-2 text-black' : 'text-black hover:underline hover:decoration-2' }} rounded-md px-3 py-2 text-sm cursor-pointer font-medium">
                                Penurunan Berat Badan</li>
                            <li
                                class="{{ request()->is('sti') ? 'underline decoration-2 text-black' : 'text-black hover:underline hover:decoration-2' }} rounded-md px-3 py-2 text-sm cursor-pointer font-medium">
                                STI Tes</li>
                            <li
                                class="{{ request()->is('dll') ? 'underline decoration-2 text-black' : 'text-black hover:underline hover:decoration-2' }} rounded-md px-3 py-2 text-sm cursor-pointer font-medium">
                                Lihat Semua</li>
                        </ol>
                    </td>
                </tr>
            </table>
        </div>
        <div id="controls-carousel" class="relative w-full mt-12 duration-150" data-carousel="static">
            <p class="text-[22px] font-semibold ms-5">Demam, Flu & Batuk</p>
            <!-- Carousel wrapper -->
            <div class="relative overflow-hidden rounded-lg h-[400px]">
                <!-- Item 1 -->
                <div class="flex justify-around w-full duration-700 ease-in-out" data-carousel-item>
                    <div class="w-72 bg-white border border-gray-200 rounded-lg shadow flex flex-col">
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
                                class="inline-flex w-fit items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                Lihat
                                <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="w-72 bg-white border border-gray-200 rounded-lg shadow flex flex-col">
                        <a href="#" class="flex justify-center w-full">
                            <img class="rounded-t-lg w-64 h-64" src="b2.jpeg" alt="" />
                        </a>
                        <div class="p-5 flex flex-col h-full justify-between">
                            <a href="#">
                                <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900">
                                    Vicks Formula 44</h5>
                            </a>
                            <a href="#"
                                class="inline-flex items-center px-3 py-2 text-sm font-medium text-center w-fit text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                Lihat
                                <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="w-72 bg-white border border-gray-200 rounded-lg shadow flex flex-col">
                        <a href="#" class="flex justify-center w-full">
                            <img class="rounded-t-lg w-64 h-64" src="b2.jpeg" alt="" />
                        </a>
                        <div class="p-5 flex flex-col h-full justify-between">
                            <a href="#">
                                <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900">
                                    Vicks Formula 44</h5>
                            </a>
                            <a href="#"
                                class="inline-flex items-center px-3 py-2 text-sm font-medium text-center w-fit text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                Lihat
                                <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="w-72 bg-white border border-gray-200 rounded-lg shadow flex flex-col">
                        <a href="#" class="flex justify-center w-full">
                            <img class="rounded-t-lg w-64 h-64" src="b3.jpeg" alt="" />
                        </a>
                        <div class="p-5 flex flex-col h-full justify-between">
                            <a href="#">
                                <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900">
                                    Bodrex flu & batuk berdahak ph</h5>
                            </a>
                            <a href="#"
                                class="inline-flex w-fit items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
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
                <!-- Item 2 -->
                <div class="flex justify-around w-full duration-700 ease-in-out" data-carousel-item="active">
                    <div class="w-72 bg-white border border-gray-200 rounded-lg shadow flex flex-col">
                        <a href="#" class="flex justify-center w-full">
                            <img class="rounded-t-lg w-64 h-64" src="d1.jpeg" alt="" />
                        </a>
                        <div class="p-5 flex flex-col h-full justify-between">
                            <a href="#">
                                <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900">
                                    Sumagesic Paracetamol 600mg</h5>
                            </a>
                            <a href="#"
                                class="inline-flex w-fit items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                Lihat
                                <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="w-72 bg-white border border-gray-200 rounded-lg shadow flex flex-col">
                        <a href="#" class="flex justify-center w-full">
                            <img class="rounded-t-lg w-64 h-64" src="d1.jpeg" alt="" />
                        </a>
                        <div class="p-5 flex flex-col h-full justify-between">
                            <a href="#">
                                <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900">
                                    Sumagesic Paracetamol 600mg</h5>
                            </a>
                            <a href="#"
                                class="inline-flex w-fit items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                Lihat
                                <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="w-72 bg-white border border-gray-200 rounded-lg shadow flex flex-col">
                        <a href="#" class="flex justify-center w-full">
                            <img class="rounded-t-lg w-64 h-64" src="d2.jpg" alt="" />
                        </a>
                        <div class="p-5 flex flex-col h-full justify-between">
                            <a href="#">
                                <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900">
                                    Panadol Paracetamol</h5>
                            </a>
                            <a href="#"
                                class="inline-flex w-fit items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                Lihat
                                <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="w-72 bg-white border border-gray-200 rounded-lg shadow flex flex-col">
                        <a href="#" class="flex justify-center w-full">
                            <img class="rounded-t-lg w-64 h-64" src="d3.jpg" alt="" />
                        </a>
                        <div class="p-5 flex flex-col h-full justify-between">
                            <a href="#" class="">
                                <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900">
                                    Bodrex Demam</h5>
                            </a>
                            <a href="#"
                                class="inline-flex w-fit items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
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
                <!-- Item 3 -->
                <div class="flex justify-around w-full duration-700 ease-in-out" data-carousel-item="active">
                    <div class="w-72 bg-white border border-gray-200 rounded-lg shadow flex flex-col">
                        <a href="#" class="flex justify-center w-full">
                            <img class="rounded-t-lg w-64 h-64" src="d1.jpeg" alt="" />
                        </a>
                        <div class="p-5 flex flex-col h-full justify-between">
                            <a href="#">
                                <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900">
                                    Sumagesic Paracetamol 600mg</h5>
                            </a>
                            <a href="#"
                                class="inline-flex w-fit items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                Lihat
                                <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="w-72 bg-white border border-gray-200 rounded-lg shadow flex flex-col">
                        <a href="#" class="flex justify-center w-full">
                            <img class="rounded-t-lg w-64 h-64" src="d1.jpeg" alt="" />
                        </a>
                        <div class="p-5 flex flex-col h-full justify-between">
                            <a href="#">
                                <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900">
                                    Sumagesic Paracetamol 600mg</h5>
                            </a>
                            <a href="#"
                                class="inline-flex w-fit items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                Lihat
                                <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="w-72 bg-white border border-gray-200 rounded-lg shadow flex flex-col">
                        <a href="#" class="flex justify-center w-full">
                            <img class="rounded-t-lg w-64 h-64" src="b2.jpeg" alt="" />
                        </a>
                        <div class="p-5 flex flex-col h-full justify-between">
                            <a href="#">
                                <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900">
                                    Vicks Formula 44</h5>
                            </a>
                            <a href="#"
                                class="inline-flex w-fit items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                Lihat
                                <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="w-72 bg-white border border-gray-200 rounded-lg shadow flex flex-col">
                        <a href="#" class="flex justify-center w-full">
                            <img class="rounded-t-lg w-64 h-64" src="d3.jpg" alt="" />
                        </a>
                        <div class="p-5 flex flex-col h-full justify-between">
                            <a href="#">
                                <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900">
                                    Bodrex Demam</h5>
                            </a>
                            <a href="#"
                                class="inline-flex w-fit items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
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
                    class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-black/30 group-hover:bg-black/50">
                    <svg class="w-4 h-4 text-black rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 6 10">
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
                    class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-black/30 group-hover:bg-black/50">
                    <svg class="w-4 h-4 text-black rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 9 4-4-4-4" />
                    </svg>
                    <span class="sr-only">Next</span>
                </span>
            </button>
        </div>
    </div>
@endsection
