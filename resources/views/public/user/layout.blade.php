@extends('layouts.public')
@push('head')
    <style>
        @media (max-width: 1023px) {
            #back-to-top {
                display: none !important;
            }
        }
    </style>
@endpush

@section('title', $pageTitle ?? __('Mi Cuenta') . ' — NidoReal')

@section('content')

@section('navbar')
    <x-public.navbar :floating="false" />
@endsection

    <div class="min-h-screen bg-neutral-50 dark:bg-neutral-950">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">

            {{-- Flash Messages --}}
            @if (session('success'))
                <div
                    class="mb-6 flex items-start gap-3 p-4 rounded-xl bg-green-50 dark:bg-green-500/10 border border-green-200 dark:border-green-500/20 text-green-700 dark:text-green-400 text-sm">
                    <svg class="w-5 h-5 shrink-0 mt-0.5" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                        <path d="m9 11 3 3L22 4" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div
                    class="mb-6 flex items-start gap-3 p-4 rounded-xl bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 text-red-700 dark:text-red-400 text-sm">
                    <svg class="w-5 h-5 shrink-0 mt-0.5" xmlns="http://www.w3.org/2000/svg" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10" />
                        <line x1="12" x2="12" y1="8" y2="12" />
                        <line x1="12" x2="12.01" y1="16" y2="16" />
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            {{-- User Header --}}
            <div class="flex items-center gap-4 mb-8">
                <div class="w-14 h-14 rounded-full bg-primary/10 flex items-center justify-center shrink-0">
                    @if (auth()->user()->avatar_path)
                        <img src="{{ Storage::url(auth()->user()->avatar_path) }}" alt="{{ auth()->user()->name }}"
                            class="w-full h-full object-cover rounded-full">
                    @else
                        <svg class="w-7 h-7 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            viewBox="0 0 24 24">
                            <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                            <circle cx="12" cy="7" r="4" />
                        </svg>
                    @endif
                </div>
                <div>
                    <h1 class="text-2xl font-extrabold text-neutral-900 dark:text-white">{{ __('Hola,') }}
                        {{ auth()->user()->name }}</h1>
                    <p class="text-sm text-neutral-500 dark:text-neutral-400">{{ auth()->user()->email }}</p>
                </div>
            </div>

            @php
                $navItems = [
                    [
                        'route' => 'user.profile',
                        'label' => __('Mi Perfil'),
                        'mobileLabel' => __('Perfil'),
                        'icon' => '<path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>',
                    ],
                    [
                        'route' => 'user.favorites',
                        'label' => __('Favoritos'),
                        'mobileLabel' => __('Favoritos'),
                        'icon' =>
                            '<path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/>',
                    ],
                    [
                        'route' => 'user.properties.index',
                        'label' => __('Mis Propiedades'),
                        'mobileLabel' => __('Inmuebles'),
                        'icon' =>
                            '<path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>',
                    ],
                    [
                        'route' => 'user.settings',
                        'label' => __('Ajustes'),
                        'mobileLabel' => __('Ajustes'),
                        'icon' =>
                            '<path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/><circle cx="12" cy="12" r="3"/>',
                    ],
                ];
            @endphp

            {{-- Desktop Navigation --}}
            <div class="mb-8">
                <nav
                    class="hidden lg:flex items-center gap-2 bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 p-2 rounded-2xl shadow-sm">
                    @foreach ($navItems as $item)
                        @php $isActive = request()->routeIs($item['route']); @endphp
                        <a href="{{ route($item['route']) }}"
                            class="flex items-center gap-2.5 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all
                                {{ $isActive ? 'bg-primary text-white shadow-md' : 'text-neutral-600 dark:text-neutral-400 hover:bg-neutral-50 dark:hover:bg-neutral-800 hover:text-neutral-900 dark:hover:text-white' }}">
                            <svg class="w-4.5 h-4.5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                viewBox="0 0 24 24">
                                {!! $item['icon'] !!}
                            </svg>
                            {{ $item['label'] }}
                        </a>
                    @endforeach

                    <div class="ml-auto pl-2 border-l border-neutral-100 dark:border-neutral-800">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="flex items-center gap-2.5 px-4 py-2.5 rounded-xl text-sm font-semibold text-red-500 hover:bg-red-50 dark:hover:bg-red-500/10 transition-all">
                                <svg class="w-4.5 h-4.5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    viewBox="0 0 24 24">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                    <polyline points="16 17 21 12 16 7" />
                                    <line x1="21" x2="9" y1="12" y2="12" />
                                </svg>
                                {{ __('Salir') }}
                            </button>
                        </form>
                    </div>
                </nav>
            </div>

            {{-- Page Content (rendered once) --}}
            <main class="w-full max-w-none pb-24 lg:pb-0">
                @yield('user-content')
            </main>

        </div>
    </div>

    {{-- Mobile Bottom Navigation (outside container, fixed) --}}
    <nav class="lg:hidden fixed bottom-0 left-0 right-0 z-50 bg-white/80 dark:bg-neutral-900/80 backdrop-blur-md border-t border-neutral-200 dark:border-neutral-800"
        style="padding-bottom: env(safe-area-inset-bottom)">

        <div class="grid gap-0" style="grid-template-columns: repeat({{ count($navItems) + 1 }}, 1fr)">

            @foreach ($navItems as $item)
                @php $isActive = request()->routeIs($item['route']); @endphp
                <a href="{{ route($item['route']) }}"
                    class="flex flex-col items-center justify-center gap-1 py-3 transition-all active:scale-95
                        {{ $isActive ? 'text-primary' : 'text-neutral-400 dark:text-neutral-500' }}">
                    <span class="relative flex items-center justify-center">
                        @if ($isActive)
                            <span
                                class="absolute -top-1.5 left-1/2 -translate-x-1/2 w-1 h-1 rounded-full bg-primary"></span>
                        @endif
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            {!! $item['icon'] !!}
                        </svg>
                    </span>
                    <span class="text-[10px] font-medium leading-none truncate w-full text-center px-1">
                        {{ $item['mobileLabel'] }}
                    </span>
                </a>
            @endforeach

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full h-full flex flex-col items-center justify-center gap-1 py-3 text-red-400 transition-all active:scale-95">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                        <polyline points="16 17 21 12 16 7" />
                        <line x1="21" x2="9" y1="12" y2="12" />
                    </svg>
                    <span class="text-[10px] font-medium leading-none">{{ __('Salir') }}</span>
                </button>
            </form>

        </div>
    </nav>


@endsection
