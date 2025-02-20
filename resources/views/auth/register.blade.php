@extends('layouts.auth')

@section('content')
    <div class="flex justify-center items-center paddingX w-full">
        <div class="card bg-white w-[35vw] h-[80vh] mt-10 rounded-3xl">
            <div class="cardHead flex w-full items-center justify-between">
                <a href="/" class="text-[2rem] ms-5 mt-5">&larr;</a>
                <img src="{{ asset('storage/images/logo.png') }}" alt="Logo" class="w-14 me-5 mt-5">
            </div>
            <div class="card-body">
                <p class="text-[2rem] font-semibold mb-7 text-center">Daftar</p>
                <form method="POST" action="{{ route('register') }}" class="max-w-xs mx-auto flex flex-col gap-7" autocomplete="on">
                    @csrf

                    <!-- Input Name -->
                    <div class="relative">
                        <input type="text" id="floating-name" name="name" value="{{ old('name')}}" required autofocus placeholder=" "
                            class="block py-2.5 px-2 pe-0 w-full text-sm text-gray-900 bg-transparent focus:bg-gray-200 rounded-sm border-0 border-b-2 border-gray-300 hover:border-gray-400 transition-all ease-linear appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" />
                        <label for="floating-name" class="peer-focus:font-medium absolute text-sm ms-2 text-gray-300 duration-300 transform -translate-y-6 scale-75 top-3 origin-[0] peer-focus:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                            Nama
                        </label>
                        @error('name')
                            <div class="invalid-feedback text-red-600">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Input Email -->
                    <div class="relative">
                        <input type="text" id="floating-email" name="email" value="{{ old('email')}}" required autofocus placeholder=" "
                            class="block py-2.5 px-2 pe-0 w-full text-sm text-gray-900 bg-transparent focus:bg-gray-200 rounded-sm border-0 border-b-2 border-gray-300 hover:border-gray-400 transition-all ease-linear appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" />
                        <label for="floating-email" class="peer-focus:font-medium absolute text-sm ms-2 text-gray-300 duration-300 transform -translate-y-6 scale-75 top-3 origin-[0] peer-focus:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                            Email
                        </label>
                        @error('email')
                            <div class="invalid-feedback text-red-600">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <!-- Input Phone Number -->
                    <div class="relative">
                        <input type="text" id="floating-phone" name="phone" value="{{ old('phone')}}" required autofocus placeholder=" "
                            class="block py-2.5 px-2 pe-0 w-full text-sm text-gray-900 bg-transparent focus:bg-gray-200 rounded-sm border-0 border-b-2 border-gray-300 hover:border-gray-400 transition-all ease-linear appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" />
                        <label for="floating-phone" class="peer-focus:font-medium absolute text-sm ms-2 text-gray-300 duration-300 transform -translate-y-6 scale-75 top-3 origin-[0] peer-focus:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                            No. HP
                        </label>
                        @error('phone')
                            <div class="invalid-feedback text-red-600">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="flex gap-5">
                        <!-- Input Password -->
                        <div class="relative w-1/2">
                            <input type="password" id="password" name="password" required placeholder=" "
                                class="block py-2.5 px-2 pe-10 w-full text-sm text-gray-900 bg-transparent focus:bg-gray-200 rounded-sm border-0 border-b-2 border-gray-300 hover:border-gray-400 transition-all ease-linear appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" />
                            <label for="password" class="peer-focus:font-medium absolute text-sm ms-2 text-gray-300 duration-300 transform -translate-y-6 scale-75 top-3 origin-[0] peer-focus:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                Kata Sandi
                            </label>
                            <!-- Toggle Eye Icon -->
                            <button type="button" onclick="togglePassword('password', 'eye-icon1')" class="absolute inset-y-0 right-2 flex items-center px-2 text-gray-500">
                                <i id="eye-icon1" class="fa fa-eye text-gray-500"></i>
                            </button>
                        </div>
    
                        <!-- Input Confirm Password -->
                        <div class="relative w-1/2">
                            <input type="password" id="confirm-password" name="password_confirmation" required placeholder=" "
                                class="block py-2.5 px-2 pe-10 w-full text-sm text-gray-900 bg-transparent focus:bg-gray-200 rounded-sm border-0 border-b-2 border-gray-300 hover:border-gray-400 transition-all ease-linear appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" />
                            <label for="confirm-password" class="peer-focus:font-medium absolute text-sm ms-2 text-gray-300 duration-300 transform -translate-y-6 scale-75 top-3 origin-[0] peer-focus:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                Konfirmasi Kata Sandi
                            </label>
                            <!-- Toggle Eye Icon -->
                            <button type="button" onclick="togglePassword('confirm-password', 'eye-icon2')" class="absolute inset-y-0 right-2 flex items-center px-2 text-gray-500">
                                <i id="eye-icon2" class="fa fa-eye text-gray-500"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Register Button -->
                    <div class="flex flex-col gap-3">
                        <button type="submit" class="bg-blue-600 text-white border border-blue-600 focus:outline-none focus:ring-1 focus:ring-blue-600 font-medium rounded-lg text-sm w-full py-2 me-2 mb-2 ">
                            Daftar
                        </button>
                    </div>

                    <!-- Login Link -->
                    <div class="text-center text-gray-500 text-[14px]">
                        Sudah punya akun? <span class="text-blue-500 underline decoration-solid"><a href="{{ route('login') }}">Masuk</a></span>
                    </div>
                </form>
            </div>
        </div>
    </div>

<!-- JavaScript untuk Toggle Password -->
<script>
    function togglePassword(inputId, iconId) {
        let passwordInput = document.getElementById(inputId);
        let eyeIcon = document.getElementById(iconId);

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            eyeIcon.classList.replace("fa-eye", "fa-eye-slash");
        } else {
            passwordInput.type = "password";
            eyeIcon.classList.replace("fa-eye-slash", "fa-eye");
        }
    }
</script>
@endsection
