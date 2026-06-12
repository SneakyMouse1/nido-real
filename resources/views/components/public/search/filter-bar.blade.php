{{-- resources/views/components/public/search/filter-bar.blade.php
     Self-contained search filter bar with advanced filters modal.
     Props:
       $dealType  — initial active tab ('rent' | 'sale'), default 'rent'
       $cities    — array/collection of city strings
--}}
@props([
    'dealType' => 'rent',
    'cities' => [],
    'maxBedrooms' => 5,
    'maxBathrooms' => 4,
    'filtersAvailableSale' => [],
    'filtersAvailableRent' => [],
])

{{-- Alpine scope: activeTab + filtersOpen managed here --}}
<div x-data="{ activeTab: '{{ $dealType }}', filtersOpen: false }" x-effect="document.body.style.overflow = filtersOpen ? 'hidden' : ''">

    {{-- Tabs (Solid, outside the card) --}}
    <div class="flex justify-center gap-1.5 px-4">
        <button @click="activeTab = 'sale'"
            :class="activeTab === 'sale'
                ?
                'bg-primary text-white' :
                'bg-neutral-400 dark:bg-neutral-600 text-white hover:bg-neutral-500 dark:hover:bg-neutral-500'"
            class="px-8 py-2.5 text-sm font-semibold transition-colors focus:outline-none rounded-t-lg">
            {{ __('public.catalog.tab_sale') }}
        </button>
        <button @click="activeTab = 'rent'"
            :class="activeTab === 'rent'
                ?
                'bg-primary text-white' :
                'bg-neutral-400 dark:bg-neutral-600 text-white hover:bg-neutral-500 dark:hover:bg-neutral-500'"
            class="px-8 py-2.5 text-sm font-semibold transition-colors focus:outline-none rounded-t-lg">
            {{ __('public.catalog.tab_rent') }}
        </button>

    </div>

    {{-- FILTER CARD --}}
    <div
        class="bg-white dark:bg-neutral-900 rounded-xl shadow-2xl border border-neutral-100 dark:border-neutral-800 overflow-hidden">

        {{-- Filter fields --}}
        <form method="GET" action="{{ route('properties.index') }}" class="p-4 lg:p-5">
            {{-- Hidden deal_type synced to Alpine tab --}}
            <input type="hidden" name="deal_type" :value="activeTab">

            <div class="flex flex-col lg:flex-row items-stretch lg:items-end gap-3">

                {{-- Buscar --}}
                <div class="flex-1 min-w-0">
                    <label
                        class="block text-xs font-semibold text-neutral-500 dark:text-neutral-400 mb-1.5 uppercase tracking-wide">
                        {{ __('public.catalog.btn_search') }}
                    </label>
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-neutral-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input type="text" name="q" value="{{ request('q') }}"
                            placeholder="{{ __('public.catalog.search_placeholder') }}"
                            class="w-full pl-9 pr-3 py-2.5 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-800 text-sm text-neutral-800 dark:text-neutral-100 placeholder-neutral-400 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition">
                    </div>
                </div>

                {{-- Ubicación --}}
                <div class="lg:w-44">
                    <label
                        class="block text-xs font-semibold text-neutral-500 dark:text-neutral-400 mb-1.5 uppercase tracking-wide">
                        {{ __('public.catalog.location') }}
                    </label>
                    <div class="relative">
                        <select name="city"
                            class="w-full appearance-none pl-3 pr-8 py-2.5 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-800 text-sm text-neutral-700 dark:text-neutral-100 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition">
                            <option value="">{{ __('public.catalog.all_cities') }}</option>
                            @foreach ($cities as $city)
                                <option value="{{ $city }}" {{ request('city') === $city ? 'selected' : '' }}>
                                    {{ $city }}</option>
                            @endforeach
                        </select>
                        <svg class="pointer-events-none absolute right-2.5 top-1/2 -translate-y-1/2 w-4 h-4 text-neutral-400"
                            fill="none" viewBox="0 0 16 16">
                            <path
                                d="M13.53 6.53L8 12.06 2.47 6.53a.75.75 0 00-1.06 1.06l6 6a.75.75 0 001.06 0l6-6a.75.75 0 00-1.06-1.06z"
                                fill="currentColor" />
                        </svg>
                    </div>
                </div>

                {{-- Dormitorios --}}
                <div class="lg:w-36">
                    <label
                        class="block text-xs font-semibold text-neutral-500 dark:text-neutral-400 mb-1.5 uppercase tracking-wide">
                        {{ __('public.catalog.bedrooms') }}
                    </label>
                    <div class="relative">
                        <select name="bedrooms"
                            class="w-full appearance-none pl-3 pr-8 py-2.5 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-800 text-sm text-neutral-700 dark:text-neutral-100 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition">
                            <option value="">{{ __('public.catalog.any') }}</option>
                            @foreach (range(1, min(5, max(1, $maxBedrooms))) as $n)
                                <option value="{{ $n }}" {{ request('bedrooms') == $n ? 'selected' : '' }}>
                                    {{ $n }}+</option>
                            @endforeach
                        </select>
                        <svg class="pointer-events-none absolute right-2.5 top-1/2 -translate-y-1/2 w-4 h-4 text-neutral-400"
                            fill="none" viewBox="0 0 16 16">
                            <path
                                d="M13.53 6.53L8 12.06 2.47 6.53a.75.75 0 00-1.06 1.06l6 6a.75.75 0 001.06 0l6-6a.75.75 0 00-1.06-1.06z"
                                fill="currentColor" />
                        </svg>
                    </div>
                </div>

                {{-- Baños --}}
                <div class="lg:w-32">
                    <label
                        class="block text-xs font-semibold text-neutral-500 dark:text-neutral-400 mb-1.5 uppercase tracking-wide">
                        {{ __('public.catalog.bathrooms') }}
                    </label>
                    <div class="relative">
                        <select name="bathrooms"
                            class="w-full appearance-none pl-3 pr-8 py-2.5 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-800 text-sm text-neutral-700 dark:text-neutral-100 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition">
                            <option value="">{{ __('public.catalog.any') }}</option>
                            @foreach (range(1, min(4, max(1, $maxBathrooms))) as $n)
                                <option value="{{ $n }}"
                                    {{ request('bathrooms') == $n ? 'selected' : '' }}>{{ $n }}+</option>
                            @endforeach
                        </select>
                        <svg class="pointer-events-none absolute right-2.5 top-1/2 -translate-y-1/2 w-4 h-4 text-neutral-400"
                            fill="none" viewBox="0 0 16 16">
                            <path
                                d="M13.53 6.53L8 12.06 2.47 6.53a.75.75 0 00-1.06 1.06l6 6a.75.75 0 001.06 0l6-6a.75.75 0 00-1.06-1.06z"
                                fill="currentColor" />
                        </svg>
                    </div>
                </div>

                {{-- Precio máx. --}}
                <div class="lg:w-40">
                    <label
                        class="block text-xs font-semibold text-neutral-500 dark:text-neutral-400 mb-1.5 uppercase tracking-wide">
                        {{ __('public.catalog.price') }}
                    </label>
                    <div class="relative">
                        <select name="max_price"
                            class="w-full appearance-none pl-3 pr-8 py-2.5 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-800 text-sm text-neutral-700 dark:text-neutral-100 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition">
                            <option value="">{{ __('public.catalog.price_max') }}</option>
                            @foreach ([500, 800, 1000, 1500, 2000, 2500, 3000, 5000, 100000, 250000, 500000, 1000000] as $p)
                                <option value="{{ $p }}"
                                    {{ request('max_price') == $p ? 'selected' : '' }}>
                                    {{ number_format($p, 0, ',', '.') }} €
                                </option>
                            @endforeach
                        </select>
                        <svg class="pointer-events-none absolute right-2.5 top-1/2 -translate-y-1/2 w-4 h-4 text-neutral-400"
                            fill="none" viewBox="0 0 16 16">
                            <path
                                d="M13.53 6.53L8 12.06 2.47 6.53a.75.75 0 00-1.06 1.06l6 6a.75.75 0 001.06 0l6-6a.75.75 0 00-1.06-1.06z"
                                fill="currentColor" />
                        </svg>
                    </div>
                </div>

                {{-- Buttons: Search + Faders ──────────────────────── --}}
                <div class="flex items-end gap-2">
                    {{-- Search --}}
                    <button type="submit"
                        class="flex-1 lg:flex-none bg-accent hover:bg-accent/90 text-white font-bold text-sm px-6 py-2.5 rounded-lg transition-colors flex items-center justify-center gap-2 whitespace-nowrap">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        {{ __('public.catalog.btn_search') }}
                    </button>

                    {{-- Faders — opens advanced filters modal --}}
                    <button type="button" @click="filtersOpen = true"
                        class="w-10 h-10 shrink-0 flex items-center justify-center rounded-lg border border-neutral-200 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-800 hover:bg-neutral-100 dark:hover:bg-neutral-700 hover:border-primary dark:hover:border-primary transition-colors"
                        :class="filtersOpen ? 'border-primary bg-primary/5 dark:bg-primary/10' : ''"
                        :aria-label="'{{ __('public.catalog.filters') }}'">
                        {{-- faders.svg inline — currentColor adapts to light/dark --}}
                        <svg class="w-5 h-5 text-neutral-600 dark:text-neutral-300"
                            :class="filtersOpen ? 'text-primary!' : ''" viewBox="0 0 28 28" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M14.875 13.125V23.625C14.875 23.8571 14.7828 24.0796 14.6187 24.2437C14.4546 24.4078 14.2321 24.5 14 24.5C13.7679 24.5 13.5454 24.4078 13.3813 24.2437C13.2172 24.0796 13.125 23.8571 13.125 23.625V13.125C13.125 12.8929 13.2172 12.6704 13.3813 12.5063C13.5454 12.3422 13.7679 12.25 14 12.25C14.2321 12.25 14.4546 12.3422 14.6187 12.5063C14.7828 12.6704 14.875 12.8929 14.875 13.125ZM21.875 21C21.6429 21 21.4204 21.0922 21.2563 21.2563C21.0922 21.4204 21 21.6429 21 21.875V23.625C21 23.8571 21.0922 24.0796 21.2563 24.2437C21.4204 24.4078 21.6429 24.5 21.875 24.5C22.1071 24.5 22.3296 24.4078 22.4937 24.2437C22.6578 24.0796 22.75 23.8571 22.75 23.625V21.875C22.75 21.6429 22.6578 21.4204 22.4937 21.2563C22.3296 21.0922 22.1071 21 21.875 21ZM24.5 17.5H22.75V4.375C22.75 4.14294 22.6578 3.92038 22.4937 3.75628C22.3296 3.59219 22.1071 3.5 21.875 3.5C21.6429 3.5 21.4204 3.59219 21.2563 3.75628C21.0922 3.92038 21 4.14294 21 4.375V17.5H19.25C19.0179 17.5 18.7954 17.5922 18.6313 17.7563C18.4672 17.9204 18.375 18.1429 18.375 18.375C18.375 18.6071 18.4672 18.8296 18.6313 18.9937C18.7954 19.1578 19.0179 19.25 19.25 19.25H24.5C24.7321 19.25 24.9546 19.1578 25.1187 18.9937C25.2828 18.8296 25.375 18.6071 25.375 18.375C25.375 18.1429 25.2828 17.9204 25.1187 17.7563C24.9546 17.5922 24.7321 17.5 24.5 17.5ZM6.125 17.5C5.89294 17.5 5.67038 17.5922 5.50628 17.7563C5.34219 17.9204 5.25 18.1429 5.25 18.375V23.625C5.25 23.8571 5.34219 24.0796 5.50628 24.2437C5.67038 24.4078 5.89294 24.5 6.125 24.5C6.35706 24.5 6.57962 24.4078 6.74372 24.2437C6.90781 24.0796 7 23.8571 7 23.625V18.375C7 18.1429 6.90781 17.9204 6.74372 17.7563C6.57962 17.5922 6.35706 17.5 6.125 17.5ZM8.75 14H7V4.375C7 4.14294 6.90781 3.92038 6.74372 3.75628C6.57962 3.59219 6.35706 3.5 6.125 3.5C5.89294 3.5 5.67038 3.59219 5.50628 3.75628C5.34219 3.92038 5.25 4.14294 5.25 4.375V14H3.5C3.26794 14 3.04538 14.0922 2.88128 14.2563C2.71719 14.4204 2.625 14.6429 2.625 14.875C2.625 15.1071 2.71719 15.3296 2.88128 15.4937C3.04538 15.6578 3.26794 15.75 3.5 15.75H8.75C8.98206 15.75 9.20462 15.6578 9.36872 15.4937C9.53281 15.3296 9.625 15.1071 9.625 14.875C9.625 14.6429 9.53281 14.4204 9.36872 14.2563C9.20462 14.0922 8.98206 14 8.75 14ZM16.625 8.75H14.875V4.375C14.875 4.14294 14.7828 3.92038 14.6187 3.75628C14.4546 3.59219 14.2321 3.5 14 3.5C13.7679 3.5 13.5454 3.59219 13.3813 3.75628C13.2172 3.92038 13.125 4.14294 13.125 4.375V8.75H11.375C11.1429 8.75 10.9204 8.84219 10.7563 9.00628C10.5922 9.17038 10.5 9.39294 10.5 9.625C10.5 9.85706 10.5922 10.0796 10.7563 10.2437C10.9204 10.4078 11.1429 10.5 11.375 10.5H16.625C16.8571 10.5 17.0796 10.4078 17.2437 10.2437C17.4078 10.0796 17.5 9.85706 17.5 9.625C17.5 9.39294 17.4078 9.17038 17.2437 9.00628C17.0796 8.84219 16.8571 8.75 16.625 8.75Z"
                                fill="currentColor" />
                        </svg>
                    </button>
                </div>

            </div>
        </form>
    </div>{{-- /filter card --}}

    <x-public.search.filters-modal :max-bedrooms="$maxBedrooms" :max-bathrooms="$maxBathrooms" :filters-available-sale="$filtersAvailableSale" :filters-available-rent="$filtersAvailableRent" />

</div>{{-- /x-data --}}
