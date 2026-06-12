{{-- resources/views/public/properties/show.blade.php --}}
@extends('layouts.public')

@section('title', ($property->meta_title ?: $property->title) . ' — NidoReal')
@section('description', $property->meta_description ?: Str::limit(strip_tags($property->description ?? ''), 160))

@section('content')

@section('navbar')
    <x-public.navbar :floating="false" />
@endsection

{{--  PHOTO GALLERY  --}}
<x-public.property.gallery :property="$property" :photos="$photos" />

{{--  MAIN CONTENT — 2-column layout --}}
<div class="bg-neutral-50 dark:bg-neutral-950 pb-20">
    <div class="mx-auto max-w-[1280px] px-4 sm:px-6 py-8">

        {{-- Breadcrumbs --}}
        <nav aria-label="breadcrumb"
            class="flex items-center gap-1.5 text-sm text-neutral-500 dark:text-neutral-400 mb-6">
            <a href="{{ route('home') }}" class="hover:text-primary transition-colors">{{ __('Inicio') }}</a>
            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
            </svg>
            <a href="{{ route('properties.index') }}"
                class="hover:text-primary transition-colors">{{ __('Propiedades') }}</a>
            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
            </svg>
            <span
                class="text-neutral-700 dark:text-neutral-200 font-medium truncate max-w-[200px]">{{ $property->title }}</span>
        </nav>

        <div class="flex flex-col lg:flex-row gap-8">

            {{--  LEFT — Main content  --}}
            <div class="flex-1 min-w-0">

                {{--  Header: title, price, badges  --}}
                <div class="mb-6">
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                        <div>
                            {{-- Deal type + Property code badges --}}
                            <div class="flex items-center flex-wrap gap-2 mb-3">
                                @php
                                    $dealLabel = $property->deal_type->value === 'rent' ? __('Alquiler') : __('Venta');
                                    // Using light green for rent, primary for sale
                                    $dealBadge =
                                        $property->deal_type->value === 'rent'
                                            ? 'bg-[#73F3A6] text-neutral-900'
                                            : 'bg-primary text-white';
                                @endphp
                                <span
                                    class="{{ $dealBadge }} text-sm font-semibold px-3 py-1 rounded-md">{{ $dealLabel }}</span>
                                @if ($property->propertyType)
                                    <span
                                        class="bg-neutral-100 dark:bg-neutral-800 text-neutral-700 dark:text-neutral-200 text-sm font-medium px-3 py-1 rounded-md">
                                        {{ $property->propertyType->name }}
                                    </span>
                                @endif
                                @if ($property->property_code)
                                    <span
                                        class="font-mono text-xs bg-neutral-100 dark:bg-neutral-800 text-neutral-500 dark:text-neutral-400 border border-neutral-200 dark:border-neutral-700 px-3 py-1 rounded-md">
                                        {{ $property->property_code }}
                                    </span>
                                @endif
                            </div>

                            <h1 class="text-2xl lg:text-3xl font-bold text-neutral-900 dark:text-white leading-tight">
                                {{ $property->title }}
                            </h1>
                        </div>

                        {{-- Price --}}
                        <div class="text-left sm:text-right shrink-0 mt-2 sm:mt-0">
                            <div class="flex items-baseline gap-1 sm:justify-end">
                                <span class="text-3xl font-bold text-neutral-900 dark:text-white">
                                    {{ number_format($property->price, 0, ',', '.') }} €
                                </span>
                                @if ($property->deal_type->value === 'rent')
                                    <span
                                        class="text-base font-medium text-neutral-500 dark:text-neutral-400">{{ __('/mes') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <hr class="my-6 border-neutral-200 dark:border-neutral-800" />

                    {{-- Features & Actions --}}
                    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-6">
                        <div>
                            <span
                                class="text-sm text-neutral-500 dark:text-neutral-400 mb-3 block">{{ __('Características principales:') }}</span>
                            <div class="flex items-center gap-6">
                                {{-- Bedrooms --}}
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-neutral-900 dark:text-white" viewBox="0 0 23 17"
                                        fill="none">
                                        <path
                                            d="M18.75 3H1.5V0.75C1.5 0.551088 1.42098 0.360322 1.28033 0.21967C1.13968 0.0790178 0.948912 0 0.75 0C0.551088 0 0.360322 0.0790178 0.21967 0.21967C0.0790176 0.360322 0 0.551088 0 0.75V15.75C0 15.9489 0.0790176 16.1397 0.21967 16.2803C0.360322 16.421 0.551088 16.5 0.75 16.5C0.948912 16.5 1.13968 16.421 1.28033 16.2803C1.42098 16.1397 1.5 15.9489 1.5 15.75V12.75H21V15.75C21 15.9489 21.079 16.1397 21.2197 16.2803C21.3603 16.421 21.5511 16.5 21.75 16.5C21.9489 16.5 22.1397 16.421 22.2803 16.2803C22.421 16.1397 22.5 15.9489 22.5 15.75V6.75C22.5 5.75544 22.1049 4.80161 21.4016 4.09835C20.6984 3.39509 19.7446 3 18.75 3ZM1.5 4.5H8.25V11.25H1.5V4.5ZM9.75 11.25V4.5H18.75C19.3467 4.5 19.919 4.73705 20.341 5.15901C20.7629 5.58097 21 6.15326 21 6.75V11.25H9.75Z"
                                            fill="currentColor" />
                                    </svg>
                                    <span
                                        class="text-base font-semibold text-neutral-900 dark:text-white">{{ $property->bedrooms }}</span>
                                </div>
                                {{-- Bathrooms --}}
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-neutral-900 dark:text-white" viewBox="0 0 23 19"
                                        fill="none">
                                        <path
                                            d="M21 6.75003H18.75C18.75 6.55112 18.671 6.36036 18.5303 6.2197C18.3897 6.07905 18.1989 6.00003 18 6.00003H12C11.8011 6.00003 11.6103 6.07905 11.4697 6.2197C11.329 6.36036 11.25 6.55112 11.25 6.75003H5.25V2.62503C5.25 2.32667 5.36853 2.04052 5.5795 1.82954C5.79048 1.61856 6.07663 1.50003 6.375 1.50003C6.63867 1.49896 6.89493 1.58726 7.10196 1.75054C7.309 1.91382 7.4546 2.14244 7.515 2.3991C7.5562 2.59238 7.67202 2.76159 7.83729 2.86995C8.00255 2.97831 8.20391 3.01706 8.39759 2.97778C8.59127 2.9385 8.76162 2.82436 8.87162 2.66018C8.98161 2.49599 9.02236 2.29503 8.985 2.10097C8.85766 1.50417 8.52862 0.96945 8.05326 0.586804C7.5779 0.204157 6.98523 -0.00305707 6.375 3.40902e-05C5.67881 3.40902e-05 5.01113 0.276596 4.51884 0.768879C4.02656 1.26116 3.75 1.92884 3.75 2.62503V6.75003H1.5C1.10218 6.75003 0.720644 6.90807 0.43934 7.18937C0.158035 7.47068 0 7.85221 0 8.25003V11.25C0.00148896 12.642 0.55509 13.9765 1.53933 14.9607C2.52358 15.9449 3.85807 16.4985 5.25 16.5V18C5.25 18.1989 5.32902 18.3897 5.46967 18.5304C5.61032 18.671 5.80109 18.75 6 18.75C6.19891 18.75 6.38968 18.671 6.53033 18.5304C6.67098 18.3897 6.75 18.1989 6.75 18V16.5H15.75V18C15.75 18.1989 15.829 18.3897 15.9697 18.5304C16.1103 18.671 16.3011 18.75 16.5 18.75C16.6989 18.75 16.8897 18.671 17.0303 18.5304C17.171 18.3897 17.25 18.1989 17.25 18V16.5C18.6419 16.4985 19.9764 15.9449 20.9607 14.9607C21.9449 13.9765 22.4985 12.642 22.5 11.25V8.25003C22.5 7.85221 22.342 7.47068 22.0607 7.18937C21.7794 6.90807 21.3978 6.75003 21 6.75003ZM17.25 7.50003V10.5H12.75V7.50003H17.25ZM21 11.25C21 11.7425 20.903 12.2301 20.7145 12.6851C20.5261 13.1401 20.2499 13.5535 19.9016 13.9017C19.5534 14.2499 19.14 14.5261 18.6851 14.7146C18.2301 14.903 17.7425 15 17.25 15H5.25C4.25544 15 3.30161 14.6049 2.59835 13.9017C1.89509 13.1984 1.5 12.2446 1.5 11.25V8.25003H11.25V11.25C11.25 11.4489 11.329 11.6397 11.4697 11.7804C11.6103 11.921 11.8011 12 12 12H18C18.1989 12 18.3897 11.921 18.5303 11.7804C18.671 11.6397 18.75 11.4489 18.75 11.25V8.25003H21V11.25Z"
                                            fill="currentColor" />
                                    </svg>
                                    <span
                                        class="text-base font-semibold text-neutral-900 dark:text-white">{{ $property->bathrooms }}</span>
                                </div>
                                {{-- Area --}}
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-neutral-900 dark:text-white" viewBox="0 0 21 21"
                                        fill="none">
                                        <path
                                            d="M20.562 5.37821L15.6223 0.439461C15.483 0.300137 15.3176 0.189617 15.1356 0.114213C14.9536 0.03881 14.7585 0 14.5615 0C14.3645 0 14.1694 0.03881 13.9874 0.114213C13.8054 0.189617 13.64 0.300137 13.5007 0.439461L0.439461 13.4998C0.300137 13.6391 0.189617 13.8044 0.114213 13.9865C0.03881 14.1685 0 14.3635 0 14.5606C0 14.7576 0.03881 14.9526 0.114213 15.1347C0.189617 15.3167 0.300137 15.482 0.439461 15.6213L5.37915 20.5601C5.51844 20.6994 5.68381 20.8099 5.86582 20.8853C6.04784 20.9607 6.24292 20.9995 6.43993 20.9995C6.63694 20.9995 6.83202 20.9607 7.01403 20.8853C7.19604 20.8099 7.36142 20.6994 7.50071 20.5601L20.562 7.49977C20.7013 7.36048 20.8118 7.19511 20.8872 7.0131C20.9626 6.83108 21.0014 6.636 21.0014 6.43899C21.0014 6.24198 20.9626 6.0469 20.8872 5.86489C20.8118 5.68288 20.7013 5.5175 20.562 5.37821ZM6.43946 19.4998L1.50071 14.5601L4.50071 11.5601L6.97009 14.0304C7.03977 14.1001 7.12249 14.1554 7.21354 14.1931C7.30458 14.2308 7.40216 14.2502 7.50071 14.2502C7.59926 14.2502 7.69684 14.2308 7.78788 14.1931C7.87893 14.1554 7.96165 14.1001 8.03134 14.0304C8.10102 13.9607 8.15629 13.878 8.19401 13.7869C8.23172 13.6959 8.25113 13.5983 8.25113 13.4998C8.25113 13.4012 8.23172 13.3036 8.19401 13.2126C8.15629 13.1216 8.10102 13.0388 8.03134 12.9691L5.56102 10.4998L7.50071 8.56009L9.97009 11.0304C10.1108 11.1711 10.3017 11.2502 10.5007 11.2502C10.6997 11.2502 10.8906 11.1711 11.0313 11.0304C11.1721 10.8897 11.2511 10.6988 11.2511 10.4998C11.2511 10.3007 11.1721 10.1099 11.0313 9.96915L8.56102 7.49977L10.5007 5.56009L12.9701 8.0304C13.0398 8.10008 13.1225 8.15536 13.2135 8.19307C13.3046 8.23078 13.4022 8.25019 13.5007 8.25019C13.5993 8.25019 13.6968 8.23078 13.7879 8.19307C13.8789 8.15536 13.9617 8.10008 14.0313 8.0304C14.101 7.96072 14.1563 7.87799 14.194 7.78694C14.2317 7.6959 14.2511 7.59832 14.2511 7.49977C14.2511 7.40123 14.2317 7.30365 14.194 7.2126C14.1563 7.12156 14.101 7.03883 14.0313 6.96915L11.561 4.49977L14.561 1.49977L19.5007 6.43946L6.43946 19.4998Z"
                                            fill="currentColor" />
                                    </svg>
                                    <span
                                        class="text-base font-semibold text-neutral-900 dark:text-white">{{ $property->area_total }}
                                        m²</span>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            {{-- Compare Button --}}
                            <button
                                class="w-12 h-12 flex items-center justify-center border border-neutral-200 dark:border-neutral-700 rounded-md hover:bg-neutral-50 dark:hover:bg-neutral-800 transition-colors text-neutral-600 dark:text-neutral-300">
                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M7.5 21 3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5" />
                                </svg>
                            </button>
                            {{-- Favorite Button --}}
                            @auth
                                @php
                                    // Cache user favorites for this request
                                    static $userFavIds = null;
                                    if ($userFavIds === null) {
                                        $userFavIds = auth()
                                            ->user()
                                            ->favorites()
                                            ->pluck('property_user_favorites.property_id');
                                    }
                                    $isFav = $userFavIds->contains($property->id);
                                @endphp
                                <div x-data="favoriteButton({
                                    url: '{{ route('user.favorites.toggle', $property) }}',
                                    isFav: {{ $isFav ? 'true' : 'false' }}
                                })">
                                    <button type="button" :disabled="loading" @click="toggle()"
                                        class="w-12 h-12 flex items-center justify-center border border-neutral-200 dark:border-neutral-700 rounded-md hover:bg-neutral-50 dark:hover:bg-neutral-800 transition-colors text-neutral-600 dark:text-neutral-300">
                                        <svg class="w-5 h-5 transition-all duration-200" xmlns="http://www.w3.org/2000/svg"
                                            :fill="fav ? '#ef4444' : 'none'" :stroke="fav ? '#ef4444' : 'currentColor'"
                                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                            viewBox="0 0 24 24">
                                            <path
                                                d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z" />
                                        </svg>
                                    </button>
                                </div>
                            @else
                                <button type="button" x-data
                                    @click="$store.toast.show('{{ __('Regístrate o inicia sesión para guardar favoritos') }}', 'info')"
                                    class="w-12 h-12 flex items-center justify-center border border-neutral-200 dark:border-neutral-700 rounded-md hover:bg-neutral-50 dark:hover:bg-neutral-800 transition-colors text-neutral-600 dark:text-neutral-300">
                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" viewBox="0 0 24 24">
                                        <path
                                            d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z" />
                                    </svg>
                                </button>
                            @endauth
                            {{-- Share Button --}}
                            <button x-data
                                @click="navigator.share ? navigator.share({ title: '{{ addslashes($property->title) }}', url: window.location.href }) : $store.toast.show('{{ __('Enlace copiado') }}', 'success')"
                                class="w-12 h-12 flex items-center justify-center border border-neutral-200 dark:border-neutral-700 rounded-md hover:bg-neutral-50 dark:hover:bg-neutral-800 transition-colors text-neutral-600 dark:text-neutral-300">
                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M7.217 10.907a2.25 2.25 0 1 0 0 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186 9.566-5.314m-9.566 7.5 9.566 5.314m0 0a2.25 2.25 0 1 0 3.935 2.186 2.25 2.25 0 0 0-3.935-2.186Zm0-12.814a2.25 2.25 0 1 0 3.933-2.185 2.25 2.25 0 0 0-3.933 2.185Z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                {{--  Summary Icons (Resumen)  --}}
                <x-public.property.summary-icons :property="$property" />

                {{--  Description  --}}
                <x-public.property.description :description="$property->description" />

                {{--  Features (Utilidad de la vivienda)  --}}
                <x-public.property.amenities :features="$property->features" />

                {{--  Video  --}}
                <x-public.property.video :videoUrl="$property->video_url" />

                {{--  Mortgage Calculator  --}}
                <x-public.property.mortgage-calculator :property="$property" />

                {{--  Energy Certificate Rating  --}}
                <x-public.property.energy-rating :certificate="$property->energy_certificate" />

                {{--  Documents (public only)  --}}
                <x-public.property.documents :documents="$documents" />

                {{--  Floor Plans  --}}
                <x-public.property.floor-plans :floorPlans="$floorPlans" />

                {{--  Map placeholder  --}}
                <x-public.property.location :property="$property" />

                {{--  Nearby Places  --}}
                <x-public.property.nearby-places />

            </div>
            {{-- /main content --}}

            {{--  RIGHT — Sidebar  --}}
            <aside class="w-full lg:w-[340px] shrink-0 space-y-5">

                {{--  Contact card  --}}
                <x-public.property.agent-card :property="$property" :sticky="!$property->agency_id" />

                {{-- Contact Form — only for agency listings --}}
                @if ($property->agency_id)
                    <div class="sticky top-24">
                        <x-public.property.contact-form :property="$property" />
                    </div>
                @endif

            </aside>{{-- /sidebar --}}
        </div>{{-- /flex --}}

        {{--  RELATED PROPERTIES  --}}
        @if ($relatedProperties->isNotEmpty())
            <section class="mt-14">
                <h2 class="text-2xl font-extrabold text-neutral-900 dark:text-white mb-6">
                    {{ __('Propiedades similares') }}</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($relatedProperties as $related)
                        <x-public.property.card :property="$related" />
                    @endforeach
                </div>
            </section>
        @endif

    </div>
</div>


@endsection
