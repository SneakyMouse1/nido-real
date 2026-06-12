{{-- resources/views/components/public/search/filters-modal.blade.php
     Advanced filters modal slide-in panel.
     Requires `filtersOpen` in nearest Alpine x-data ancestor scope.
     Usage: place inside same x-data block as faders button.
--}}
@props([
    'maxBedrooms' => 5,
    'maxBathrooms' => 4,
    'filtersAvailableSale' => [],
    'filtersAvailableRent' => [],
])
@php
    $propertyTypes = \App\Models\PropertyType::where('is_active', true)->orderBy('sort_order')->get();
    $requestedTypes = request('type', []);
    if (!is_array($requestedTypes)) {
        $requestedTypes = [$requestedTypes];
    }
    $requestedTypes = array_filter(array_map('strval', $requestedTypes));
@endphp
<template x-teleport="body">
    <div x-show="filtersOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        @keydown.escape.window="filtersOpen = false"
        class="fixed inset-0 z-100 flex items-end sm:items-center justify-center p-0 sm:p-4" style="display: none;">

        {{-- Backdrop --}}
        <div class="absolute inset-0 bg-neutral-900/60 backdrop-blur-sm" @click="filtersOpen = false"
            aria-hidden="true">
        </div>

        {{-- Panel --}}
        <div x-show="filtersOpen" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-8 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-8 sm:translate-y-0 sm:scale-95" x-data="{
                filtersAvailableSale: {{ json_encode($filtersAvailableSale) }},
                filtersAvailableRent: {{ json_encode($filtersAvailableRent) }},
                types: {{ json_encode(array_values($requestedTypes)) }},
                getCurrentFilters() {
                    return activeTab === 'sale' ? this.filtersAvailableSale : this.filtersAvailableRent;
                },
                isCertAvailable(cert) {
                    let certs = this.getCurrentFilters().energy_certificate;
                    return certs ? certs.includes(cert) : false;
                },
                isOriAvailable(ori) {
                    let oris = this.getCurrentFilters().orientation;
                    return oris ? oris.includes(ori) : false;
                }
            }"
            class="relative bg-white dark:bg-neutral-900 w-full sm:rounded-2xl sm:max-w-2xl max-h-[92vh] sm:max-h-[85vh] overflow-hidden flex flex-col shadow-2xl border-0 sm:border border-neutral-200 dark:border-neutral-800">

            {{-- Header --}}
            <div
                class="flex items-center justify-between px-6 py-4 border-b border-neutral-100 dark:border-neutral-800 shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-primary/10 dark:bg-primary/20 flex items-center justify-center">
                        <svg class="w-4.5 h-4.5 text-primary" viewBox="0 0 28 28" fill="none"
                            xmlns="http://www.w3.org/2000/svg" style="width:18px;height:18px;">
                            <path
                                d="M14.875 13.125V23.625C14.875 23.8571 14.7828 24.0796 14.6187 24.2437C14.4546 24.4078 14.2321 24.5 14 24.5C13.7679 24.5 13.5454 24.4078 13.3813 24.2437C13.2172 24.0796 13.125 23.8571 13.125 23.625V13.125C13.125 12.8929 13.2172 12.6704 13.3813 12.5063C13.5454 12.3422 13.7679 12.25 14 12.25C14.2321 12.25 14.4546 12.3422 14.6187 12.5063C14.7828 12.6704 14.875 12.8929 14.875 13.125ZM21.875 21C21.6429 21 21.4204 21.0922 21.2563 21.2563C21.0922 21.4204 21 21.6429 21 21.875V23.625C21 23.8571 21.0922 24.0796 21.2563 24.2437C21.4204 24.4078 21.6429 24.5 21.875 24.5C22.1071 24.5 22.3296 24.4078 22.4937 24.2437C22.6578 24.0796 22.75 23.8571 22.75 23.625V21.875C22.75 21.6429 22.6578 21.4204 22.4937 21.2563C22.3296 21.0922 22.1071 21 21.875 21ZM24.5 17.5H22.75V4.375C22.75 4.14294 22.6578 3.92038 22.4937 3.75628C22.3296 3.59219 22.1071 3.5 21.875 3.5C21.6429 3.5 21.4204 3.59219 21.2563 3.75628C21.0922 3.92038 21 4.14294 21 4.375V17.5H19.25C19.0179 17.5 18.7954 17.5922 18.6313 17.7563C18.4672 17.9204 18.375 18.1429 18.375 18.375C18.375 18.6071 18.4672 18.8296 18.6313 18.9937C18.7954 19.1578 19.0179 19.25 19.25 19.25H24.5C24.7321 19.25 24.9546 19.1578 25.1187 18.9937C25.2828 18.8296 25.375 18.6071 25.375 18.375C25.375 18.1429 25.2828 17.9204 25.1187 17.7563C24.9546 17.5922 24.7321 17.5 24.5 17.5ZM6.125 17.5C5.89294 17.5 5.67038 17.5922 5.50628 17.7563C5.34219 17.9204 5.25 18.1429 5.25 18.375V23.625C5.25 23.8571 5.34219 24.0796 5.50628 24.2437C5.67038 24.4078 5.89294 24.5 6.125 24.5C6.35706 24.5 6.57962 24.4078 6.74372 24.2437C6.90781 24.0796 7 23.8571 7 23.625V18.375C7 18.1429 6.90781 17.9204 6.74372 17.7563C6.57962 17.5922 6.35706 17.5 6.125 17.5ZM8.75 14H7V4.375C7 4.14294 6.90781 3.92038 6.74372 3.75628C6.57962 3.59219 6.35706 3.5 6.125 3.5C5.89294 3.5 5.67038 3.59219 5.50628 3.75628C5.34219 3.92038 5.25 4.14294 5.25 4.375V14H3.5C3.26794 14 3.04538 14.0922 2.88128 14.2563C2.71719 14.4204 2.625 14.6429 2.625 14.875C2.625 15.1071 2.71719 15.3296 2.88128 15.4937C3.04538 15.6578 3.26794 15.75 3.5 15.75H8.75C8.98206 15.75 9.20462 15.6578 9.36872 15.4937C9.53281 15.3296 9.625 15.1071 9.625 14.875C9.625 14.6429 9.53281 14.4204 9.36872 14.2563C9.20462 14.0922 8.98206 14 8.75 14ZM16.625 8.75H14.875V4.375C14.875 4.14294 14.7828 3.92038 14.6187 3.75628C14.4546 3.59219 14.2321 3.5 14 3.5C13.7679 3.5 13.5454 3.59219 13.3813 3.75628C13.2172 3.92038 13.125 4.14294 13.125 4.375V8.75H11.375C11.1429 8.75 10.9204 8.84219 10.7563 9.00628C10.5922 9.17038 10.5 9.39294 10.5 9.625C10.5 9.85706 10.5922 10.0796 10.7563 10.2437C10.9204 10.4078 11.1429 10.5 11.375 10.5H16.625C16.8571 10.5 17.0796 10.4078 17.2437 10.2437C17.4078 10.0796 17.5 9.85706 17.5 9.625C17.5 9.39294 17.4078 9.17038 17.2437 9.00628C17.0796 8.84219 16.8571 8.75 16.625 8.75Z"
                                fill="currentColor" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-neutral-900 dark:text-white">{{ __('Filtros avanzados') }}</h3>
                </div>
                <button @click="filtersOpen = false"
                    class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-neutral-100 dark:hover:bg-neutral-800 text-neutral-500 transition-colors"
                    aria-label="{{ __('Cerrar filtros') }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Scrollable body --}}
            <div class="overflow-y-auto flex-1">
                <form action="{{ route('properties.index') }}" method="GET" class="p-6 space-y-7"
                    id="advanced-filters-form">
                    <input type="hidden" name="deal_type" :value="activeTab">

                    {{-- Características --}}
                    <section>
                        <h4
                            class="text-xs font-bold uppercase tracking-[0.18em] text-neutral-400 dark:text-neutral-500 mb-4">
                            {{ __('Características') }}
                        </h4>
                        <div class="grid grid-cols-2 gap-4">
                            @foreach ([['bedrooms_min', 'Dormitorios mín.', 'select', min(5, max(1, $maxBedrooms))], ['bathrooms_min', 'Baños mín.', 'select', min(4, max(1, $maxBathrooms))]] as [$name, $label, $type, $maxVal])
                                <div>
                                    <label
                                        class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-1.5">
                                        {{ __($label) }}
                                    </label>
                                    <select name="{{ $name }}"
                                        class="w-full px-3 py-2.5 border border-neutral-200 dark:border-neutral-700 rounded-lg text-sm outline-none bg-white dark:bg-neutral-800 text-neutral-800 dark:text-neutral-200 focus:border-primary focus:ring-2 focus:ring-primary/20 transition appearance-none">
                                        <option value="">{{ __('Cualquiera') }}</option>
                                        @foreach (range(1, $maxVal) as $n)
                                            <option value="{{ $n }}"
                                                {{ request($name) == $n ? 'selected' : '' }}>{{ $n }}+
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endforeach

                            @foreach ([['area_min', 'Superficie mín. (m²)', 'Ej. 50'], ['area_max', 'Superficie máx. (m²)', 'Ej. 300'], ['year_min', 'Año construcción desde', 'Ej. 2000']] as [$name, $label, $ph])
                                <div>
                                    <label
                                        class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-1.5">
                                        {{ __($label) }}
                                    </label>
                                    <input type="number" name="{{ $name }}" placeholder="{{ __($ph) }}"
                                        class="w-full px-3 py-2.5 border border-neutral-200 dark:border-neutral-700 rounded-lg text-sm outline-none bg-white dark:bg-neutral-800 text-neutral-800 dark:text-neutral-200 placeholder-neutral-400 focus:border-primary focus:ring-2 focus:ring-primary/20 transition">
                                </div>
                            @endforeach

                            <div>
                                <label
                                    class="block text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-1.5">
                                    {{ __('Planta') }}
                                </label>
                                <select name="floor"
                                    class="w-full px-3 py-2.5 border border-neutral-200 dark:border-neutral-700 rounded-lg text-sm outline-none bg-white dark:bg-neutral-800 text-neutral-800 dark:text-neutral-200 focus:border-primary focus:ring-2 focus:ring-primary/20 transition appearance-none">
                                    <option value="">{{ __('Cualquiera') }}</option>
                                    <option>{{ __('Bajo') }}</option>
                                    <option>{{ __('Entreplanta') }}</option>
                                    @foreach (range(1, 5) as $n)
                                        <option>{{ $n }}ª</option>
                                    @endforeach
                                    <option>{{ __('Ático') }}</option>
                                </select>
                            </div>
                        </div>
                    </section>

                    {{-- Divider --}}
                    <div class="border-t border-neutral-100 dark:border-neutral-800"></div>

                    {{-- Tipo de inmueble --}}
                    <section>
                        <h4
                            class="text-xs font-bold uppercase tracking-[0.18em] text-neutral-400 dark:text-neutral-500 mb-4">
                            {{ __('Tipo de inmueble') }}
                        </h4>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($propertyTypes as $type)
                                @php
                                    $dbValueStr = (string) $type->id;
                                    $isInitiallyChecked = in_array($dbValueStr, $requestedTypes);
                                @endphp
                                <label x-data="{ dbValue: '{{ $type->id }}' }"
                                    :class="{
                                        'border-primary bg-primary/5 text-primary font-semibold': types.includes(
                                            dbValue),
                                        'border-neutral-200 dark:border-neutral-700 text-neutral-600 dark:text-neutral-300 cursor-pointer transition-colors':
                                            !types.includes(dbValue)
                                    }"
                                    class="relative px-4 py-2 border rounded-full text-sm select-none">
                                    <input type="checkbox" name="type[]" value="{{ $type->id }}" x-model="types"
                                        class="sr-only">
                                    {{ $type->name }}
                                </label>
                            @endforeach
                        </div>
                    </section>

                    {{-- Divider --}}
                    <div class="border-t border-neutral-100 dark:border-neutral-800"></div>

                    {{-- Extras --}}
                    <section
                        x-show="getCurrentFilters().has_garage || getCurrentFilters().has_storage || getCurrentFilters().is_featured">
                        <h4
                            class="text-xs font-bold uppercase tracking-[0.18em] text-neutral-400 dark:text-neutral-500 mb-4">
                            {{ __('Extras') }}
                        </h4>
                        <div class="space-y-0 divide-y divide-neutral-100 dark:divide-neutral-800">
                            @foreach ([['has_garage', 'Garaje incluido'], ['has_storage', 'Trastero incluido'], ['is_featured', 'Solo destacados']] as [$name, $label])
                                <label x-show="getCurrentFilters().{{ $name }}"
                                    class="flex items-center justify-between py-3.5 cursor-pointer group">
                                    <span
                                        class="text-sm font-medium text-neutral-800 dark:text-neutral-200 group-hover:text-primary transition-colors">
                                        {{ __($label) }}
                                    </span>
                                    <div x-data="{ on: false }" @click.stop="on = !on"
                                        x-effect="if (!getCurrentFilters().{{ $name }}) on = false"
                                        :class="on ? 'bg-primary' : 'bg-neutral-200 dark:bg-neutral-700'"
                                        class="relative w-11 h-6 rounded-full transition-colors cursor-pointer shrink-0">
                                        <input type="hidden" name="{{ $name }}" :value="on ? '1' : ''">
                                        <div :class="on ? 'translate-x-5' : 'translate-x-1'"
                                            class="absolute top-1 w-4 h-4 bg-white rounded-full transition-transform shadow-sm">
                                        </div>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </section>

                    {{-- Divider --}}
                    <div class="border-t border-neutral-100 dark:border-neutral-800"></div>

                    {{-- Certificado energético --}}
                    <section
                        x-show="getCurrentFilters().energy_certificate && getCurrentFilters().energy_certificate.length > 0">
                        <h4
                            class="text-xs font-bold uppercase tracking-[0.18em] text-neutral-400 dark:text-neutral-500 mb-4">
                            {{ __('Certificado energético') }}
                        </h4>
                        <div class="flex flex-wrap gap-2">
                            @php
                                $certList = [
                                    'A' => 'A',
                                    'B' => 'B',
                                    'C' => 'C',
                                    'D' => 'D',
                                    'E' => 'E',
                                    'F' => 'F',
                                    'G' => 'G',
                                    'pending' => 'En trámite',
                                    'exempt' => 'Exento',
                                ];
                                $requestedEnergy = (array) request('energy', []);
                            @endphp
                            @foreach ($certList as $certDbValue => $certLabel)
                                @php
                                    $isChecked = in_array($certDbValue, $requestedEnergy);
                                @endphp
                                <label x-data="{
                                    checked: {{ $isChecked ? 'true' : 'false' }},
                                    dbValue: '{{ $certDbValue }}'
                                }" x-show="isCertAvailable(dbValue)"
                                    x-effect="if (!isCertAvailable(dbValue)) checked = false"
                                    :class="{
                                        'border-primary bg-primary/5 text-primary font-semibold': checked,
                                        'border-neutral-200 dark:border-neutral-700 text-neutral-600 dark:text-neutral-300 cursor-pointer transition-colors': (
                                            !checked) && isCertAvailable(dbValue),
                                        'border-neutral-100 dark:border-neutral-800 text-neutral-300 dark:text-neutral-600 line-through opacity-50 cursor-not-allowed': (
                                            !checked) && !isCertAvailable(dbValue)
                                    }"
                                    class="relative px-4 py-2 border rounded-full text-sm select-none">
                                    <input type="checkbox" name="energy[]" value="{{ $certDbValue }}"
                                        x-model="checked" :disabled="!isCertAvailable(dbValue) && !checked"
                                        class="sr-only">
                                    {{ __($certLabel) }}
                                </label>
                            @endforeach
                        </div>
                    </section>

                    {{-- Divider --}}
                    <div class="border-t border-neutral-100 dark:border-neutral-800"></div>

                    {{-- Orientación --}}
                    <section x-show="getCurrentFilters().orientation && getCurrentFilters().orientation.length > 0">
                        <h4
                            class="text-xs font-bold uppercase tracking-[0.18em] text-neutral-400 dark:text-neutral-500 mb-4">
                            {{ __('Orientación') }}
                        </h4>
                        <div class="flex flex-wrap gap-2">
                            @php
                                $oriList = [
                                    'north' => 'Norte',
                                    'south' => 'Sur',
                                    'east' => 'Este',
                                    'west' => 'Oeste',
                                    'north_east' => 'Noreste',
                                    'north_west' => 'Noroeste',
                                    'south_east' => 'Sureste',
                                    'south_west' => 'Suroeste',
                                ];
                                $requestedOri = (array) request('orientation', []);
                            @endphp
                            @foreach ($oriList as $oriDbValue => $oriLabel)
                                @php
                                    $isChecked = in_array($oriDbValue, $requestedOri);
                                @endphp
                                <label x-data="{
                                    checked: {{ $isChecked ? 'true' : 'false' }},
                                    dbValue: '{{ $oriDbValue }}'
                                }" x-show="isOriAvailable(dbValue)"
                                    x-effect="if (!isOriAvailable(dbValue)) checked = false"
                                    :class="{
                                        'border-primary bg-primary/5 text-primary font-semibold': checked,
                                        'border-neutral-200 dark:border-neutral-700 text-neutral-600 dark:text-neutral-300 cursor-pointer transition-colors': (
                                            !checked) && isOriAvailable(dbValue),
                                        'border-neutral-100 dark:border-neutral-800 text-neutral-300 dark:text-neutral-600 line-through opacity-50 cursor-not-allowed': (
                                            !checked) && !isOriAvailable(dbValue)
                                    }"
                                    class="relative px-4 py-2 border rounded-full text-sm select-none">
                                    <input type="checkbox" name="orientation[]" value="{{ $oriDbValue }}"
                                        x-model="checked" :disabled="!isOriAvailable(dbValue) && !checked"
                                        class="sr-only">
                                    {{ __($oriLabel) }}
                                </label>
                            @endforeach
                        </div>
                    </section>
                </form>
            </div>

            {{-- Footer with action buttons --}}
            <div
                class="shrink-0 px-6 py-4 border-t border-neutral-100 dark:border-neutral-800 bg-neutral-50 dark:bg-neutral-950 flex items-center justify-between gap-3">
                <button type="button" @click="filtersOpen = false"
                    class="text-sm font-semibold text-neutral-500 dark:text-neutral-400 hover:text-neutral-800 dark:hover:text-neutral-200 transition-colors px-2 py-1">
                    {{ __('Cancelar') }}
                </button>
                <div class="flex items-center gap-3">
                    <a href="{{ route('properties.index') }}" @click="types = []; filtersOpen = false"
                        class="px-5 py-2.5 border border-neutral-200 dark:border-neutral-700 rounded-lg text-sm font-semibold text-neutral-700 dark:text-neutral-200 hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-colors">
                        {{ __('Borrar todo') }}
                    </a>
                    <button type="submit" form="advanced-filters-form" @click="filtersOpen = false"
                        class="px-6 py-2.5 bg-primary hover:bg-primary/90 text-white rounded-lg text-sm font-bold transition-colors shadow-sm">
                        {{ __('Aplicar filtros') }}
                    </button>
                </div>
            </div>

        </div>
    </div>
</template>
