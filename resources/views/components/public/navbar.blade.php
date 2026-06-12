{{-- resources/views/components/public/navbar.blade.php --}}
{{-- $floating: true (default) = absolute/hero style, false = always static/scrolled --}}
@props(['floating' => true])

@php $isFloating = (bool) $floating; @endphp

<nav x-data="{ isScrolled: {{ $isFloating ? 'false' : 'true' }} }" @if ($isFloating) @scroll.window="isScrolled = window.scrollY > 20" @endif
    :class="isScrolled
        ?
        'bg-white/95 dark:bg-neutral-900/95 backdrop-blur-md border-b border-neutral-200 dark:border-neutral-800 shadow-sm' :
        ''"
    class="{{ $isFloating ? 'fixed! top-0' : 'sticky top-0 bg-white/95 dark:bg-neutral-900/95 backdrop-blur-md border-b border-neutral-200 dark:border-neutral-800 shadow-sm' }} left-0 right-0 w-full z-50 transition-all duration-300">
    <div class="mx-auto max-w-[1840px] px-6 lg:px-10 transition-all duration-300"
        x-effect="document.body.style.overflow = $store.mobileMenu.open ? 'hidden' : ''">
        <div :class="isScrolled ? 'mt-0! rounded-none! px-0! shadow-none! py-3 lg:py-4' : ''"
            class="{{ $isFloating ? 'rounded-xl mt-6 px-6 shadow-lg bg-white/95 dark:bg-neutral-900/95 backdrop-blur-md' : 'px-0' }} py-3 flex items-center justify-between transition-all duration-300">

            {{-- Logo --}}
            <a href="{{ route('home') }}">
                <x-public.logo class="h-[42px] w-auto" />
            </a>

            {{-- Menu Desktop --}}
            @php
                $navLinks = [
                    ['route' => 'home',           'label' => __('Inicio'),    'match' => 'home',          'desktop' => false],
                    ['route' => 'properties.index','label' => __('Inmuebles'), 'match' => 'properties.*'],
                    ['route' => 'agencies.index',  'label' => __('Agencias'),  'match' => 'agencies.*'],
                    ['route' => 'pages.tarifas',   'label' => __('Tarifas'),   'match' => 'pages.tarifas'],
                    ['route' => 'pages.nosotros',  'label' => __('Nosotros'),  'match' => 'pages.nosotros'],
                    ['route' => 'pages.faq',       'label' => __('FAQ'),       'match' => 'pages.faq',     'desktop' => false],
                    ['route' => 'pages.contacto',  'label' => __('Contacto'),  'match' => 'pages.contacto'],
                ];
            @endphp
            <ul class="hidden lg:flex items-center gap-8">
                @foreach ($navLinks as $link)
                    @if (($link['desktop'] ?? true) === false) @continue @endif
                    @php $isActive = request()->routeIs($link['match']); @endphp
                    <li>
                        <a href="{{ route($link['route']) }}" @class([
                            'text-md font-bold transition-colors pb-0.5',
                            'text-primary border-b-2 border-primary' => $isActive,
                            'text-neutral-900 dark:text-neutral-100 hover:text-primary border-b-2 border-transparent' => !$isActive,
                        ])>
                            {{ $link['label'] }}
                        </a>
                    </li>
                @endforeach
            </ul>

            {{-- Actions --}}
            <div class="hidden lg:flex items-center gap-4">

                {{-- Dark & Light Mode Toggle --}}
                <button @click="$store.theme.toggle()"
                    class="w-10 h-10 flex items-center justify-center rounded-lg hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-colors cursor-pointer text-neutral-600 dark:text-neutral-300"
                    :aria-label="$store.theme.isDark ? '{{ __('Cambiar a modo claro') }}' : '{{ __('Cambiar a modo oscuro') }}'">

                    {{-- Sun: Dark Mode --}}
                    <svg class="w-5 h-5 hidden dark:block" xmlns="http://www.w3.org/2000/svg" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="4" />
                        <path d="M12 2v2" />
                        <path d="M12 20v2" />
                        <path d="m4.93 4.93 1.41 1.41" />
                        <path d="m17.66 17.66 1.41 1.41" />
                        <path d="M2 12h2" />
                        <path d="M20 12h2" />
                        <path d="m6.34 17.66-1.41 1.41" />
                        <path d="m19.07 4.93-1.41 1.41" />
                    </svg>

                    {{-- Moon: Light Theme --}}
                    <svg class="w-5 h-5 block dark:hidden" xmlns="http://www.w3.org/2000/svg" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        viewBox="0 0 24 24">
                        <path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z" />
                    </svg>

                </button>

                {{-- Language Switcher (Desktop) --}}
                <x-public.lang-switcher />

                @auth
                    <a href="{{ auth()->user()->dashboard_url }}"
                        class="flex items-center gap-2 px-2.5 py-1.5 rounded-xl hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-colors group">
                        <div class="w-7 h-7 rounded-full bg-primary/10 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                viewBox="0 0 24 24">
                                <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                                <circle cx="12" cy="7" r="4" />
                            </svg>
                        </div>
                        <span
                            class="text-sm font-bold text-neutral-900 dark:text-neutral-100 group-hover:text-primary transition-colors max-w-[96px] truncate">
                            {{ auth()->user()->name }}
                        </span>
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="text-neutral-900 dark:text-neutral-200 hover:text-primary dark:hover:text-primary transition-colors flex items-center justify-center gap-1.5 p-2 rounded-xl hover:bg-neutral-100 dark:hover:bg-neutral-800">
                        <svg class="w-5 h-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            viewBox="0 0 24 24">
                            <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                            <circle cx="12" cy="7" r="4" />
                        </svg>
                        <span class="text-sm font-bold whitespace-nowrap">{{ __('Entrar') }}</span>
                    </a>
                @endauth
                <a href="{{ route('properties.index') }}"
                    class="btn-primary text-base font-semibold px-7 py-3 whitespace-nowrap">
                    {{ __('Añadir propiedad') }}
                </a>
            </div>

            {{-- Mobile: theme toggle + lang switcher + burger --}}
            <div class="lg:hidden flex items-center gap-1">
                <button @click="$store.theme.toggle()"
                    class="w-10 h-10 flex items-center justify-center rounded-lg hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-colors text-neutral-600 dark:text-neutral-300"
                    :aria-label="$store.theme.isDark ? '{{ __('Cambiar a modo claro') }}' : '{{ __('Cambiar a modo oscuro') }}'">
                    <svg x-show="$store.theme.isDark" style="display: none;" class="w-5 h-5"
                        xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="4" />
                        <path d="M12 2v2" />
                        <path d="M12 20v2" />
                        <path d="m4.93 4.93 1.41 1.41" />
                        <path d="m17.66 17.66 1.41 1.41" />
                        <path d="M2 12h2" />
                        <path d="M20 12h2" />
                        <path d="m6.34 17.66-1.41 1.41" />
                        <path d="m19.07 4.93-1.41 1.41" />
                    </svg>
                    <svg x-show="!$store.theme.isDark" class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        viewBox="0 0 24 24">
                        <path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z" />
                    </svg>
                </button>

                {{-- Language Switcher (Mobile navbar bar) --}}
                <x-public.lang-switcher />

                <button @click="$store.mobileMenu.toggle()"
                    class="p-2 rounded-lg hover:bg-neutral-100 dark:hover:bg-neutral-800 text-neutral-800 dark:text-neutral-100">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path x-show="!$store.mobileMenu.open" d="M4 12h16M4 6h16M4 18h16" />
                        <path x-show="$store.mobileMenu.open" style="display: none;" d="M18 6 6 18M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</nav>

{{-- FULLSCREEN MOBILE MENU
     TOP panel: slides DOWN (60dvh)
     BOTTOM panel: slides UP (40dvh)
 --}}
<div class="lg:hidden">

    {{-- TOP PANEL: nav links, enters from top --}}
    <div x-show="$store.mobileMenu.open" x-transition:enter="transition ease-out duration-400"
        x-transition:enter-start="-translate-y-full" x-transition:enter-end="translate-y-0"
        x-transition:leave="transition ease-in duration-300" x-transition:leave-start="translate-y-0"
        x-transition:leave-end="-translate-y-full"
        class="fixed top-0 left-0 right-0 z-200
               bg-white dark:bg-neutral-900
               flex flex-col justify-end
               px-6 pb-8"
        style="height:60dvh; padding-top: max(env(safe-area-inset-top,16px),16px); display:none;">

        {{-- Header row inside panel: logo + close --}}
        <div class="absolute top-0 left-0 right-0 flex items-center justify-between px-6"
            style="padding-top: max(env(safe-area-inset-top,16px),16px); padding-bottom: 8px;">
            <a href="{{ route('home') }}" @click="$store.mobileMenu.close()">
                <x-public.logo class="h-[34px] w-auto" />
            </a>
            <button @click="$store.mobileMenu.close()"
                class="w-10 h-10 flex items-center justify-center rounded-full bg-neutral-100 dark:bg-neutral-800 text-neutral-600 dark:text-neutral-300 hover:bg-neutral-200 dark:hover:bg-neutral-700 transition-colors">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor"
                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <path d="M18 6 6 18M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Nav links --}}
        <nav class="space-y-0">
            @foreach ($navLinks as $index => $link)
                @php $isActive = request()->routeIs($link['match']); @endphp
                <a href="{{ route($link['route']) }}" @class([
                    'flex items-center gap-4 px-3 py-2.5 rounded-xl text-xl font-extrabold transition-colors group',
                    'text-primary bg-primary/5' => $isActive,
                    'text-neutral-900 dark:text-white hover:text-primary hover:bg-primary/5 active:bg-primary/10' => !$isActive,
                ])
                    @click="$store.mobileMenu.close()">
                    <span @class([
                        'text-xs font-bold w-5 shrink-0',
                        'text-primary/50' => $isActive,
                        'text-neutral-300 dark:text-neutral-600 group-hover:text-primary/40' => !$isActive,
                    ])>{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                    {{ $link['label'] }}
                </a>
            @endforeach
        </nav>

        {{-- Seam divider --}}
        <div class="absolute bottom-0 left-0 right-0 h-px bg-neutral-200 dark:bg-neutral-700/60"></div>
    </div>

    {{-- BOTTOM PANEL: CTA buttons, enters from bottom --}}
    <div x-show="$store.mobileMenu.open" x-transition:enter="transition ease-out duration-400"
        x-transition:enter-start="translate-y-full" x-transition:enter-end="translate-y-0"
        x-transition:leave="transition ease-in duration-300" x-transition:leave-start="translate-y-0"
        x-transition:leave-end="translate-y-full"
        class="fixed bottom-0 left-0 right-0 z-200
               bg-surface-2 dark:bg-surface
               flex flex-col justify-between
               px-6 pt-8"
        style="height:40dvh; padding-bottom: max(env(safe-area-inset-bottom,28px),28px); display:none;">

        {{-- Seam divider --}}
        <div class="absolute top-0 left-0 right-0 h-px bg-neutral-200 dark:bg-neutral-700/60"></div>

        {{-- CTA buttons --}}
        <div class="flex flex-col gap-3 w-full">
            <a href="{{ route('properties.index') }}" @click="$store.mobileMenu.close()"
                class="btn-primary w-full justify-center font-bold text-xl py-4 rounded-2xl shadow-sm">
                {{ __('Añadir propiedad') }}
            </a>
            @auth
                <a href="{{ auth()->user()->dashboard_url }}" @click="$store.mobileMenu.close()"
                    class="w-full flex items-center gap-3 bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 hover:border-primary hover:text-primary active:scale-[0.98] text-neutral-800 dark:text-neutral-100 font-bold text-xl py-3.5 px-5 rounded-2xl transition-all">
                    <div class="w-9 h-9 rounded-full bg-primary/10 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            viewBox="0 0 24 24">
                            <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                            <circle cx="12" cy="7" r="4" />
                        </svg>
                    </div>
                    <span class="truncate">{{ auth()->user()->name }}</span>
                </a>
            @else
                <a href="{{ route('login') }}" @click="$store.mobileMenu.close()"
                    class="w-full flex items-center justify-center gap-3 border-2 border-neutral-200 dark:border-neutral-700 hover:border-primary hover:text-primary active:scale-[0.98] text-neutral-800 dark:text-neutral-100 font-bold text-xl py-4 rounded-2xl transition-all">
                    <svg class="w-6 h-6 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        viewBox="0 0 24 24">
                        <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                        <circle cx="12" cy="7" r="4" />
                    </svg>
                    {{ __('Entrar') }}
                </a>
            @endauth
        </div>

        {{-- Bottom bar: theme toggle + language switcher --}}
        <div class="flex items-center gap-4">
            {{-- Theme toggle --}}
            <button @click="$store.theme.toggle()"
                class="flex items-center gap-2 text-sm font-semibold text-neutral-400 dark:text-neutral-500 hover:text-primary transition-colors"
                :aria-label="$store.theme.isDark ? '{{ __('Cambiar a modo claro') }}' : '{{ __('Cambiar a modo oscuro') }}'">
                <svg x-show="$store.theme.isDark" style="display: none;" class="w-5 h-5"
                    xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="4" />
                    <path d="M12 2v2" />
                    <path d="M12 20v2" />
                    <path d="m4.93 4.93 1.41 1.41" />
                    <path d="m17.66 17.66 1.41 1.41" />
                    <path d="M2 12h2" />
                    <path d="M20 12h2" />
                    <path d="m6.34 17.66-1.41 1.41" />
                    <path d="m19.07 4.93-1.41 1.41" />
                </svg>
                <svg x-show="!$store.theme.isDark" class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    viewBox="0 0 24 24">
                    <path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z" />
                </svg>
                <span x-text="$store.theme.isDark ? '{{ __('Modo claro') }}' : '{{ __('Modo oscuro') }}'"></span>
            </button>

            {{-- Divider --}}
            <span class="w-px h-4 bg-neutral-200 dark:bg-neutral-700"></span>

            {{-- Language Switcher (mobile fullscreen menu) --}}
            <x-public.lang-switcher direction="up" variant="full" />
        </div>
    </div>

</div>
