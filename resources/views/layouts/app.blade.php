<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" x-init="darkMode ? document.documentElement.classList.add('dark') : document.documentElement.classList.remove('dark')" class="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>MW | @yield('title')</title>
    <link rel="icon"
        href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='currentColor' viewBox='0 0 440 376'%3E%3Cpath d='M 56.53 6.41 h 152.93 v 366.88 L 70.37 178.11 h 62.28 l 33.07 45.89 V 69.06 H 74.71 l -9.85 13.81 L 87.53 115.2 l -62.43 0.5 L 2 84 z' style='fill:%2399f'/%3E%3Cpath d='M229.93 6.29h152.83l54.2 76.26-72.48 101.38-0.18-87.61 9.85-13.31-9.67-13.81-23.22-0.25-0.35 148.54-43.63 61.17-1.76-206.77H271.3l1.05 239.85-45.03 61.17z' style='fill:%2399f;fill-opacity:.811765'/%3E%3C/svg%3E"
        sizes="any" type="image/svg+xml">
    <meta name="description"
        content="Aplicação web desenvolvida por J.M.Moraes, utilizando Laravel, Livewire e Tailwind CSS. Solução eficiente para gestão.">
    <meta name="keywords" content="moraw, laravel, livewire, tailwind, aplicação web, desenvolvimento web, Moraes">
    <meta name="author" content="J.M.Moraes">

    <meta property="og:title" content="Moraw | Aplicação Web Moderna">
    <meta property="og:description" content="Desenvolvida com Laravel e Livewire para gestão privada.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://domo.ct.ws">
    <meta property="og:image" content="https://moraw.ct.ws/uploads/moraw-1600x630-thumbnail.jpg">
    <meta property="og:site_name" content="Moraw">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @stack('styles')
    <script>
    (function () {
        const hour = new Date().getHours();
        const userPref = localStorage.getItem('theme');

        if (userPref === 'dark') {
            document.documentElement.classList.add('dark');
        } else if (userPref === 'light') {
            document.documentElement.classList.remove('dark');
        } else if (hour >= 18 || hour < 6) {
            // Entre 18h e 6h: ativa dark mode automaticamente
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    })();
</script>

</head>

<body
    class="min-h-screen bg-light-bg text-light-text dark:bg-dark-bg dark:text-dark-text bg-stars-dark bg-[length:1000px_1000px] bg-no-repeat bg-fixed font-sans">


    @if (session()->has('unauthorized_access'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show"
            x-transition:enter="transform ease-out duration-300 transition"
            x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
            x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed top-20 right-5 z-[60] max-w-sm w-full bg-white dark:bg-gray-800 shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5"
            role="alert">
            <div class="p-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-red-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                        </svg>
                    </div>
                    <div class="ml-3 w-0 flex-1 pt-0.5">
                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Acesso Negado</p>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ session('unauthorized_access') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <x-banner />

    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        @livewire('navigation-menu')

        @if (isset($header))
            <header class="bg-white dark:bg-gray-800 shadow pt-16">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <main>
            {{ $slot }}
        </main>
    </div>

    @stack('modals')
    @livewireScripts
    @stack('scripts')
</body>

</html>
