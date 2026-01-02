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
        href="https://icons.iconarchive.com/icons/iconarchive/incognito-animal-2/256/Cat-Cool-icon.png"
    >
    <title>Heyroar!! Nice to meow you</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="flex justify-center items-center min-h-screen">
    <div class="w-full max-w-sm">
        <div class="navbar">
            <div class="flex-1">
                <x-logo />
            </div>
            <div class="flex-none">
                <x-theme-controller />
            </div>
        </div>

        <div class="flex w-full flex-col">
            <div class="card text-neutral bg-neutral-content w-full shrink-0">
                <div class="card-body">
                    <livewire:auth.login-form />
                </div>
            </div>
            <div class="divider">OR</div>
            <div class="card text-neutral bg-neutral-content w-full shrink-0">
                <div class="card-body">
                    <livewire:auth.register-form />
                </div>
            </div>
        </div>

        <x-toast-alert></x-toast-alert>
    </div>



    @livewireScripts
    <script>
        window.addEventListener('redirect', () => {
            window.location.href = '/forum';
        });
    </script>
</body>

</html>
