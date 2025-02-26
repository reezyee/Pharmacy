@extends('layouts.auth')

@section('content')
    <div class="flex justify-center items-center paddingX w-full">
        <div class="card bg-white w-[35vw] h-[80vh] mt-10 rounded-3xl">
            <div class="cardHead flex w-full items-center justify-between">
                <a href="/" class="text-[2rem] ms-5 mt-5">&larr;</a>
                <img src="{{ asset('storage/images/logo.png') }}" alt="Logo" class="w-14 me-5 mt-5">
            </div>
            <div class="cardBody">
                <p class="text-[2rem] font-semibold mb-10 text-center">Masuk</p>
                <div class="Form">
                    <form method="POST" action="{{ route('login') }}" class="max-w-xs mx-auto flex flex-col gap-10"
                        autocomplete="on">
                        @csrf
                        <div class="flex flex-col gap-5">
                            <!-- Input Email atau Phone -->
                            <div class="relative">
                                <input type="text" id="email_or_phone"
                                    class="block py-2.5 px-2 pe-0 w-full text-sm text-gray-900 bg-transparent focus:bg-gray-200 rounded-sm border-0 border-b-2 border-gray-300 hover:border-gray-400 transition-all ease-linear appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                    name="email_or_phone" required autofocus value="{{ old('email_or_phone') }}" placeholder=" " />
                                <label for="email_or_phone"
                                    class="peer-focus:font-medium absolute text-sm ms-2 text-gray-300 duration-300 transform -translate-y-6 scale-75 top-3 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-500 peer-focus:z-10 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                    Telepon atau Email
                                </label>
                                @error('email_or_phone')
                                    <div class="invalid-feedback text-red-600 text-[12px]">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Input Password -->
                            <div class="relative">
                                <input type="password" id="password"
                                    class="block py-2.5 px-2 pe-10 w-full text-sm text-gray-900 bg-transparent focus:bg-gray-200 rounded-sm border-0 border-b-2 border-gray-300 hover:border-gray-400 transition-all ease-linear appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                    name="password" required placeholder=" " />
                                <label for="password"
                                    class="peer-focus:font-medium absolute text-sm ms-2 text-gray-300 duration-300 transform -translate-y-6 scale-75 top-3 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-500 peer-focus:z-10 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                    Kata Sandi
                                </label>
                                @error('password')
                                    <div class="invalid-feedback text-red-600 text-[12px]">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <!-- Tombol Toggle Password -->
                                <button type="button" onclick="togglePassword()"
                                    class="absolute inset-y-0 right-2 flex items-center justify-center w-fit px-2 text-gray-500">
                                    <i id="eye-icon" class="fa fa-eye text-gray-500"></i>
                                </button>
                                <a href="{{ route('password.request') }}" class="text-blue-400 text-[12px] float-end w-full">Lupa Sandi?</a>
                            </div>
                        </div>

                        <!-- Login Button -->
                        <div class="flex flex-col gap-2">
                            <button type="submit"
                                class="bg-blue-600 text-white border border-blue-600 focus:outline-none focus:ring-1 focus:ring-blue-600 font-medium rounded-lg text-sm w-full py-2 me-2 mb-2">
                                Masuk
                            </button>
                            <a href="{{ route('register') }}" class="text-blue-400 text-[12px]">Buat Akun?</a>
                        </div>
                        <div class="flex justify-between">
                            <p class="border-b w-[25%] mb-2">
                            <p class="text-center text-slate-500">Atau Dengan</p>
                            <p class="border-b w-[25%] mb-2">   
                        </div>
                        <div class="flex justify-center">
                            <a href="{{ url('login/google') }}" role="button"
                                class="bg-white border hover:bg-gray-200 rounded-full p-2 w-fit">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 128 128">
                                    <path fill="#fff"
                                        d="M44.59 4.21a63.28 63.28 0 0 0 4.33 120.9a67.6 67.6 0 0 0 32.36.35a57.13 57.13 0 0 0 25.9-13.46a57.44 57.44 0 0 0 16-26.26a74.3 74.3 0 0 0 1.61-33.58H65.27v24.69h34.47a29.72 29.72 0 0 1-12.66 19.52a36.2 36.2 0 0 1-13.93 5.5a41.3 41.3 0 0 1-15.1 0A37.2 37.2 0 0 1 44 95.74a39.3 39.3 0 0 1-14.5-19.42a38.3 38.3 0 0 1 0-24.63a39.25 39.25 0 0 1 9.18-14.91A37.17 37.17 0 0 1 76.13 27a34.3 34.3 0 0 1 13.64 8q5.83-5.8 11.64-11.63c2-2.09 4.18-4.08 6.15-6.22A61.2 61.2 0 0 0 87.2 4.59a64 64 0 0 0-42.61-.38" />
                                    <path fill="#e33629"
                                        d="M44.59 4.21a64 64 0 0 1 42.61.37a61.2 61.2 0 0 1 20.35 12.62c-2 2.14-4.11 4.14-6.15 6.22Q95.58 29.23 89.77 35a34.3 34.3 0 0 0-13.64-8a37.17 37.17 0 0 0-37.46 9.74a39.25 39.25 0 0 0-9.18 14.91L8.76 35.6A63.53 63.53 0 0 1 44.59 4.21" />
                                    <path fill="#f8bd00"
                                        d="M3.26 51.5a63 63 0 0 1 5.5-15.9l20.73 16.09a38.3 38.3 0 0 0 0 24.63q-10.36 8-20.73 16.08a63.33 63.33 0 0 1-5.5-40.9" />
                                    <path fill="#587dbd"
                                        d="M65.27 52.15h59.52a74.3 74.3 0 0 1-1.61 33.58a57.44 57.44 0 0 1-16 26.26c-6.69-5.22-13.41-10.4-20.1-15.62a29.72 29.72 0 0 0 12.66-19.54H65.27c-.01-8.22 0-16.45 0-24.68" />
                                    <path fill="#319f43"
                                        d="M8.75 92.4q10.37-8 20.73-16.08A39.3 39.3 0 0 0 44 95.74a37.2 37.2 0 0 0 14.08 6.08a41.3 41.3 0 0 0 15.1 0a36.2 36.2 0 0 0 13.93-5.5c6.69 5.22 13.41 10.4 20.1 15.62a57.13 57.13 0 0 1-25.9 13.47a67.6 67.6 0 0 1-32.36-.35a63 63 0 0 1-23-11.59A63.7 63.7 0 0 1 8.75 92.4" />
                                </svg>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript untuk Toggle Password -->
    <script>
        function togglePassword() {
            let passwordInput = document.getElementById("password");
            let eyeIcon = document.getElementById("eye-icon");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                eyeIcon.classList.remove("fa-eye");
                eyeIcon.classList.add("fa-eye-slash");
            } else {
                passwordInput.type = "password";
                eyeIcon.classList.remove("fa-eye-slash");
                eyeIcon.classList.add("fa-eye");
            }
        }
    </script>
@endsection
