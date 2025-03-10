<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/css/app.css')
    <link rel="icon" type="image/png" href="{{ asset('storage/images/logo.ico') }}">
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    <title>{{ $title }}</title>
</head>

<body class="">
    <div class="">
        @include('components.navbar')
        <main>
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                @yield('content')
            </div>
        </main>
        @include('components.footer')
    </div>
    @stack('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            if (typeof window.Echo !== 'undefined') {
                window.Echo.private('App.Models.User.' + @json(auth()->id()))
                    .notification((notification) => {
                        alert(notification.message);
                    });
            } else {
                console.error("Laravel Echo tidak terdeteksi. Pastikan sudah dikonfigurasi dengan benar.");
            }
        });
    </script>          
</body>
</html>
