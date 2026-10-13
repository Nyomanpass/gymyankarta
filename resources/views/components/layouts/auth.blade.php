<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GYMYANKARTA</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta name="app-release" content="{{ app(\App\Services\ApplicationRelease::class)->version() }}">
    <meta name="app-release-url" content="{{ route('app.release') }}">
    @livewireStyles

</head>
<body class="font-poppins text-warna-300 h-[100dvh] lg:min-h-screen flex items-center justify-center">
    {{ $slot }}
    @livewireScripts
</body>
</html>