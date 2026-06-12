@extends('layouts.public')

@section('title', __('Agencias Inmobiliarias — NidoReal'))
@section('description', __('Encuentra las mejores agencias inmobiliarias en España en NidoReal. Profesionales
    certificados para ayudarte a comprar, alquilar o vender tu vivienda.'))

@section('content')

    {{-- HERO --}}
    <div class="relative w-full min-h-[680px] md:min-h-[760px] bg-neutral-800 overflow-hidden flex items-center">
        <img src="{{ asset('images/heroes/agencias.webp') }}" alt="{{ __('Agencias de confianza') }}"
            class="absolute inset-0 w-full h-full object-cover pointer-events-none select-none" fetchpriority="high">
        <div class="absolute inset-0 bg-linear-to-b from-neutral-900/10 to-neutral-900/60"></div>

        <div
            class="relative z-10 w-full max-w-7xl mx-auto px-6 lg:px-10 pt-20 flex items-center min-h-[680px] md:min-h-[760px]">
            <div class="text-white max-w-2xl">
                <span
                    class="inline-flex items-center bg-primary text-white text-xs font-bold uppercase tracking-widest px-4 py-2 rounded-lg mb-4 shadow-sm">
                    {{ __('Red Inmobiliaria') }}
                </span>
                <h1 class="text-4xl md:text-5xl font-extrabold leading-tight mb-4 text-white">
                    {!! __('Agencias de confianza<br>en toda España') !!}
                </h1>
                <p class="text-lg text-white/80 max-w-lg">
                    {{ __('Todas las agencias de NidoReal están verificadas y cuentan con profesionales cualificados para asesorarte en cada paso del proceso inmobiliario.') }}
                </p>
            </div>
        </div>
    </div>

    {{-- INTRO BAR --}}
    <div class="bg-white dark:bg-neutral-900 border-b border-neutral-100 dark:border-neutral-800 shadow-sm">
        <div class="max-w-7xl mx-auto px-6 lg:px-10 py-5 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p class="text-neutral-600 dark:text-neutral-400 text-sm">
                {{ trans_choice('{1} :count agencia activa en la plataforma|[2,*] :count agencias activas en la plataforma', $agencies->total(), ['count' => $agencies->total()]) }}
            </p>
            <a href="{{ route('pages.contacto') }}"
                class="inline-flex items-center gap-2 bg-primary/10 hover:bg-primary/20 text-primary font-semibold text-sm px-5 py-2.5 rounded-lg transition-colors">
                <x-heroicon-o-building-office-2 class="w-4 h-4" />
                {{ __('¿Eres una agencia? Únete') }}
            </a>
        </div>
    </div>

    {{-- AGENCIES GRID --}}
    <section class="py-16 lg:py-20 bg-neutral-50 dark:bg-neutral-900">
        <div class="max-w-7xl mx-auto px-6 lg:px-10">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse($agencies as $agency)
                    <a href="{{ route('agencies.show', $agency->slug) }}"
                        class="group bg-white dark:bg-neutral-800 rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-neutral-100 dark:border-neutral-700 flex flex-col h-full hover:-translate-y-1">
                        <div
                            class="flex items-center justify-center p-8 border-b border-neutral-100 dark:border-neutral-700/50 bg-neutral-50/50 dark:bg-neutral-900/50 h-40">
                            @if ($agency->logo_path)
                                <img src="{{ asset('storage/' . $agency->logo_path) }}" alt="{{ $agency->name }}"
                                    class="max-h-full max-w-full object-contain grayscale opacity-80 group-hover:grayscale-0 group-hover:opacity-100 transition-all duration-300">
                            @else
                                <div
                                    class="w-16 h-16 bg-primary/10 dark:bg-primary/20 rounded-full flex items-center justify-center text-primary font-bold text-xl uppercase">
                                    {{ Str::substr($agency->name, 0, 2) }}
                                </div>
                            @endif
                        </div>
                        <div class="p-6 flex flex-col grow">
                            <h3
                                class="text-xl font-bold text-neutral-900 dark:text-white mb-2 group-hover:text-primary transition-colors">
                                {{ $agency->name }}
                            </h3>
                            <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-4 flex items-start gap-1.5 grow">
                                <x-heroicon-o-map-pin class="w-4 h-4 shrink-0 mt-0.5" />
                                {{ $agency->city }}{{ $agency->province ? ', ' . $agency->province : '' }}
                            </p>
                            <div
                                class="flex items-center justify-between pt-4 mt-auto border-t border-neutral-100 dark:border-neutral-700">
                                <span class="text-sm font-semibold text-primary">
                                    {{ trans_choice('{0} 0 inmuebles|{1} 1 inmueble|[2,*] :count inmuebles', $agency->properties_count, ['count' => $agency->properties_count]) }}
                                </span>
                                <x-heroicon-o-arrow-right
                                    class="w-5 h-5 text-neutral-400 group-hover:text-primary transition-colors" />
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full py-20 text-center">
                        <div
                            class="w-20 h-20 bg-neutral-100 dark:bg-neutral-800 rounded-full flex items-center justify-center mx-auto mb-4 text-neutral-400">
                            <x-heroicon-o-building-office-2 class="w-8 h-8" />
                        </div>
                        <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-2">
                            {{ __('No hay agencias registradas') }}</h3>
                        <p class="text-neutral-500 dark:text-neutral-400 text-sm">
                            {{ __('Vuelve pronto, estamos incorporando nuevas agencias.') }}</p>
                    </div>
                @endforelse
            </div>

            @if (method_exists($agencies, 'hasPages') && $agencies->hasPages())
                <div class="mt-12">
                    {{ $agencies->links() }}
                </div>
            @endif
        </div>
    </section>

    {{-- CTA FOR AGENCIES --}}
    <section class="bg-primary py-16 lg:py-20 border-t border-primary/20">
        <div class="max-w-7xl mx-auto px-6 lg:px-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.2em] text-white/60 mb-3">{{ __('Para agencias') }}
                    </p>
                    <h2 class="text-3xl lg:text-4xl font-extrabold text-white mb-4">
                        {{ __('¿Tu agency no está en NidoReal?', ['agency' => __('agencia')]) }}</h2>
                    <p class="text-white/80 text-lg mb-8 leading-relaxed">
                        {{ __('Únete a nuestra red y llega a miles de compradores y arrendatarios cada mes. Elige el plan que mejor se adapte a tu negocio y empieza a publicar desde el primer día.') }}
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('pages.tarifas') }}"
                            class="inline-flex items-center gap-2 bg-white text-primary font-bold px-8 py-4 rounded-xl hover:bg-neutral-100 transition-colors shadow-lg">
                            {{ __('Ver planes y tarifas') }}
                            <x-heroicon-o-arrow-right class="w-4 h-4" />
                        </a>
                        <a href="{{ route('pages.contacto') }}"
                            class="inline-flex items-center gap-2 border-2 border-white/40 text-white font-semibold px-8 py-4 rounded-xl hover:bg-white/10 transition-colors">
                            {{ __('Contactar') }}
                        </a>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    @foreach ([['heroicon-o-eye', __('Máxima visibilidad'), __('Tu agencia y tus inmuebles, ante miles de usuarios cada mes.')], ['heroicon-o-chart-bar', __('Estadísticas'), __('Monitoriza el rendimiento de tus anuncios en tiempo real.')], ['heroicon-o-users', __('Gestión de agentes'), __('Añade y gestiona a todo tu equipo desde un único panel.')], ['heroicon-o-shield-check', __('Plataforma segura'), __('Datos protegidos y hosting de alta disponibilidad.')]] as [$icon, $title, $desc])
                        <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-5 border border-white/20">
                            <x-dynamic-component :component="$icon" class="w-6 h-6 text-white mb-3" />
                            <p class="font-bold text-white text-sm mb-1">{{ $title }}</p>
                            <p class="text-white/70 text-xs leading-relaxed">{{ $desc }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

@endsection
