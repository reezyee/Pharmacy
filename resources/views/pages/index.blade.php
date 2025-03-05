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
            border-radius: 10px;
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
            <div class="flex flex-col items-center justify-center min-h-[60vh] md:h-[80vh] px-4 mx-auto max-w-2xl">
                <div class="neo-glass px-4 sm:px-6 py-3 mb-6 sm:mb-8 floating">
                    <div class="text-xs sm:text-sm/6">
                        Don't know the medicine to solve your problem? <a href="/user/chat"
                            class="font-semibold text-cyan-400 hover:text-cyan-300 transition-colors">Consultation<span
                                aria-hidden="true" class="ml-1">&rarr;</span></a>
                    </div>
                </div>
                <div class="text-center">
                    <h1 class="text-balance text-3xl sm:text-4xl md:text-6xl font-semibold tracking-tight text-gray-900">
                        Your Trusted Partner in Health & Wellness</h1>
                    <p class="mt-4 sm:mt-8 text-pretty text-base sm:text-lg md:text-xl/8 font-medium text-gray-500 px-4">
                        Caring for You, Every Step of the Way. Experience trusted pharmacy services with quality you can
                        count on.
                    </p>
                    <div
                        class="flex flex-col justify-between py-5 px-4 sm:px-6 md:px-10 mt-10 sm:mt-20 bg-white w-full sm:w-[90vw] md:w-[85vw] lg:w-[80vw] h-auto shadow-lg rounded-lg mx-auto">
                        <p class="text-center text-lg sm:text-xl md:text-[1.5rem] font-bold text-gray-800 mb-4 md:mb-6">
                            Medicines</p>
                        <div class="flex flex-wrap justify-center gap-3 sm:gap-5 items-center">
                            @foreach ($kategoris as $k)
                                <a href="{{ route('shop.filter', ['kategori' => $k->id]) }}" class="category-item mb-2">
                                    <div
                                        class="flex justify-center gap-2 sm:gap-3 px-3 sm:px-4 py-2 rounded-lg cursor-pointer h-fit items-center">
                                        <div
                                            class="w-8 h-8 sm:w-10 md:w-12 sm:h-10 md:h-12 bg-gradient-to-br from-cyan-400 to-lime-400 rounded-full 
                                            flex items-center justify-center mb-0 sm:mb-2 shadow-inner">
                                            <span
                                                class="text-base sm:text-lg font-bold text-white">{{ substr($k->nama, 0, 2) }}</span>
                                        </div>
                                        <p class="text-nowrap text-sm sm:text-base font-medium">{{ $k->nama }}</p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                        <div class="flex justify-center mt-4 sm:mt-6">
                            <a href="/shop" class="view-all-btn flex items-center gap-2 text-sm sm:text-base">
                                See All <span>&rarr;</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- AI-powered consultation section with enhanced visuals -->
        <div id="konsultasi" class="py-10 sm:py-16 md:py-20 px-4">
            <div class="container mx-auto">
                <div class="max-w-6xl mx-auto glass-card p-6 sm:p-8 md:p-10">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-10 items-center">
                        <div>
                            <h2 class="text-2xl sm:text-3xl font-bold mb-4 sm:mb-6">
                                <span class="gradient-text">Virtual Health Consultation</span>
                            </h2>
                            <p class="text-gray-900 mb-6 sm:mb-8 text-sm sm:text-base">
                                Get health advice from our professional pharmacists and doctors via virtual consultation. We
                                provide expert guidance, personalized recommendations, and convenient care—all from the
                                comfort of your home. Stay healthy with trusted advice at your fingertips.
                            </p>
                            <a href="/user/chat" class="holo-button inline-flex items-center gap-2 text-sm sm:text-base">
                                Start Consultation
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </a>
                        </div>
                        <div class="relative hidden sm:block">
                            <div
                                class="h-60 w-60 md:h-80 md:w-80 mx-auto bg-cyan-300/50 bg-opacity-20 rounded-full flex items-center justify-center">
                                <div
                                    class="h-48 w-48 md:h-64 md:w-64 bg-cyan-400 bg-opacity-20 rounded-full flex items-center justify-center animate-pulse">
                                    <div
                                        class="h-36 w-36 md:h-48 md:w-48 bg-gradient-to-br from-lime-400 to-cyan-400 rounded-full flex items-center justify-center neon-border">
                                        <svg class="w-16 h-16 md:w-24 md:h-24 text-white" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <!-- Enhanced floating elements -->
                            <div class="absolute top-0 left-0 w-8 h-8 md:w-10 md:h-10 bg-lime-400 rounded-full opacity-70 animate-bounce"
                                style="animation-duration: 3s;"></div>
                            <div class="absolute bottom-10 right-0 w-12 h-12 md:w-16 md:h-16 bg-cyan-400 rounded-full opacity-50 floating"
                                style="animation-delay: -2s;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-10">
            <!-- Dynamic carousel with data from database -->
            @foreach ($obatsByKategori as $kategoriId => $obats)
                @if (count($obats) > 0)
                    <div id="carousel-{{ $kategoriId }}" class="relative w-full mt-8 sm:mt-12 px-4"
                        data-carousel="static">
                        <p class="text-xl sm:text-[1.5rem] font-bold ms-2 sm:ms-5 text-gray-800 mb-4">
                            Catalogue
                        </p>
                        <!-- Wrapper untuk scroll horizontal -->
                        <div class="relative overflow-x-auto scroll-smooth snap-x snap-mandatory rounded-lg h-auto">
                            <!-- Container produk -->
                            <div class="flex gap-4 w-max px-4">
                                @foreach ($obats as $obat)
                                    <div
                                        class="product-card bg-gradient-to-br from-slate-900 to-cyan-900 rounded-2xl overflow-hidden transition-all duration-300 hover:scale-105 shadow-xl hover:shadow-lime-500/20 border border-cyan-400/20">
                                        <a href="{{ route('obat.detail', $obat->id) }}">
                                            <div class="relative">
                                                <img src="{{ asset('storage/' . $obat->foto) }}"
                                                    class="w-full h-40 object-cover object-center"
                                                    alt="{{ $obat->nama }}">
                                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent">
                                                </div>
                                            </div>
                                        </a>
                                        <div class="p-5 relative">
                                            <!-- Glowing orb decoration -->
                                            <div
                                                class="absolute -top-6 right-4 w-12 h-12 rounded-full bg-lime-400/20 blur-xl">
                                            </div>

                                            <h3 class="font-bold text-white text-lg truncate">{{ $obat->nama }}</h3>
                                            <p class="text-cyan-300 text-sm mb-3">Per {{ $obat->banyak }}
                                                {{ $obat->jenisObat?->nama ?? 'Tanpa Jenis' }}</p>
                                            <p class="text-xl font-bold text-lime-400 mb-4">
                                                Rp{{ number_format($obat->harga, 0, ',', '.') }}</p>

                                            <!-- Tombol Tambah ke Keranjang -->
                                            <a href="{{ route('obat.detail', $obat->id)}}">
                                                <button
                                                    class="w-full bg-gradient-to-r from-cyan-600 to-lime-600 hover:from-cyan-500 hover:to-lime-500 text-white px-4 py-3 rounded-xl transition-all duration-300 flex items-center justify-center gap-2 backdrop-blur-sm shadow-lg shadow-lime-600/20 border border-cyan-400/30">
                                                    <span>See Detail</span>
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <!-- Slider controls -->
                        <button type="button"
                            class="absolute top-1/2 -translate-y-1/2 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer"
                            data-carousel-prev>
                            <span
                                class="w-10 h-10 rounded-full bg-cyan-400/30 hover:bg-cyan-400/50 flex items-center justify-center">
                                <svg class="w-4 h-4 text-white rtl:rotate-180" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M5 1 1 5l4 4" />
                                </svg>
                            </span>
                        </button>
                        <button type="button"
                            class="absolute top-1/2 -translate-y-1/2 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer"
                            data-carousel-next>
                            <span
                                class="w-10 h-10 rounded-full bg-cyan-400/30 hover:bg-cyan-400/50 flex items-center justify-center">
                                <svg class="w-4 h-4 text-white rtl:rotate-180" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 9 4-4-4-4" />
                                </svg>
                            </span>
                        </button>
                    </div>
                @endif
            @endforeach
        </div>
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

            document.querySelectorAll('[data-carousel="static"]').forEach(carousel => {
                const wrapper = carousel.querySelector('.overflow-hidden'); // Container scrollable
                const nextButton = carousel.querySelector('[data-carousel-next]');
                const prevButton = carousel.querySelector('[data-carousel-prev]');

                function moveCarousel(direction) {
                    let scrollAmount = wrapper.clientWidth * 0.7; // Geser 70% lebar container
                    wrapper.scrollBy({
                        left: direction * scrollAmount,
                        behavior: 'smooth'
                    });
                }

                // Event listener untuk tombol navigasi
                if (nextButton) {
                    nextButton.addEventListener('click', () => moveCarousel(1));
                }
                if (prevButton) {
                    prevButton.addEventListener('click', () => moveCarousel(-1));
                }

                // Auto-slide setiap 5 detik
                let autoSlide = setInterval(() => moveCarousel(1), 5000);

                // Hentikan auto-slide saat user berinteraksi
                carousel.addEventListener('mouseenter', () => clearInterval(autoSlide));
                carousel.addEventListener('mouseleave', () => {
                    autoSlide = setInterval(() => moveCarousel(1), 5000);
                });
            });

            // Add glass morphism hover effect - only enable on devices that support hover
            // if (window.matchMedia('(hover: hover)').matches) {
            //     const glassCards = document.querySelectorAll('.neo-glass, .glass-card');

            //     glassCards.forEach(card => {
            //         card.addEventListener('mousemove', (e) => {
            //             const rect = card.getBoundingClientRect();
            //             const x = e.clientX - rect.left;
            //             const y = e.clientY - rect.top;

            //             const centerX = rect.width / 2;
            //             const centerY = rect.height / 2;

            //             const angleX = (y - centerY) / 10;
            //             const angleY = (centerX - x) / 10;

            //             card.style.transform =
            //                 `perspective(1000px) rotateX(${angleX}deg) rotateY(${angleY}deg) scale3d(1.05, 1.05, 1.05)`;
            //         });

            //         card.addEventListener('mouseleave', () => {
            //             card.style.transform = '';
            //             setTimeout(() => {
            //                 card.style.transition = '';
            //             }, 500);
            //         });
            //     });
            // }

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
