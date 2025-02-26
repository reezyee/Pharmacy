<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <<meta name="csrf-token" content="{{ csrf_token() }}">
        @vite('resources/css/app.css')
        <script src="{{ mix('js/app.js') }}"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
        <title>{{ $title }}</title>
</head>

<body class="h-full">
    @include('components.navbar-dash')
    {{-- @include('components.sidebar') --}}
    <div class="w-[80%] float-end">
        <main>
            <div class="paddingXD">
                @yield('content')
            </div>
        </main>
    </div>
    @stack('scripts')

</body>

</html>
