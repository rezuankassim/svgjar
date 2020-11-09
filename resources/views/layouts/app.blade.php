<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        @livewireStyles

        <!-- Scripts -->
        <script src="https://unpkg.com/moment" defer></script>
        <script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js" defer></script>
        <script src="https://cdn.jsdelivr.net/npm/@ryangjchandler/alpine-clipboard@0.1.x/dist/alpine-clipboard.umd.js" defer></script>
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.6.0/dist/alpine.js" defer></script>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen flex bg-gray-100">
            <!-- Sidebar -->
            <x-layouts.sidebar />

            <div class="flex-1 max-h-screen flex flex-col">
                <x-layouts.navbar />

                <!-- Page Heading -->
                {{-- <header>
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header> --}}

                <!-- Page Content -->
                <main class="flex-1 overflow-x-auto">
                    {{ $slot }}
                </main>
            </div>

            <x-notification />
        </div>

        @stack('modals')

        @livewireScripts
    </body>
</html>
