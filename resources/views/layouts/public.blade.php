<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data x-init="const stored = localStorage.getItem('theme');
const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
if (stored === 'dark' || (!stored && prefersDark)) {
    document.documentElement.classList.add('dark');
}" class="scroll-smooth">

<head>
    {{-- Prevent FOT --}}
    <script>
        (function() {
            const theme = localStorage.getItem('theme') ??
                (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');

            document.documentElement.classList.toggle('dark', theme === 'dark');
        })();
    </script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', __('NidoReal — Tu plataforma inmobiliaria'))</title>

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="/favicon.svg" />
    <link rel="shortcut icon" href="/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png" />
    <meta name="apple-mobile-web-app-title" content="NidoReal" />
    <link rel="manifest" href="/site.webmanifest" />

    <meta name="description" content="@yield('description', __('Encuentra tu propiedad ideal en España. Miles de pisos, casas y villas con las mejores agencias.'))">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <meta name="mapbox-token" content="{{ config('services.mapbox.token') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>

<body class="bg-page text-body font-sans antialiased" x-bind:class="{ 'dark': $store.theme.isDark }">

    {{-- SWUP Persistent Header Container --}}
    <div id="swup-header">
        @hasSection('navbar')
            @yield('navbar')
        @else
            <x-public.navbar :floating="true" />
        @endif
    </div>

    {{-- SWUP Main Content Container --}}
    <main id="swup" class="transition-fade">
        @yield('content')
    </main>

    {{-- SWUP Persistent Footer Container --}}
    <div id="swup-footer">
        @hasSection('footer')
            @yield('footer')
        @else
            <x-public.footer />
        @endif
    </div>

    {{-- Back to Top --}}
    <button id="back-to-top" x-data="{ show: false }" x-init="window.addEventListener('scroll', () => show = window.scrollY > 400)" x-show="show"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0" @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
        class="fixed bottom-8 right-8 z-50 w-12 h-12 bg-primary rounded-full flex items-center justify-center shadow-lg hover:bg-primary-hover transition-colors"
        aria-label="Volver arriba">
        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
        </svg>
    </button>

    {{-- Global Toast Notification --}}
    <div x-data x-show="$store.toast.visible" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-4" @click="$store.toast.hide()"
        :class="{
            'bg-neutral-900 dark:bg-white text-white dark:text-neutral-900': $store.toast.type === 'info',
            'bg-green-600 text-white': $store.toast.type === 'success',
            'bg-red-600 text-white': $store.toast.type === 'error',
        }"
        class="fixed bottom-24 left-1/2 -translate-x-1/2 z-9999 flex items-center gap-3 px-5 py-3.5 rounded-2xl shadow-xl cursor-pointer max-w-sm w-full sm:w-auto text-sm font-semibold"
        style="display: none;">

        {{-- Icon --}}
        <svg x-show="$store.toast.type === 'info'" class="w-5 h-5 shrink-0" xmlns="http://www.w3.org/2000/svg"
            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="10" />
            <path d="M12 16v-4" />
            <path d="M12 8h.01" />
        </svg>
        <svg x-show="$store.toast.type === 'success'" style="display:none" class="w-5 h-5 shrink-0"
            xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2"
            stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
            <path d="m9 11 3 3L22 4" />
        </svg>
        <svg x-show="$store.toast.type === 'error'" style="display:none" class="w-5 h-5 shrink-0"
            xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2"
            stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="10" />
            <line x1="12" x2="12" y1="8" y2="12" />
            <line x1="12" x2="12.01" y1="16" y2="16" />
        </svg>

        <span x-text="$store.toast.message"></span>
    </div>

    @stack('scripts')
</body>

</html>
