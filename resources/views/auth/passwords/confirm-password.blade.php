@extends('layouts.auth')

@section('content')
    <div class="flex justify-center items-center min-h-screen bg-gradient-to-br from-blue-50 to-cyan-50 p-4 sm:p-6 md:p-8">
        <div class="card w-full max-w-md bg-white shadow-2xl rounded-3xl overflow-hidden transform transition-all duration-300 hover:scale-[1.02] hover:shadow-3xl">
            <div class="cardHead flex w-full items-center justify-between p-6">
                <a href="{{ url()->previous() }}" class="text-2xl text-gray-600 hover:text-blue-500 transition-colors">
                    <i class="fas fa-arrow-left"></i>
                </a>
            </div>
            
            <div class="card-body px-6 sm:px-8 md:px-10 pb-8">
                <h2 class="text-3xl font-extrabold mb-6 text-center text-gray-800 tracking-tight">Konfirmasi Kata Sandi</h2>

                @if (session('status'))
                    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 text-center">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg mb-6">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
                    @csrf
                    
                    <!-- Input Password -->
                    <div class="relative group">
                        <input type="password" id="password" name="password" required placeholder=" "
                            autocomplete="current-password"
                            class="w-full px-3 py-3 border-b-2 border-blue-400 bg-transparent 
                            focus:border-blue-500 focus:outline-none transition-colors duration-300 
                            peer text-gray-700 text-base pr-10" />
                        <label for="password" 
                            class="absolute left-0 -top-3.5 text-sm text-gray-500 transition-all duration-300 
                            peer-placeholder-shown:text-base peer-placeholder-shown:top-3 
                            peer-focus:-top-3.5 peer-focus:text-sm peer-focus:text-blue-500">
                            Masukkan Kata Sandi Anda
                        </label>
                        <!-- Toggle Eye Icon -->
                        <button type="button" onclick="togglePassword('password', 'eye-icon')" 
                            class="absolute right-0 top-3 text-gray-500 hover:text-blue-500 transition-colors focus:outline-none">
                            <i id="eye-icon" class="fas fa-eye"></i>
                        </button>
                    </div>

                    <!-- Confirm Button -->
                    <div class="pt-4">
                        <button type="submit" 
                            class="w-full py-3 bg-gradient-to-r from-blue-400 to-cyan-400 text-white rounded-lg 
                            hover:from-blue-500 hover:to-cyan-500 transition-all duration-300 transform 
                            hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50 
                            active:scale-[0.98] font-semibold tracking-wider">
                            Konfirmasi
                        </button>
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