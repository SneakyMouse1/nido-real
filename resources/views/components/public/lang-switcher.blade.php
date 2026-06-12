@props([
    'direction' => 'down',
    'variant' => 'icon',
])

<div x-data="{ open: false }" class="relative">
    {{-- Trigger --}}
    @if ($variant === 'icon')
        <button @click="open = !open" @keydown.escape.window="open = false"
            class="w-10 h-10 flex items-center justify-center rounded-lg hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-colors cursor-pointer"
            aria-label="{{ __('navbar.switch_language') }}">
            @if (app()->getLocale() === 'es')
                <img src="{{ asset('images/flags/es_ES.svg') }}" alt="ES" class="w-6 h-auto rounded-sm object-cover">
            @else
                <img src="{{ asset('images/flags/en_GB.svg') }}" alt="EN"
                    class="w-6 h-auto rounded-sm object-cover">
            @endif
        </button>
    @else
        <button @click="open = !open" @keydown.escape.window="open = false"
            class="flex items-center gap-1.5 text-sm font-semibold text-neutral-400 dark:text-neutral-500 hover:text-primary transition-colors">
            @if (app()->getLocale() === 'es')
                <img src="{{ asset('images/flags/es_ES.svg') }}" alt="ES"
                    class="w-5 h-auto rounded-sm object-cover">
                <span>ES</span>
            @else
                <img src="{{ asset('images/flags/en_GB.svg') }}" alt="EN"
                    class="w-5 h-auto rounded-sm object-cover">
                <span>EN</span>
            @endif
            <svg class="w-3.5 h-3.5 transition-transform" :class="open ? 'rotate-180' : ''" fill="none"
                viewBox="0 0 16 16">
                <path
                    d="M13.53 6.53L8 12.06 2.47 6.53a.75.75 0 00-1.06 1.06l6 6a.75.75 0 001.06 0l6-6a.75.75 0 00-1.06-1.06z"
                    fill="currentColor" />
            </svg>
        </button>
    @endif

    {{-- Dropdown --}}
    <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute {{ $direction === 'up' ? 'bottom-full left-0 mb-2' : 'top-full right-0 mt-2' }} w-36 bg-white dark:bg-neutral-800 rounded-xl shadow-xl border border-neutral-100 dark:border-neutral-700 py-1.5 z-50"
        style="display:none;">
        <a href="{{ route('locale.switch', 'es') }}"
            class="flex items-center gap-2.5 px-3.5 py-2 text-sm font-semibold text-neutral-700 dark:text-neutral-200 hover:bg-neutral-50 dark:hover:bg-neutral-700 hover:text-primary transition-colors {{ app()->getLocale() === 'es' ? 'text-primary' : '' }}">
            <img src="{{ asset('images/flags/es_ES.svg') }}" alt="ES"
                class="w-5 h-auto rounded-sm object-cover shrink-0">
            Español
            @if (app()->getLocale() === 'es')
                <svg class="w-3.5 h-3.5 ml-auto text-primary" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M16.707 5.293a1 1 0 010 1.414L8.414 15l-4.121-4.121a1 1 0 111.414-1.414L8.414 12.172l7.879-7.879a1 1 0 011.414 0z"
                        clip-rule="evenodd" />
                </svg>
            @endif
        </a>
        <a href="{{ route('locale.switch', 'en') }}"
            class="flex items-center gap-2.5 px-3.5 py-2 text-sm font-semibold text-neutral-700 dark:text-neutral-200 hover:bg-neutral-50 dark:hover:bg-neutral-700 hover:text-primary transition-colors {{ app()->getLocale() === 'en' ? 'text-primary' : '' }}">
            <img src="{{ asset('images/flags/en_GB.svg') }}" alt="EN"
                class="w-5 h-auto rounded-sm object-cover shrink-0">
            English
            @if (app()->getLocale() === 'en')
                <svg class="w-3.5 h-3.5 ml-auto text-primary" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M16.707 5.293a1 1 0 010 1.414L8.414 15l-4.121-4.121a1 1 0 111.414-1.414L8.414 12.172l7.879-7.879a1 1 0 011.414 0z"
                        clip-rule="evenodd" />
                </svg>
            @endif
        </a>
    </div>
</div>
