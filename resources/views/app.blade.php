<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <!-- Scripts -->
    @routes
    {{-- @vite('resources/js/app.js') --}}
    @inertiaHead
</head>

<body class="font-sans antialiased">


    @inertia
    <script src="{{ mix('js/app.js') }}"></script>
</body>

</html>