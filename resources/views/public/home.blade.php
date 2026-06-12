@extends('layouts.public')

@section('content')

    {{-- 1. HERO --}}
    <div class="relative w-full min-h-[680px] md:min-h-[760px] bg-neutral-800 overflow-hidden">
        @if (isset($heroProperty) && $heroProperty?->getFirstMediaUrl('photos', 'large'))
            <img src="{{ $heroProperty->getFirstMediaUrl('photos', 'large') }}" alt="Hero"
                class="absolute inset-0 w-full h-full object-cover opacity-70">
        @else
            <img src="https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=1920&q=80" alt="Hero"
                class="absolute inset-0 w-full h-full object-cover opacity-70">
        @endif
        <div class="absolute inset-0 bg-linear-to-b from-neutral-900/40 via-neutral-900/20 to-neutral-900/60"></div>

        <div
            class="relative z-10 h-full max-w-7xl mx-auto px-6 lg:px-10 flex flex-col lg:flex-row items-end lg:items-center justify-center lg:justify-between pb-16 pt-36 lg:pt-40 gap-8">
            <div class="text-white max-w-xl lg:max-w-2xl">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold leading-tight mb-4 text-white">
                    {!! __('Encuentra la casa<br>de tus sueños<br>en España') !!}
                </h1>
                <p class="text-lg text-white/80 max-w-md">
                    {{ __('Exclusivas propiedades, chalets y pisos con las mejores agencias del mercado.') }}
                </p>
            </div>

            @if (isset($heroProperty) && $heroProperty)
                <div class="w-full lg:w-96 shrink-0">
                    <div class="bg-white dark:bg-neutral-800 rounded-2xl overflow-hidden shadow-2xl">
                        <div class="relative h-52 bg-neutral-200 dark:bg-neutral-700 overflow-hidden">
                            @php $cardPhoto = $heroProperty->getFirstMediaUrl('photos', 'thumb'); @endphp
                            @if ($cardPhoto)
                                <img src="{{ $cardPhoto }}" alt="{{ $heroProperty->title }}"
                                    class="w-full h-full object-cover">
                            @endif
                            <div class="absolute top-3 left-3 flex gap-2">
                                <span class="bg-primary text-white text-xs font-semibold px-3 py-1 rounded">
                                    {{ $heroProperty->deal_type->value === 'rent' ? __('Alquiler') : __('Venta') }}
                                </span>
                                @if ($heroProperty->propertyType)
                                    <span class="bg-neutral-900 text-white text-xs font-medium px-3 py-1 rounded">
                                        {{ $heroProperty->propertyType->name }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="p-5">
                            <div class="flex items-baseline gap-1 mb-1">
                                <span class="text-3xl font-bold text-neutral-900 dark:text-white">
                                    {{ number_format($heroProperty->price, 0, ',', '.') }} €
                                </span>
                                @if ($heroProperty->deal_type->value === 'rent')
                                    <span class="text-sm text-neutral-500 dark:text-neutral-400">{{ __('/mes') }}</span>
                                @endif
                            </div>
                            <h3 class="text-lg font-semibold text-neutral-900 dark:text-white mb-1">
                                {{ $heroProperty->title }}</h3>
                            <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-4 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                    stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                {{ $heroProperty->address_line ?? $heroProperty->city }}, {{ $heroProperty->province }}
                            </p>
                            <div
                                class="flex items-center gap-5 pb-4 mb-4 border-b border-neutral-100 dark:border-neutral-700">
                                <div class="flex items-center gap-1.5">
                                    <x-public.icon src="{{ asset('images/icons/bed.svg') }}" class="w-5 h-5"
                                        alt="{{ __('Dormitorios') }}" />
                                    <span
                                        class="text-lg font-semibold text-neutral-800 dark:text-neutral-200">{{ $heroProperty->bedrooms }}</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <x-public.icon src="{{ asset('images/icons/bath.svg') }}" class="w-5 h-5"
                                        alt="{{ __('Baños') }}" />
                                    <span
                                        class="text-lg font-semibold text-neutral-800 dark:text-neutral-200">{{ $heroProperty->bathrooms }}</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <x-public.icon src="{{ asset('images/icons/area.svg') }}" class="w-5 h-5"
                                        alt="{{ __('Superficie') }}" />
                                    <span
                                        class="text-lg font-semibold text-neutral-800 dark:text-neutral-200">{{ $heroProperty->area_total }}
                                        m²</span>
                                </div>
                            </div>
                            <a href="{{ route('properties.show', ['slug' => $heroProperty->slug]) }}"
                                class="flex items-center justify-center gap-2 w-full bg-primary hover:bg-primary-content text-white font-semibold py-3 rounded-lg transition-colors">
                                {{ __('Ver propiedad') }}
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 20 20">
                                    <path
                                        d="M15.63 5v8.13a.63.63 0 01-1.25 0V6.51L5.44 15.44a.63.63 0 01-.88-.88L13.49 5.63H6.88a.63.63 0 010-1.26H15a.63.63 0 01.63.63z"
                                        fill="white" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>


    {{-- 2. SEARCH BAR — shared filter-bar component --}}
    <div class="bg-white dark:bg-neutral-900 shadow-md">
        <div class="max-w-7xl mx-auto px-6 lg:px-10 py-4">
            <x-public.search.filter-bar deal-type="sale" :cities="$cities ?? []" :max-bedrooms="$maxBedrooms ?? 5" :max-bathrooms="$maxBathrooms ?? 4"
                :filters-available-sale="$filtersAvailableSale ?? []" :filters-available-rent="$filtersAvailableRent ?? []" />
        </div>
    </div>


    {{-- 3. ABOUT --}}
    <section id="nosotros" class="py-20 lg:py-28 bg-neutral-50 dark:bg-neutral-900">
        <div class="max-w-7xl mx-auto px-6 lg:px-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-24 items-start">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.2em] text-primary mb-4">{{ __('Sobre NidoReal') }}
                    </p>
                    <h2 class="text-4xl lg:text-5xl font-extrabold text-neutral-900 dark:text-white leading-tight mb-6">
                        {{ __('Conectamos personas con oportunidades inmobiliarias.') }}
                    </h2>
                    <p class="text-lg text-neutral-600 dark:text-neutral-400 leading-relaxed mb-8 max-w-lg">
                        {{ __('Encontramos el hogar perfecto para ti. Contamos con un amplio catálogo de propiedades y agencias profesionales dispuestas a ayudarte en cada paso del proceso, desde la primera visita hasta la firma de escrituras.') }}
                    </p>
                    <a href="{{ route('properties.index') }}"
                        class="inline-flex items-center gap-2 bg-primary hover:bg-primary-content text-white font-bold px-8 py-4 rounded-xl transition-colors">
                        {{ __('Ver propiedades') }}
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 20 20">
                            <path
                                d="M15.63 5v8.13a.63.63 0 01-1.25 0V6.51L5.44 15.44a.63.63 0 01-.88-.88L13.49 5.63H6.88a.63.63 0 010-1.26H15A.63.63 0 0115.63 5z"
                                fill="white" />
                        </svg>
                    </a>
                </div>
                <div class="space-y-8">
                    @foreach ([['01', __('Comprar una vivienda'), __('Encuentra tu hogar ideal de forma sencilla. Explora una amplia selección de propiedades y accede a anuncios claros que facilitan una experiencia de compra fluida y segura.')], ['02', __('Alquilar una vivienda'), __('Descubre el alquiler perfecto sin complicaciones. Navega por una gran variedad de anuncios adaptados a tu estilo de vida y necesidades.')], ['03', __('Vender una vivienda'), __('Publica tu propiedad con confianza. Conecta con compradores interesados y destaca las mejores características de tu inmueble para lograr una venta exitosa.')]] as [$num, $title, $desc])
                        <div class="flex gap-6 items-start">
                            <span
                                class="text-3xl font-black text-primary leading-none shrink-0">{{ $num }}.</span>
                            <div>
                                <h4 class="text-2xl font-bold text-neutral-900 dark:text-white mb-2">{{ $title }}
                                </h4>
                                <p class="text-neutral-600 dark:text-neutral-400 leading-relaxed">{{ $desc }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>


    {{-- 4. STATS --}}
    <section class="bg-neutral-50 dark:bg-neutral-900 pb-20 lg:pb-28">
        <div class="max-w-7xl mx-auto px-6 lg:px-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 rounded-2xl overflow-hidden
                        border border-neutral-200 dark:border-neutral-700 shadow-md">
                <div class="h-72 lg:h-auto">
                    <img src="https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=900&q=80" alt="Interior"
                        class="w-full h-full object-cover">
                </div>
                {{-- Tile grid --}}
                <div class="grid grid-cols-2 h-full [grid-auto-rows:1fr]
                            border-l border-neutral-200 dark:border-neutral-700">
                    @php
                        $statItems = [
                            [asset('images/icons/home.svg'),     $stats['properties'] ?? 0,       __('Propiedades'),       true],
                            [asset('images/icons/agency.svg'),   $stats['agencies'] ?? 0,          __('Agencias'),          true],
                            [asset('images/icons/location.svg'), $stats['cities'] ?? 0,            __('Ciudades'),          false],
                            [asset('images/icons/star.svg'),     '99%',                            __('Clientes felices'),  false],
                            [asset('images/icons/tag.svg'),      $stats['properties_sale'] ?? 0,   __('En venta'),          true],
                            [asset('images/icons/key.svg'),      $stats['properties_rent'] ?? 0,   __('En alquiler'),       true],
                            [asset('images/icons/diamond.svg'),  $stats['featured'] ?? 0,          __('Destacadas'),        false],
                            [asset('images/icons/time.svg'),     $stats['new_this_month'] ?? 0,    __('Nuevas este mes'),   false],
                        ];
                    @endphp
                    @foreach ($statItems as [$icon, $num, $label, $plus])
                        <div class="group flex items-center gap-3 p-5 lg:p-6 cursor-default
                                    border-b border-r border-neutral-200 dark:border-neutral-700
                                    transition-colors duration-200
                                    hover:bg-primary/[0.06] dark:hover:bg-primary/[0.10]">
                            {{-- Icon --}}
                            <div class="shrink-0 w-11 h-11 rounded-xl flex items-center justify-center
                                        bg-primary/10 dark:bg-primary/15
                                        group-hover:bg-primary/20 dark:group-hover:bg-primary/25
                                        transition-colors duration-200">
                                <x-public.icon :src="$icon"
                                    class="w-5 h-5 text-primary transition-transform duration-200 group-hover:scale-125"
                                    :alt="$label" />
                            </div>
                            {{-- Text --}}
                            <div class="min-w-0">
                                <div class="text-2xl font-black leading-none mb-0.5
                                            text-neutral-900 dark:text-white
                                            group-hover:text-primary dark:group-hover:text-primary
                                            transition-colors duration-200">
                                    {{ is_numeric($num) ? number_format($num, 0, ',', '.') : $num }}{{ $plus ? '+' : '' }}
                                </div>
                                <div class="text-[11px] font-semibold uppercase tracking-widest truncate
                                            text-neutral-500 dark:text-neutral-400">
                                    {{ $label }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>


    {{-- 5. FEATURED --}}
    <section class="py-20 lg:py-28 bg-white dark:bg-neutral-950 border-y border-neutral-100 dark:border-neutral-800">
        <div class="max-w-7xl mx-auto px-6 lg:px-10">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-6 mb-12">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.2em] text-primary mb-3">{{ __('Destacados') }}</p>
                    <h2 class="text-4xl font-extrabold text-neutral-900 dark:text-white leading-tight">
                        {!! __('Encuentre la casa<br>de sus sueños') !!}
                    </h2>
                </div>
                <a href="{{ route('properties.index', ['is_featured' => 1]) }}"
                    class="shrink-0 border-2 border-neutral-200 dark:border-neutral-700 hover:border-primary text-neutral-800 dark:text-neutral-200 hover:text-primary font-bold px-6 py-3 rounded-xl transition-colors text-sm">
                    {{ __('Ver todas') }} →
                </a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                @forelse($featuredProperties ?? [] as $property)
                    <x-public.property.card :property="$property" />
                @empty
                    <div class="col-span-4 text-center py-16 text-neutral-400">{{ __('No hay propiedades destacadas.') }}
                    </div>
                @endforelse
            </div>
        </div>
    </section>


    {{-- 6. WHY US --}}
    <section class="py-20 lg:py-28 bg-neutral-50 dark:bg-neutral-900">
        <div class="max-w-7xl mx-auto px-6 lg:px-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                <div class="lg:col-span-5 flex items-center justify-center">
                    <div class="relative text-center">
                        <div
                            class="text-[160px] lg:text-[200px] font-black text-neutral-200 dark:text-neutral-800 leading-none select-none tracking-tighter">
                            100</div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div
                                class="bg-white dark:bg-neutral-800 border border-neutral-100 dark:border-neutral-700 rounded-2xl px-7 py-5 shadow-xl text-center -rotate-3">
                                <div class="text-2xl font-black text-neutral-900 dark:text-white leading-snug">
                                    {!! __('Nuevas<br>casas') !!}</div>
                                <div class="text-xs uppercase tracking-widest text-neutral-400 mt-1">
                                    {{ __('cada semana') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="lg:col-span-7 lg:pl-10">
                    <p class="text-xs font-bold uppercase tracking-[0.2em] text-primary mb-4">
                        {{ __('Por qué elegirnos') }}</p>
                    <h2 class="text-3xl lg:text-4xl font-extrabold text-neutral-900 dark:text-white leading-tight mb-4">
                        {!! __('Descubre la diferencia<br>de nuestra plataforma') !!}
                    </h2>
                    <p class="text-neutral-600 dark:text-neutral-400 mb-8 text-lg">
                        {{ __('Hacemos que el proceso de buscar, comprar o alquilar una vivienda sea lo más sencillo y transparente posible para ti.') }}
                    </p>
                    @php
                        $whyItems = [
                            [
                                asset('images/icons/help.svg'),
                                __('Atención personalizada'),
                                __(
                                    'Las agencias en nuestra plataforma te acompañan durante todo el proceso, solucionando todas tus dudas al instante.',
                                ),
                            ],
                            [
                                asset('images/icons/time.svg'),
                                __('Ahorro de tiempo'),
                                __(
                                    'Busca de forma eficiente con nuestros filtros avanzados y encuentra solo lo que realmente se ajusta a tus necesidades.',
                                ),
                            ],
                            [
                                asset('images/icons/diamond.svg'),
                                __('Experiencia cómoda'),
                                __(
                                    'Disfruta de una navegación fluida, diseño moderno y adaptado a cualquier dispositivo móvil para buscar desde donde quieras.',
                                ),
                            ],
                        ];
                    @endphp
                    <ul class="mb-8 divide-y divide-neutral-100 dark:divide-neutral-800">
                        @foreach ($whyItems as [$icon, $title, $desc])
                            <li class="flex items-start gap-5 py-6 first:pt-0 last:pb-0">
                                <x-public.icon :src="$icon" class="w-10 h-10 mt-0.5 text-primary" :alt="$title" />
                                <div>
                                    <h4 class="text-xl font-bold text-neutral-900 dark:text-white mb-1.5">
                                        {{ $title }}</h4>
                                    <p class="text-neutral-600 dark:text-neutral-400 leading-relaxed text-sm max-w-sm">
                                        {{ $desc }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    <a href="{{ route('properties.index') }}"
                        class="inline-flex items-center gap-2 bg-primary hover:bg-primary-content text-white font-bold px-8 py-4 rounded-xl transition-colors">
                        {{ __('Empezar a buscar') }}
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 20 20">
                            <path
                                d="M15.63 5v8.13a.63.63 0 01-1.25 0V6.51L5.44 15.44a.63.63 0 01-.88-.88L13.49 5.63H6.88a.63.63 0 010-1.26H15A.63.63 0 0115.63 5z"
                                fill="white" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>


    {{-- 7. LATEST --}}
    <section class="py-20 lg:py-28 bg-white dark:bg-neutral-950 border-t border-neutral-100 dark:border-neutral-800">
        <div class="max-w-7xl mx-auto px-6 lg:px-10">
            <div class="text-center mb-12">
                <p class="text-xs font-bold uppercase tracking-[0.2em] text-primary mb-3">{{ __('Nuevos ingresos') }}</p>
                <h2 class="text-4xl font-extrabold text-neutral-900 dark:text-white">{{ __('Últimas actualizaciones') }}
                </h2>
            </div>
            <div class="flex flex-col gap-5 max-w-5xl mx-auto">
                @forelse($latestProperties ?? [] as $property)
                    @php
                        $photos = $property->getMedia('photos');
                        $photo1 = $photos->get(0)?->getUrl('thumb');
                        $photo2 = $photos->get(1)?->getUrl('thumb');
                        $photo3 = $photos->get(2)?->getUrl('thumb');
                    @endphp
                    <div
                        class="bg-white dark:bg-neutral-800 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-shadow flex flex-col sm:flex-row">
                        <div class="w-full sm:w-2/5 grid grid-cols-2 min-h-[200px] sm:min-h-0">
                            <div class="row-span-2 bg-neutral-200 dark:bg-neutral-700 overflow-hidden">
                                @if ($photo1)
                                    <img src="{{ $photo1 }}" alt="" class="w-full h-full object-cover">
                                @endif
                            </div>
                            <div class="bg-neutral-300 dark:bg-neutral-600 overflow-hidden">
                                @if ($photo2)
                                    <img src="{{ $photo2 }}" alt="" class="w-full h-full object-cover">
                                @endif
                            </div>
                            <div class="bg-neutral-200 dark:bg-neutral-700 overflow-hidden">
                                @if ($photo3)
                                    <img src="{{ $photo3 }}" alt="" class="w-full h-full object-cover">
                                @endif
                            </div>
                        </div>
                        <div class="flex-1 p-6 flex flex-col justify-between">
                            <div>
                                <div class="flex flex-wrap items-start justify-between gap-3 mb-2">
                                    <a href="{{ route('properties.show', ['slug' => $property->slug]) }}"
                                        class="text-xl font-bold text-neutral-900 dark:text-white hover:text-primary transition-colors">
                                        {{ $property->title }}
                                    </a>
                                    <span
                                        class="text-xl font-bold text-primary shrink-0">{{ number_format($property->price, 0, ',', '.') }}
                                        €</span>
                                </div>
                                <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-4 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    {{ $property->city }}, {{ $property->province }}
                                </p>
                                <div
                                    class="flex items-center gap-5 text-sm font-semibold text-neutral-700 dark:text-neutral-300">
                                    <span class="flex items-center gap-1.5">
                                        <x-public.icon src="{{ asset('images/icons/bed.svg') }}" class="w-4 h-4"
                                            alt="{{ __('Dormitorios') }}" />
                                        {{ $property->bedrooms }} {{ __('dorms') }}
                                    </span>
                                    <span class="text-neutral-300 dark:text-neutral-600">·</span>
                                    <span class="flex items-center gap-1.5">
                                        <x-public.icon src="{{ asset('images/icons/bath.svg') }}" class="w-4 h-4"
                                            alt="{{ __('Baños') }}" />
                                        {{ $property->bathrooms }} {{ __('baños') }}
                                    </span>
                                    <span class="text-neutral-300 dark:text-neutral-600">·</span>
                                    <span class="flex items-center gap-1.5">
                                        <x-public.icon src="{{ asset('images/icons/area.svg') }}" class="w-4 h-4"
                                            alt="{{ __('Superficie') }}" />
                                        {{ $property->area_total }} m²
                                    </span>
                                </div>
                            </div>
                            <div class="pt-4 mt-4 border-t border-neutral-100 dark:border-neutral-700 flex justify-end">
                                <a href="{{ route('properties.show', ['slug' => $property->slug]) }}"
                                    class="bg-primary hover:bg-primary-content text-white font-semibold px-6 py-2.5 rounded-lg transition-colors text-sm">
                                    {{ __('Ver más') }} →
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-neutral-400 py-12">{{ __('No hay actualizaciones recientes.') }}</p>
                @endforelse
            </div>
        </div>
    </section>


    {{-- 8. TESTIMONIALS --}}
    <section class="py-20 lg:py-28 bg-neutral-50 dark:bg-neutral-900">
        <div class="max-w-7xl mx-auto px-6 lg:px-10">
            <div class="text-center mb-14">
                <p class="text-xs font-bold uppercase tracking-[0.2em] text-primary mb-3">{{ __('Testimonios') }}</p>
                <h2 class="text-4xl font-extrabold text-neutral-900 dark:text-white">
                    {{ __('Lo que dicen nuestros clientes') }}</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ([['María Domínguez', 'Madrid', __('«NidoReal hizo que encontrar mi primer piso fuera una experiencia increíble. La plataforma es muy fácil de usar y pude organizar visitas rápidamente.»')], ['Carlos López', 'Barcelona', __('«Vendimos nuestra casa en un tiempo récord gracias a la visibilidad que nos dio la plataforma. Muy recomendada para vendedores y agencias.»')], ['Laura Fernández', 'Valencia', __('«Los filtros avanzados son fantásticos. Solo veía propiedades que realmente encajaban con mi presupuesto y requisitos de espacio.»')]] as [$name, $city, $text])
                    <div
                        class="bg-white dark:bg-neutral-800 border border-neutral-100 dark:border-neutral-700 rounded-2xl p-8 shadow-sm">
                        <div class="flex text-accent gap-0.5 mb-5 text-lg">★★★★★</div>
                        <p class="text-neutral-700 dark:text-neutral-300 italic leading-relaxed mb-6 text-sm">
                            {{ $text }}</p>
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-full bg-primary/10 dark:bg-primary/20 flex items-center justify-center font-bold text-primary text-sm">
                                {{ implode('', array_map(fn($w) => $w[0], explode(' ', $name))) }}
                            </div>
                            <div>
                                <div class="font-bold text-neutral-900 dark:text-white text-sm">{{ $name }}</div>
                                <div class="text-xs text-neutral-400">{{ $city }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>


    {{-- 9. BY TYPE --}}
    <section class="py-20 lg:py-28 bg-white dark:bg-neutral-950 border-t border-neutral-100 dark:border-neutral-800">
        <div class="max-w-7xl mx-auto px-6 lg:px-10">
            <div class="text-center mb-12">
                <p class="text-xs font-bold uppercase tracking-[0.2em] text-primary mb-3">{{ __('Categorías') }}</p>
                <h2 class="text-4xl font-extrabold text-neutral-900 dark:text-white">{{ __('Propiedades por tipo') }}</h2>
            </div>
            <div
                class="flex md:grid overflow-x-auto md:overflow-x-visible gap-5 pb-4 md:pb-0 scrollbar-hide snap-x md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
                @foreach ($propertyTypes ?? [] as $type)
                    @php
                        $imageName = strtolower($type->name_en);
                        $imagePath = 'images/types/' . $imageName . '.png';
                        $hasImage = file_exists(public_path($imagePath));
                    @endphp
                    <a href="{{ route('properties.index', ['type' => $type->id]) }}"
                        class="group relative w-56 md:w-auto h-72 shrink-0 md:shrink snap-start rounded-2xl overflow-hidden shadow-sm">
                        @if ($hasImage)
                            <img src="{{ asset($imagePath) }}" alt="{{ $type->name }}"
                                class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="absolute inset-0 bg-neutral-700 dark:bg-neutral-800"></div>
                        @endif
                        <div class="absolute inset-0 bg-linear-to-t from-neutral-900/80 via-neutral-900/20 to-transparent">
                        </div>
                        <div class="absolute inset-0 flex items-end p-5 z-10">
                            <div>
                                <h3 class="text-xl font-bold text-white mb-0.5">{{ $type->name }}</h3>
                                <p class="text-sm text-white/70 font-medium">
                                    {{ trans_choice('{0} 0 propiedades|{1} 1 propiedad|[2,*] :count propiedades', $type->properties_count ?? 0, ['count' => $type->properties_count ?? 0]) }}
                                </p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>


    {{-- 10. CONTACT --}}
    <section id="contacto" class="py-20 lg:py-28 bg-neutral-50 dark:bg-neutral-900">
        <div class="max-w-7xl mx-auto px-6 lg:px-10">
            <div
                class="bg-white dark:bg-neutral-800 rounded-3xl shadow-xl overflow-hidden grid grid-cols-1 lg:grid-cols-2">
                <div class="p-10 lg:p-16 flex flex-col justify-center">
                    <p class="text-xs font-bold uppercase tracking-[0.2em] text-primary mb-4">{{ __('Contacto') }}</p>
                    <h2 class="text-3xl lg:text-4xl font-extrabold text-neutral-900 dark:text-white mb-4 leading-tight">
                        {!! __('¿Necesita ayuda?<br>Le llamaremos.') !!}
                    </h2>
                    <p class="text-neutral-600 dark:text-neutral-400 text-lg mb-8 leading-relaxed">
                        {{ __('Un profesional inmobiliario de nuestra red se pondrá en contacto con usted para asesorarle sin compromiso.') }}
                    </p>
                    <div class="space-y-5">
                        <div class="flex items-center gap-4">
                            <div
                                class="w-12 h-12 bg-primary/10 dark:bg-primary/20 rounded-full flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-primary" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                                </svg>
                            </div>
                            <div>
                                <div class="text-xs font-bold uppercase tracking-widest text-neutral-400">
                                    {{ __('Llámenos') }}</div>
                                <div class="text-lg font-bold text-neutral-900 dark:text-white">+34 900 123 456</div>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <div
                                class="w-12 h-12 bg-primary/10 dark:bg-primary/20 rounded-full flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-primary" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                                </svg>
                            </div>
                            <div>
                                <div class="text-xs font-bold uppercase tracking-widest text-neutral-400">Email</div>
                                <div class="text-lg font-bold text-neutral-900 dark:text-white">hola@nidoreal.com</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="bg-neutral-50 dark:bg-neutral-900 border-l border-neutral-100 dark:border-neutral-700 p-10 lg:p-16">
                    <form action="#" method="POST" class="space-y-5">
                        @csrf
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label
                                    class="block text-sm font-semibold text-neutral-800 dark:text-neutral-200 mb-1.5">{{ __('Nombre *') }}</label>
                                <input type="text" name="name" required placeholder="{{ __('Tu nombre') }}"
                                    class="w-full px-4 py-3 bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl text-sm text-neutral-900 dark:text-white outline-none focus:border-primary transition-colors placeholder-neutral-400">
                            </div>
                            <div>
                                <label
                                    class="block text-sm font-semibold text-neutral-800 dark:text-neutral-200 mb-1.5">{{ __('Apellidos') }}</label>
                                <input type="text" name="last_name" placeholder="{{ __('Tus apellidos') }}"
                                    class="w-full px-4 py-3 bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl text-sm text-neutral-900 dark:text-white outline-none focus:border-primary transition-colors placeholder-neutral-400">
                            </div>
                        </div>
                        <div>
                            <label
                                class="block text-sm font-semibold text-neutral-800 dark:text-neutral-200 mb-1.5">{{ __('Teléfono *') }}</label>
                            <input type="tel" name="phone" required placeholder="+34 600 000 000"
                                class="w-full px-4 py-3 bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl text-sm text-neutral-900 dark:text-white outline-none focus:border-primary transition-colors placeholder-neutral-400">
                        </div>
                        <div>
                            <label
                                class="block text-sm font-semibold text-neutral-800 dark:text-neutral-200 mb-1.5">{{ __('Tipo de consulta *') }}</label>
                            <select name="subject" required
                                class="w-full px-4 py-3 bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl text-sm text-neutral-900 dark:text-white outline-none focus:border-primary transition-colors">
                                <option value="">{{ __('Selecciona un asunto...') }}</option>
                                <option value="buy">{{ __('Quiero comprar una propiedad') }}</option>
                                <option value="rent">{{ __('Quiero alquilar una propiedad') }}</option>
                                <option value="sell">{{ __('Quiero vender mi propiedad') }}</option>
                                <option value="other">{{ __('Otras consultas') }}</option>
                            </select>
                        </div>
                        <p class="text-xs text-neutral-400 leading-relaxed">
                            {{ __('Al enviar confirmas que aceptas nuestra') }} <a href="#"
                                class="text-primary hover:underline">{{ __('Política de Privacidad') }}</a>.
                        </p>
                        <button type="submit"
                            class="w-full bg-accent hover:bg-accent/90 text-white font-bold py-4 rounded-xl transition-colors">
                            {{ __('Llamarme') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection
