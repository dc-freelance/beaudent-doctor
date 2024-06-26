<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Beaudent Doctor') }}</title>
    <link rel="icon" href="{{ asset('assets/application/logo mini.jpeg') }}">


    @stack('css-internal')

    <!-- Fonts -->
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-poppins text-gray-900">
    <div class="w-full">
        <div class="flex justify-center gap-5 w-full lg:p-5 p-3">
            <div class="lg:w-[30%] w-full text-center h-screen">
                {{ $slot }}
            </div>
        </div>
    </div>

    @stack('js-internal')
</body>

</html>
