<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >
    <link
        rel="icon"
        type="image/png"
        href="https://icons.iconarchive.com/icons/iconarchive/dog-breed/256/Pomeranian-Dog-icon.png"
    >
    <title>CatCanine</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="flex justify-center items-center min-h-screen">
    <div class="w-full max-w-md">
        <x-forum-navbar></x-forum-navbar>
        <livewire:forum-create-post />
        <x-forum-post-filter />
        @yield('content')
        <x-top-button />
        <x-toast-alert></x-toast-alert>
    </div>

    @livewireScripts
</body>

</html>
