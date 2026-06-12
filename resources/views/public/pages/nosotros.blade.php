@extends('layouts.public')

@section('title', __('Sobre Nosotros — NidoReal'))
@section('description', __('Conoce al equipo y la misión de NidoReal, el portal inmobiliario que conecta compradores,
    arrendatarios y las mejores agencias de toda España.'))

@section('content')

    {{-- HERO --}}
    <div class="relative w-full min-h-[680px] md:min-h-[760px] bg-neutral-800 overflow-hidden flex items-center">
        <img src="{{ asset('images/heroes/nosotros.webp') }}" alt="{{ __('Sobre Nosotros') }}"
            class="absolute inset-0 w-full h-full object-cover pointer-events-none select-none" fetchpriority="high">
        <div class="absolute inset-0 bg-linear-to-b from-neutral-900/10 to-neutral-900/60"></div>

        <div
            class="relative z-10 w-full max-w-7xl mx-auto px-6 lg:px-10 pt-20 flex items-center min-h-[680px] md:min-h-[760px]">
            <div class="text-white max-w-2xl">
                <span
                    class="inline-flex items-center bg-primary text-white text-xs font-bold uppercase tracking-widest px-4 py-2 rounded-lg mb-4 shadow-sm">
                    {{ __('Conózcanos') }}
                </span>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold leading-tight mb-4 text-white">
                    {!! __('El portal inmobiliario<br>en el que puedes<br>confiar') !!}
                </h1>
                <p class="text-lg text-white/80 max-w-lg">
                    {{ __('Conectamos a las mejores agencias con personas que buscan el hogar de sus sueños en España. Transparencia, rigor y tecnología al servicio del comprador.') }}
                </p>
            </div>
        </div>
    </div>

    {{-- MISSION --}}
    <section class="py-20 lg:py-28 bg-neutral-50 dark:bg-neutral-900">
        <div class="max-w-7xl mx-auto px-6 lg:px-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-24 items-start">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.2em] text-primary mb-4">{{ __('Nuestra misión') }}</p>
                    <h2 class="text-4xl lg:text-5xl font-extrabold text-neutral-900 dark:text-white leading-tight mb-6">
                        {{ __('Hacemos que encontrar tu hogar sea simple.') }}
                    </h2>
                    <p class="text-lg text-neutral-600 dark:text-neutral-400 leading-relaxed mb-6 max-w-lg">
                        {{ __('Creemos que el proceso de comprar, vender o alquilar una vivienda debe ser claro, ágil y sin sorpresas. Por eso reunimos en un solo lugar las mejores agencias certificadas y un catálogo actualizado de inmuebles en toda España.') }}
                    </p>
                    <p class="text-lg text-neutral-600 dark:text-neutral-400 leading-relaxed mb-8 max-w-lg">
                        {{ __('Desde la primera búsqueda hasta la firma de escrituras, nuestro equipo y nuestra plataforma están diseñados para acompañarte en cada paso y optimizar tu tiempo.') }}
                    </p>
                    <a href="{{ route('properties.index') }}"
                        class="inline-flex items-center gap-2 bg-primary hover:bg-primary-content text-white font-bold px-8 py-4 rounded-xl transition-colors">
                        {{ __('Explorar propiedades') }}
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 20 20">
                            <path
                                d="M15.63 5v8.13a.63.63 0 01-1.25 0V6.51L5.44 15.44a.63.63 0 01-.88-.88L13.49 5.63H6.88a.63.63 0 010-1.26H15A.63.63 0 0115.63 5z"
                                fill="white" />
                        </svg>
                    </a>
                </div>
                <div class="space-y-8">
                    @foreach ([['01', __('Transparencia total'), __('Anuncios con información completa, fotos reales y contacto directo con la agencia. Sin letra pequeña.')], ['02', __('Agencias verificadas'), __('Solo colaboramos con agencias activas y profesionales que superan nuestros estándares de calidad y servicio.')], ['03', __('Tecnología al día'), __('Portal rápido, adaptado a móviles y con filtros avanzados para que encuentres exactamente lo que buscas.')]] as [$num, $title, $desc])
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

    {{-- STATS --}}
    <section class="bg-neutral-900 dark:bg-neutral-950 py-20 lg:py-24">
        <div class="max-w-7xl mx-auto px-6 lg:px-10">
            <div class="text-center mb-14">
                <p class="text-xs font-bold uppercase tracking-[0.2em] text-primary mb-3">{{ __('NidoReal en números') }}
                </p>
                <h2 class="text-3xl lg:text-4xl font-extrabold text-white">{{ __('Una plataforma con resultados reales') }}
                </h2>
            </div>
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach ([['2.500+', __('Inmuebles publicados'), 'heroicon-o-home-modern'], ['120+', __('Agencias colaboradoras'), 'heroicon-o-building-office-2'], ['85+', __('Ciudades cubiertas'), 'heroicon-o-map-pin'], ['99%', __('Clientes satisfechos'), 'heroicon-o-star']] as [$value, $label, $icon])
                    <div class="text-center">
                        <div class="w-14 h-14 bg-primary/10 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <x-dynamic-component :component="$icon" class="w-7 h-7 text-primary" />
                        </div>
                        <div class="text-4xl font-black text-white mb-1">{{ $value }}</div>
                        <div class="text-sm font-semibold text-neutral-400 uppercase tracking-widest">{{ $label }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- HOW IT WORKS --}}
    <section class="py-20 lg:py-28 bg-neutral-50 dark:bg-neutral-900">
        <div class="max-w-7xl mx-auto px-6 lg:px-10">
            <div class="text-center mb-16">
                <p class="text-xs font-bold uppercase tracking-[0.2em] text-primary mb-3">{{ __('Proceso') }}</p>
                <h2 class="text-3xl lg:text-4xl font-extrabold text-neutral-900 dark:text-white">
                    {{ __('¿Cómo funciona NidoReal?') }}</h2>
                <p class="mt-4 text-lg text-neutral-600 dark:text-neutral-400 max-w-2xl mx-auto">
                    {{ __('En tres pasos sencillos puedes pasar de buscar a firmar.') }}
                </p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative">
                {{-- Connector line (desktop) --}}
                <div class="hidden md:block absolute top-12 left-1/4 right-1/4 h-0.5 bg-neutral-200 dark:bg-neutral-700"
                    style="top:2.75rem; left:calc(16.66% + 2.5rem); right:calc(16.66% + 2.5rem);"></div>
                @foreach ([['01', 'heroicon-o-magnifying-glass', __('Busca y filtra'), __('Usa nuestros filtros avanzados para encontrar inmuebles por ciudad, precio, habitaciones, certificado energético y mucho más.')], ['02', 'heroicon-o-chat-bubble-left-right', __('Contacta con el agente'), __('Escribe o llama directamente al agente responsable del inmueble. Sin intermediarios innecesarios, sin comisiones ocultas.')], ['03', 'heroicon-o-key', __('Cierra el trato'), __('Visita la propiedad, negocia y firma con la seguridad de haber trabajado con profesionales verificados.')]] as [$step, $icon, $title, $desc])
                    <div
                        class="bg-white dark:bg-neutral-800 rounded-2xl border border-neutral-100 dark:border-neutral-700 p-8 shadow-sm text-center relative">
                        <div
                            class="w-14 h-14 bg-primary/10 dark:bg-primary/20 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <x-dynamic-component :component="$icon" class="w-7 h-7 text-primary" />
                        </div>
                        <span
                            class="inline-block text-xs font-black uppercase tracking-widest text-primary/60 mb-2">{{ __('Paso :step', ['step' => $step]) }}</span>
                        <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-3">{{ $title }}</h3>
                        <p class="text-neutral-600 dark:text-neutral-400 text-sm leading-relaxed">{{ $desc }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- TESTIMONIALS --}}
    <section class="py-20 lg:py-28 bg-white dark:bg-neutral-950 border-t border-neutral-100 dark:border-neutral-800">
        <div class="max-w-7xl mx-auto px-6 lg:px-10">
            <div class="text-center mb-14">
                <p class="text-xs font-bold uppercase tracking-[0.2em] text-primary mb-3">{{ __('Opiniones') }}</p>
                <h2 class="text-4xl font-extrabold text-neutral-900 dark:text-white">
                    {{ __('Lo que dicen nuestros usuarios') }}</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ([['María Domínguez', 'Madrid', __('«NidoReal hizo que encontrar mi primer piso fuera una experiencia increíble. La plataforma es muy fácil de usar y pude organizar visitas rápidamente.»')], ['Carlos López', 'Barcelona', __('«Vendimos nuestra casa en tempo récord gracias a la visibilidad que nos dio la plataforma. Muy recomendada para vendedores y agencias.»')], ['Laura Fernández', 'Valencia', __('«Los filtros avanzados son fantásticos. Solo veía propiedades que realmente encajaban con mi presupuesto y mis requisitos de espacio.»')]] as [$name, $city, $text])
                    <div
                        class="bg-neutral-50 dark:bg-neutral-900 border border-neutral-100 dark:border-neutral-800 rounded-2xl p-8 shadow-sm">
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

    {{-- CTA BANNER --}}
    <section class="bg-primary py-16 lg:py-20">
        <div class="max-w-7xl mx-auto px-6 lg:px-10 text-center">
            <h2 class="text-3xl lg:text-4xl font-extrabold text-white mb-4">{{ __('¿Eres una agencia inmobiliaria?') }}
            </h2>
            <p class="text-white/80 text-lg mb-8 max-w-xl mx-auto">
                {{ __('Únete a NidoReal y consigue visibilidad ante miles de compradores y arrendatarios en toda España. Elige el plan que mejor se adapte a tu negocio.') }}
            </p>
            <div class="flex flex-wrap items-center justify-center gap-4">
                <a href="{{ route('pages.tarifas') }}"
                    class="inline-flex items-center gap-2 bg-white text-primary font-bold px-8 py-4 rounded-xl hover:bg-neutral-100 transition-colors shadow-lg">
                    {{ __('Ver planes y tarifas') }}
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 20 20">
                        <path
                            d="M15.63 5v8.13a.63.63 0 01-1.25 0V6.51L5.44 15.44a.63.63 0 01-.88-.88L13.49 5.63H6.88a.63.63 0 010-1.26H15A.63.63 0 0115.63 5z"
                            fill="currentColor" />
                    </svg>
                </a>
                <a href="{{ route('pages.contacto') }}"
                    class="inline-flex items-center gap-2 border-2 border-white/40 text-white font-bold px-8 py-4 rounded-xl hover:bg-white/10 transition-colors">
                    {{ __('Hablar con el equipo') }}
                </a>
            </div>
        </div>
    </section>

@endsection
