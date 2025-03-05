@extends('layouts.auth')

@section('content')
    <div class="flex justify-center items-center min-h-screen p-4 sm:p-6 md:p-8">
        <div class="card w-full max-w-md bg-white shadow-2xl rounded-3xl overflow-hidden">
            <div class="cardHead flex w-full items-center justify-between p-6">
                <a href="/login" class="text-2xl text-gray-600 hover:text-blue-500 transition-colors">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <img src="{{ asset('storage/images/logo.png') }}" alt="Logo" class="w-16 h-16 object-contain">
            </div>
            
            <div class="card-body px-6 sm:px-8 md:px-10 pb-8">
                <h2 class="text-3xl font-extrabold mb-6 text-center text-gray-800 tracking-tight">Sign Up</h2>
                
                <form method="POST" action="{{ route('register') }}" class="space-y-5" autocomplete="on">
                    @csrf

                    <!-- Input Name -->
                    <div class="relative group">
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus placeholder=" "
                            class="w-full px-3 py-3 border-b-2 border-blue-400 bg-transparent 
                            focus:border-blue-500 focus:outline-none transition-colors duration-300 
                            peer text-gray-700 text-base" />
                        <label for="name" 
                            class="absolute left-2 -top-3.5 text-sm text-gray-500 transition-all duration-300 
                            peer-placeholder-shown:text-base peer-placeholder-shown:top-3 
                            peer-focus:-top-3.5 peer-focus:text-sm peer-focus:text-blue-500">
                            Name
                        </label>
                        @error('name')
                            <div class="text-red-500 text-sm mt-1 pl-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Input Email -->
                    <div class="relative group">
                        <input type="text" id="email" name="email" value="{{ old('email') }}" required placeholder=" "
                            class="w-full px-3 py-3 border-b-2 border-blue-400 bg-transparent 
                            focus:border-blue-500 focus:outline-none transition-colors duration-300 
                            peer text-gray-700 text-base" />
                        <label for="email" 
                            class="absolute left-2 -top-3.5 text-sm text-gray-500 transition-all duration-300 
                            peer-placeholder-shown:text-base peer-placeholder-shown:top-3 
                            peer-focus:-top-3.5 peer-focus:text-sm peer-focus:text-blue-500">
                            Email
                        </label>
                        @error('email')
                            <div class="text-red-500 text-sm mt-1 pl-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Input Phone Number -->
                    <div class="relative group">
                        <input type="text" id="phone" name="phone" value="{{ old('phone') }}" required placeholder=" "
                            class="w-full px-3 py-3 border-b-2 border-blue-400 bg-transparent 
                            focus:border-blue-500 focus:outline-none transition-colors duration-300 
                            peer text-gray-700 text-base" />
                        <label for="phone" 
                            class="absolute left-2 -top-3.5 text-sm text-gray-500 transition-all duration-300 
                            peer-placeholder-shown:text-base peer-placeholder-shown:top-3 
                            peer-focus:-top-3.5 peer-focus:text-sm peer-focus:text-blue-500">
                            Phone Number
                        </label>
                        @error('phone')
                            <div class="text-red-500 text-sm mt-1 pl-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="flex space-x-4">
                        <!-- Input Password -->
                        <div class="relative group w-1/2">
                            <input type="password" id="password" name="password" required placeholder=" "
                                class="w-full px-3 py-3 border-b-2 border-blue-400 bg-transparent 
                                focus:border-blue-500 focus:outline-none transition-colors duration-300 
                                peer text-gray-700 text-base pr-10" />
                            <label for="password" 
                                class="absolute left-2 -top-3.5 text-sm text-gray-500 transition-all duration-300 
                                peer-placeholder-shown:text-base peer-placeholder-shown:top-3 
                                peer-focus:-top-3.5 peer-focus:text-sm peer-focus:text-blue-500">
                                Password
                            </label>
                            <!-- Toggle Eye Icon -->
                            <button type="button" onclick="togglePassword('password', 'eye-icon1')" 
                                class="absolute right-3 top-3 text-gray-500 hover:text-blue-500 transition-colors focus:outline-none">
                                <i id="eye-icon1" class="fas fa-eye"></i>
                            </button>
                        </div>
    
                        <!-- Input Confirm Password -->
                        <div class="relative group w-1/2">
                            <input type="password" id="confirm-password" name="password_confirmation" required placeholder=" "
                                class="w-full px-3 py-3 border-b-2 border-blue-400 bg-transparent 
                                focus:border-blue-500 focus:outline-none transition-colors duration-300 
                                peer text-gray-700 text-base pr-10" />
                            <label for="confirm-password" 
                                class="absolute left-2 -top-3.5 overflow-hidden text-sm text-gray-500 transition-all duration-300 
                                peer-placeholder-shown:text-base peer-placeholder-shown:top-3 
                                peer-focus:-top-3.5 peer-focus:text-sm peer-focus:text-blue-500">
                                Confirm Password
                            </label>
                            <!-- Toggle Eye Icon -->
                            <button type="button" onclick="togglePassword('confirm-password', 'eye-icon2')" 
                                class="absolute right-3 top-3 text-gray-500 hover:text-blue-500 transition-colors focus:outline-none">
                                <i id="eye-icon2" class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Register Button -->
                    <div class="pt-4">
                        <button type="submit" 
                            class="w-full py-3 bg-gradient-to-r from-blue-400 to-cyan-400 text-white rounded-lg 
                            hover:from-blue-500 hover:to-cyan-500 transition-all duration-300 transform 
                            hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50 
                            active:scale-[0.98] font-semibold tracking-wider">
                            Sign Up
                        </button>
                    </div>

                    <!-- Login Link -->
                    <div class="text-center text-gray-500 text-sm pt-2">
                        Already have an account? 
                        <a href="{{ route('login') }}" class="text-sm text-lime-500 hover:text-cyan-500 hover:underline transition-colors">
                            Login
                        </a>
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