{{-- resources/views/public/properties/index.blade.php --}}
@extends('layouts.public')

@section('title', __('public.catalog.title') . ' — NidoReal')
@section('description', __('Explora todos los inmuebles disponibles en NidoReal. Alquiler y venta en toda España.'))

@section('content')

    {{-- MAP + FILTER SECTION --}}
    <div>

        {{--  MAP BLOCK  --}}
        <section class="relative w-full h-full" style="height: 70vh; min-height: 320px; position: relative;">

            {{-- Real Mapbox map — centered on Spain --}}
            <div id="catalog-map" class="absolute inset-0" style="position: absolute; top: 0; right: 0; bottom: 0; left: 0;">
            </div>

            {{-- FILTER BAR --}}
            <div class="hidden lg:block absolute bottom-0 left-0 right-0 translate-y-1/2 z-20 px-6">
                <div class="mx-auto max-w-[1280px]">
                    <x-public.search.filter-bar :deal-type="request('deal_type', 'sale')" :cities="$cities" :max-bedrooms="$maxBedrooms" :max-bathrooms="$maxBathrooms"
                        :filters-available-sale="$filtersAvailableSale" :filters-available-rent="$filtersAvailableRent" />
                </div>
            </div>

        </section>{{-- /MAP --}}

        {{--  FILTER BAR (mobile: below map)  --}}
        <div class="lg:hidden px-4 pt-4 pb-2 bg-neutral-50 dark:bg-neutral-950">
            <div class="mx-auto max-w-[1280px]">
                <x-public.search.filter-bar :deal-type="request('deal_type', 'sale')" :cities="$cities" :max-bedrooms="$maxBedrooms" :max-bathrooms="$maxBathrooms"
                    :filters-available-sale="$filtersAvailableSale" :filters-available-rent="$filtersAvailableRent" />
            </div>
        </div>

    </div>{{-- /x-data activeTab --}}

    {{-- MAIN CONTENT --}}
    <main class="bg-neutral-50 dark:bg-neutral-950 lg:pt-24 pt-6 pb-20">
        <div id="catalog-container"
            class="scroll-mt-24 lg:scroll-mt-32 mx-auto max-w-[1280px] px-4 sm:px-6 transition-opacity duration-300">

            {{-- Breadcrumbs --}}
            <nav aria-label="breadcrumb"
                class="flex items-center gap-1.5 text-sm text-neutral-500 dark:text-neutral-400 mb-4">
                <a href="{{ route('home') }}" class="hover:text-primary transition-colors">
                    {{ __('public.catalog.breadcrumb_home') }}
                </a>
                <svg class="w-3.5 h-3.5 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
                <span class="text-neutral-800 dark:text-neutral-200 font-semibold">
                    {{ __('public.catalog.breadcrumb_props') }}
                </span>
            </nav>

            {{-- Title + Controls row --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">

                {{-- Heading --}}
                <div>
                    <h1 class="text-3xl font-bold text-neutral-900 dark:text-neutral-50">
                        {{ __('public.catalog.title') }}
                    </h1>
                    <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-1">
                        {{ $properties->total() }}
                        {{ $properties->total() === 1 ? __('resultado') : __('resultados') }}
                    </p>
                </div>

                {{-- Controls: view toggle + sort --}}
                <div class="flex items-center gap-3">

                    {{-- Grid / List toggle --}}
                    <div
                        class="flex items-center gap-1 bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-700 rounded-lg p-1 shadow-sm">
                        <button @click="$store.catalog.setView('grid')"
                            :class="$store.catalog.view === 'grid' ? 'bg-primary text-white shadow-sm' :
                                'text-neutral-400 hover:text-neutral-700 dark:hover:text-neutral-200'"
                            class="w-8 h-8 flex items-center justify-center rounded-md transition-colors"
                            :aria-label="'{{ __('public.catalog.view_grid') }}'">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                            </svg>
                        </button>
                        <button @click="$store.catalog.setView('list')"
                            :class="$store.catalog.view === 'list' ? 'bg-primary text-white shadow-sm' :
                                'text-neutral-400 hover:text-neutral-700 dark:hover:text-neutral-200'"
                            class="w-8 h-8 flex items-center justify-center rounded-md transition-colors"
                            :aria-label="'{{ __('public.catalog.view_list') }}'">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                            </svg>
                        </button>
                    </div>

                    {{-- Per Page dropdown --}}
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open"
                            class="flex items-center gap-2 bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-700 rounded-lg px-4 py-2 text-sm font-semibold text-neutral-700 dark:text-neutral-200 shadow-sm hover:bg-neutral-50 dark:hover:bg-neutral-800 transition-colors">
                            @php
                                $currentPerPage = request('per_page', 12);
                                $perPageOptions = [12, 18, 24, 42, 60];
                            @endphp
                            <span>{{ $currentPerPage }} {{ __('por pág.') }}</span>
                            <svg class="w-4 h-4 text-neutral-400 transition-transform" :class="open ? 'rotate-180' : ''"
                                fill="none" viewBox="0 0 16 16">
                                <path
                                    d="M13.53 6.53L8 12.06 2.47 6.53a.75.75 0 00-1.06 1.06l6 6a.75.75 0 001.06 0l6-6a.75.75 0 00-1.06-1.06z"
                                    fill="currentColor" />
                            </svg>
                        </button>
                        <div x-show="open" @click.away="open = false" x-transition
                            class="absolute right-0 top-full mt-1.5 w-32 bg-white dark:bg-neutral-900 rounded-xl border border-neutral-100 dark:border-neutral-800 shadow-xl py-1 z-30">
                            @foreach ($perPageOptions as $option)
                                <a href="{{ request()->fullUrlWithQuery(['per_page' => $option, 'page' => null]) }}"
                                    class="js-ajax-link flex items-center px-4 py-2.5 text-sm {{ $currentPerPage == $option ? 'text-primary font-bold bg-primary/5' : 'text-neutral-700 dark:text-neutral-200 hover:bg-neutral-50 dark:hover:bg-neutral-800' }} transition-colors">
                                    {{ $option }} {{ __('obj.') }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                    {{-- Sort dropdown --}}
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open"
                            class="flex items-center gap-2 bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-700 rounded-lg px-4 py-2 text-sm font-semibold text-neutral-700 dark:text-neutral-200 shadow-sm hover:bg-neutral-50 dark:hover:bg-neutral-800 transition-colors">
                            <svg class="w-4 h-4 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4" />
                            </svg>
                            @php
                                $sortLabels = [
                                    'newest' => __('public.catalog.sort_default'),
                                    'price_asc' => __('public.catalog.sort_price_asc'),
                                    'price_desc' => __('public.catalog.sort_price_desc'),
                                    'area_desc' => __('public.catalog.sort_area'),
                                ];
                                $currentSort = request('sort', 'newest');
                            @endphp
                            <span>{{ $sortLabels[$currentSort] ?? __('public.catalog.sort_default') }}</span>
                            <svg class="w-4 h-4 text-neutral-400 transition-transform" :class="open ? 'rotate-180' : ''"
                                fill="none" viewBox="0 0 16 16">
                                <path
                                    d="M13.53 6.53L8 12.06 2.47 6.53a.75.75 0 00-1.06 1.06l6 6a.75.75 0 001.06 0l6-6a.75.75 0 00-1.06-1.06z"
                                    fill="currentColor" />
                            </svg>
                        </button>
                        <div x-show="open" @click.away="open = false" x-transition
                            class="absolute right-0 top-full mt-1.5 w-52 bg-white dark:bg-neutral-900 rounded-xl border border-neutral-100 dark:border-neutral-800 shadow-xl py-1 z-30">
                            @foreach ($sortLabels as $val => $label)
                                <a href="{{ request()->fullUrlWithQuery(['sort' => $val, 'page' => null]) }}"
                                    class="js-ajax-link flex items-center gap-2 px-4 py-2.5 text-sm {{ $currentSort === $val ? 'text-primary font-bold bg-primary/5' : 'text-neutral-700 dark:text-neutral-200 hover:bg-neutral-50 dark:hover:bg-neutral-800' }} transition-colors">
                                    @if ($currentSort === $val)
                                        <svg class="w-4 h-4 text-primary shrink-0" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                    @else
                                        <span class="w-4 shrink-0"></span>
                                    @endif
                                    {{ $label }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                </div>{{-- /controls --}}
            </div>

            {{--  Property Grid  --}}
            @if ($properties->isEmpty())
                <div class="flex flex-col items-center justify-center py-24 text-center">
                    <div
                        class="w-20 h-20 rounded-full bg-neutral-100 dark:bg-neutral-800 flex items-center justify-center mb-5">
                        <svg class="w-9 h-9 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                    </div>
                    <p class="text-lg font-semibold text-neutral-700 dark:text-neutral-300 mb-2">
                        {{ __('public.catalog.no_results') }}
                    </p>
                    <a href="{{ route('properties.index') }}"
                        class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-primary hover:text-primary-content transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        {{ __('Ver todos los inmuebles') }}
                    </a>
                </div>
            @else
                <div
                    :class="$store.catalog.view === 'grid' ?
                        'grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6' :
                        'flex flex-col gap-4'">

                    @foreach ($properties as $property)
                        <x-public.property.card :property="$property" />
                    @endforeach
                </div>

                {{--  Pagination  --}}
                @if ($properties->hasPages())
                    <div class="mt-12 flex justify-center">
                        <nav class="flex items-center gap-1" aria-label="{{ __('Paginación') }}">

                            @if ($properties->onFirstPage())
                                <span
                                    class="w-10 h-10 flex items-center justify-center rounded-lg text-neutral-300 dark:text-neutral-600 cursor-not-allowed">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                        stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                                    </svg>
                                </span>
                            @else
                                <a href="{{ $properties->previousPageUrl() }}"
                                    class="w-10 h-10 flex items-center justify-center rounded-lg border border-neutral-200 dark:border-neutral-700 text-neutral-600 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-colors">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                        stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                                    </svg>
                                </a>
                            @endif

                            @foreach ($properties->getUrlRange(1, $properties->lastPage()) as $page => $url)
                                @if ($page === $properties->currentPage())
                                    <span
                                        class="w-10 h-10 flex items-center justify-center rounded-lg bg-primary text-white font-bold text-sm shadow-sm">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $url }}"
                                        class="w-10 h-10 flex items-center justify-center rounded-lg border border-neutral-200 dark:border-neutral-700 text-neutral-600 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-colors text-sm font-semibold">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach

                            @if ($properties->hasMorePages())
                                <a href="{{ $properties->nextPageUrl() }}"
                                    class="w-10 h-10 flex items-center justify-center rounded-lg border border-neutral-200 dark:border-neutral-700 text-neutral-600 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-colors">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                        stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            @else
                                <span
                                    class="w-10 h-10 flex items-center justify-center rounded-lg text-neutral-300 dark:text-neutral-600 cursor-not-allowed">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                        stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                    </svg>
                                </span>
                            @endif

                        </nav>
                    </div>
                @endif

            @endif
        </div>
    </main>


@endsection
