@extends('layouts.auth')

@section('content')
    <div class="flex justify-center items-center min-h-screen p-4 sm:p-6 md:p-8">
        <div class="card w-full max-w-md bg-white shadow-2xl rounded-3xl overflow-hidden">
            <div class="cardHead flex justify-between items-center p-6">
                <a href="/login" class="text-2xl text-gray-600 hover:text-blue-500 transition-colors">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <img src="{{ asset('storage/images/logo.png') }}" alt="Logo" class="w-16 h-16 object-contain">
            </div>
            
            <div class="cardBody p-6 sm:p-8 md:p-10">
                <h2 class="text-3xl font-extrabold mb-6 text-center text-gray-800 tracking-tight">Login</h2>
                
                <form method="POST" action="{{ route('login') }}" class="space-y-6" autocomplete="on">
                    @csrf
                    <div class="space-y-5">
                        <!-- Input Email atau Phone -->
                        <div class="relative group">
                            <input type="text" id="email_or_phone"
                                class="w-full px-3 py-3 border-b-2 border-blue-400 bg-transparent 
                                focus:border-blue-500 focus:outline-none transition-colors duration-300 
                                peer text-gray-700 text-base pr-10"
                                name="email_or_phone" required autofocus value="{{ old('email_or_phone') }}" placeholder=" " />
                            <label for="email_or_phone"
                                class="absolute left-2 -top-3.5 overflow-hidden text-sm text-gray-500 transition-all duration-300 
                                peer-placeholder-shown:text-base peer-placeholder-shown:top-3 
                                peer-focus:-top-3.5 peer-focus:text-sm peer-focus:text-blue-500">
                                Phone or Email
                            </label>
                            @error('email_or_phone')
                                <div class="text-red-500 text-sm mt-1 pl-1">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Input Password -->
                        <div class="relative group">
                            <input type="password" id="password"
                                class="w-full px-3 py-3 border-b-2 border-blue-400 bg-transparent 
                                focus:border-blue-500 focus:outline-none transition-colors duration-300 
                                peer text-gray-700 text-base pr-10"
                                name="password" required placeholder=" " />
                            <label for="password"
                                class="absolute left-2 -top-3.5 overflow-hidden text-sm text-gray-500 transition-all duration-300 
                                peer-placeholder-shown:text-base peer-placeholder-shown:top-3 
                                peer-focus:-top-3.5 peer-focus:text-sm peer-focus:text-blue-500">
                                Password
                            </label>
                            @error('password')
                                <div class="text-red-500 text-sm mt-1 pl-1">
                                    {{ $message }}
                                </div>
                            @enderror
                            
                            <!-- Tombol Toggle Password -->
                            <button type="button" onclick="togglePassword()"
                                class="absolute right-3 top-3 text-gray-500 hover:text-cyan-500 transition-colors focus:outline-none">
                                <i id="eye-icon" class="fas fa-eye"></i>
                            </button>
                            
                            <a href="{{ url('/forgot-password') }}" class="text-sm text-lime-500 hover:text-cyan-500 float-right mt-2">
                                Forgot Password?
                            </a>
                        </div>
                    </div>

                    <!-- Login Button -->
                    <div class="space-y-4 pt-2">
                        <button type="submit"
                            class="w-full py-3 bg-gradient-to-r from-blue-400 to-cyan-400 text-white rounded-lg 
                            hover:from-blue-500 hover:to-cyan-500 transition-all duration-300 transform 
                            hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50 
                            active:scale-[0.98] font-semibold tracking-wider">
                            Login
                        </button>
                        <div class="text-center mt-3">
                            <p>Don't have an account?</p>
                            <a href="{{ route('register') }}" class="text-sm text-lime-500 hover:text-cyan-500 hover:underline">
                                Create account
                            </a>
                        </div>
                    </div>

                    <!-- Divider -->
                    <div class="flex items-center justify-center my-4">
                        <div class="border-b border-gray-300 w-1/4 mr-2"></div>
                        <p class="text-gray-500 text-sm">Or with</p>
                        <div class="border-b border-gray-300 w-1/4 ml-2"></div>
                    </div>

                    <!-- Google Login -->
                    <div class="flex justify-center">
                        <a href="{{ url('login/google') }}" 
                           class="p-3 bg-white border border-gray-200 rounded-full shadow-md 
                           hover:shadow-lg transition-all duration-300 transform hover:scale-110 
                           focus:outline-none focus:ring-2 focus:ring-lime-300">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 128 128">
                                <path fill="#fff" d="M44.59 4.21a63.28 63.28 0 0 0 4.33 120.9a67.6 67.6 0 0 0 32.36.35a57.13 57.13 0 0 0 25.9-13.46a57.44 57.44 0 0 0 16-26.26a74.3 74.3 0 0 0 1.61-33.58H65.27v24.69h34.47a29.72 29.72 0 0 1-12.66 19.52a36.2 36.2 0 0 1-13.93 5.5a41.3 41.3 0 0 1-15.1 0A37.2 37.2 0 0 1 44 95.74a39.3 39.3 0 0 1-14.5-19.42a38.3 38.3 0 0 1 0-24.63a39.25 39.25 0 0 1 9.18-14.91A37.17 37.17 0 0 1 76.13 27a34.3 34.3 0 0 1 13.64 8q5.83-5.8 11.64-11.63c2-2.09 4.18-4.08 6.15-6.22A61.2 61.2 0 0 0 87.2 4.59a64 64 0 0 0-42.61-.38" />
                                <path fill="#e33629" d="M44.59 4.21a64 64 0 0 1 42.61.37a61.2 61.2 0 0 1 20.35 12.62c-2 2.14-4.11 4.14-6.15 6.22Q95.58 29.23 89.77 35a34.3 34.3 0 0 0-13.64-8A37.17 37.17 0 0 0 37.67 36.74a39.25 39.25 0 0 0-9.18 14.91L8.76 35.6A63.53 63.53 0 0 1 44.59 4.21" />
                                <path fill="#f8bd00" d="M3.26 51.5a63 63 0 0 1 5.5-15.9l20.73 16.09a38.3 38.3 0 0 0 0 24.63q-10.36 8-20.73 16.08a63.33 63.33 0 0 1-5.5-40.9" />
                                <path fill="#587dbd" d="M65.27 52.15h59.52a74.3 74.3 0 0 1-1.61 33.58a57.44 57.44 0 0 1-16 26.26c-6.69-5.22-13.41-10.4-20.1-15.62a29.72 29.72 0 0 0 12.66-19.54H65.27c-.01-8.22 0-16.45 0-24.68" />
                                <path fill="#319f43" d="M8.75 92.4q10.37-8 20.73-16.08A39.3 39.3 0 0 0 44 95.74a37.2 37.2 0 0 0 14.08 6.08a41.3 41.3 0 0 0 15.1 0a36.2 36.2 0 0 0 13.93-5.5c6.69 5.22 13.41 10.4 20.1 15.62a57.13 57.13 0 0 1-25.9 13.47a67.6 67.6 0 0 1-32.36-.35a63 63 0 0 1-23-11.59A63.7 63.7 0 0 1 8.75 92.4" />
                            </svg>
                        </a>
                    </div>
                </form>
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