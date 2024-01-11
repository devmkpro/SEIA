<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="stylesheet" href="{{ asset('css/home/index.css') }}?v=1.6">
    <link rel="stylesheet" href="{{ asset('css/home/dark-theme.css') }}?v=1.2" id="dark-theme" >
    <link rel="stylesheet" href="{{ asset('css/home/light-theme.css') }}?v=1.2" id="light-theme" disabled>

    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="https://unpkg.com/phosphor-icons"></script>

    <link rel="apple-touch-icon" sizes="180x180"
        href="https://res.cloudinary.com/dnjjcvwx5/image/upload/v1675640779/logos/seia_logo_etwo84.svg">
    <link rel="icon" type="image/png" sizes="32x32"
        href="https://res.cloudinary.com/dnjjcvwx5/image/upload/v1675640779/logos/seia_logo_etwo84.svg">
    <link rel="icon" type="image/png" sizes="16x16"
        href="https://res.cloudinary.com/dnjjcvwx5/image/upload/v1675640779/logos/seia_logo_etwo84.svg">
    <link rel="manifest"
        href="https://res.cloudinary.com/dnjjcvwx5/image/upload/v1675640779/logos/seia_logo_etwo84.svg">
    <link rel="mask-icon"
        href="https://res.cloudinary.com/dnjjcvwx5/image/upload/v1675640779/logos/seia_logo_etwo84.svg" color="#5bbad5">
    <link rel="shortcut icon"
        href="https://res.cloudinary.com/dnjjcvwx5/image/upload/v1675640779/logos/seia_logo_etwo84.svg">
    <link rel="stylesheet"
        href="https://res.cloudinary.com/dnjjcvwx5/raw/upload/v1675776364/assets/seia/css/Bootstrap%205.2.x/bootstrap522.min_fag1ma.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center" style="height: 100vh">

        {{ $slot }}

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
