@extends('layouts.public')

@section('title', $agency->name . ' — ' . __('Agencias') . ' — NidoReal')
@section('description', __('Conoce a :name, agencia inmobiliaria en :city. Consulta sus propiedades disponibles y contacta directamente con su equipo de agentes.', ['name' => $agency->name, 'city' => $agency->city]))

@section('content')

    {{-- HERO WITH AGENCY LOGO --}}
    <div class="relative w-full min-h-[680px] md:min-h-[760px] bg-neutral-900 overflow-hidden flex items-center">
        <div class="absolute inset-0 bg-neutral-800 opacity-40"></div>
        <div class="absolute inset-0 bg-linear-to-b from-neutral-900/60 to-transparent"></div>

        <div class="relative z-10 w-full max-w-7xl mx-auto px-6 lg:px-10 flex flex-col md:flex-row items-center justify-center md:justify-start gap-8">
            {{-- LOGO --}}
            <div class="w-32 h-32 md:w-48 md:h-48 bg-white rounded-3xl p-4 shadow-xl shrink-0 flex items-center justify-center overflow-hidden border border-neutral-100">
                @if($agency->logo_path)
                    <img src="{{ asset('storage/' . $agency->logo_path) }}" alt="{{ $agency->name }}" class="max-w-full max-h-full object-contain">
                @else
                    <div class="w-full h-full bg-primary/5 rounded-2xl flex items-center justify-center text-primary font-bold text-5xl uppercase">
                        {{ Str::substr($agency->name, 0, 2) }}
                    </div>
                @endif
            </div>

            {{-- INFO --}}
            <div class="text-white text-center md:text-left flex-1">
                <span class="inline-block px-4 py-1.5 bg-white/10 backdrop-blur-sm rounded-lg text-sm font-semibold mb-4 border border-white/20">
                    {{ trans_choice('{0} 0 inmuebles activos|{1} 1 inmueble activo|[2,*] :count inmuebles activos', $agency->properties_count, ['count' => $agency->properties_count]) }}
                </span>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold mb-4">{{ $agency->name }}</h1>
                <p class="text-lg text-white/80 flex items-center gap-2 justify-center md:justify-start flex-wrap">
                    <x-heroicon-o-map-pin class="w-5 h-5 shrink-0" />
                    <span>{{ $agency->address ? $agency->address . ', ' : '' }}{{ $agency->city }}{{ $agency->province ? ', ' . $agency->province : '' }}</span>
                </p>
            </div>
        </div>
    </div>

    {{-- CONTACT + STATS BAR --}}
    <div class="bg-white dark:bg-neutral-900 border-b border-neutral-100 dark:border-neutral-800 shadow-sm">
        <div class="max-w-7xl mx-auto px-6 lg:px-10 py-5">
            <div class="flex flex-wrap items-center gap-6 justify-between">
                {{-- Quick stats --}}
                <div class="flex items-center gap-8">
                    <div class="text-center">
                        <div class="text-2xl font-black text-primary">{{ $agency->properties_count }}</div>
                        <div class="text-xs text-neutral-500 dark:text-neutral-400 uppercase tracking-wide font-semibold">{{ __('Inmuebles') }}</div>
                    </div>
                    <div class="w-px h-8 bg-neutral-200 dark:bg-neutral-700"></div>
                    <div class="text-center">
                        <div class="text-2xl font-black text-primary">{{ $agency->users->count() }}</div>
                        <div class="text-xs text-neutral-500 dark:text-neutral-400 uppercase tracking-wide font-semibold">{{ __('Agentes') }}</div>
                    </div>
                </div>
                {{-- CTA buttons --}}
                <div class="flex flex-wrap gap-3">
                    @if($agency->phone)
                        <a href="tel:{{ $agency->phone }}"
                            class="inline-flex items-center gap-2 bg-primary hover:bg-primary-content text-white font-bold px-5 py-2.5 rounded-xl transition-colors text-sm">
                            <x-heroicon-o-phone class="w-4 h-4" />
                            {{ $agency->phone }}
                        </a>
                    @endif
                    @if($agency->email)
                        <a href="mailto:{{ $agency->email }}"
                            class="inline-flex items-center gap-2 border border-neutral-200 dark:border-neutral-700 hover:border-primary hover:text-primary text-neutral-700 dark:text-neutral-300 font-semibold px-5 py-2.5 rounded-xl transition-colors text-sm">
                            <x-heroicon-o-envelope class="w-4 h-4" />
                            {{ __('Enviar correo') }}
                        </a>
                    @endif
                    @if($agency->website)
                        <a href="{{ str_starts_with($agency->website, 'http') ? $agency->website : 'https://' . $agency->website }}"
                            target="_blank" rel="noopener noreferrer"
                            class="inline-flex items-center gap-2 border border-neutral-200 dark:border-neutral-700 hover:border-primary hover:text-primary text-neutral-700 dark:text-neutral-300 font-semibold px-5 py-2.5 rounded-xl transition-colors text-sm">
                            <x-heroicon-o-globe-alt class="w-4 h-4" />
                            {{ __('Sitio web') }}
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- AGENTS SECTION --}}
    <section class="py-14 lg:py-20 bg-neutral-50 dark:bg-neutral-900">
        <div class="max-w-7xl mx-auto px-6 lg:px-10">
            <h2 class="text-2xl font-extrabold text-neutral-900 dark:text-white mb-8 flex items-center gap-3">
                <span class="w-1 h-7 bg-primary rounded-full inline-block"></span>
                {{ __('Agentes de la agencia') }}
            </h2>
            @if($agency->users->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                    @foreach($agency->users as $agent)
                        <div class="bg-white dark:bg-neutral-800 rounded-2xl border border-neutral-100 dark:border-neutral-700 p-6 flex flex-col items-center text-center hover:shadow-md transition-shadow">
                            {{-- Agent avatar --}}
                            <div class="w-20 h-20 shrink-0 rounded-full overflow-hidden bg-neutral-100 dark:bg-neutral-700 border-2 border-primary/20 mb-4">
                                @if($agent->avatar_path)
                                    <img src="{{ asset('storage/' . $agent->avatar_path) }}" alt="{{ $agent->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-primary/10 text-primary font-bold text-xl">
                                        {{ strtoupper(substr($agent->name, 0, 1)) }}
                                    </div>
                                @endif
                            </div>

                            <h4 class="text-base font-bold text-neutral-900 dark:text-white mb-0.5">{{ $agent->name }}</h4>
                            <p class="text-sm text-primary font-semibold mb-4">{{ __('Agente inmobiliario') }}</p>

                            <div class="space-y-2 w-full">
                                @if($agent->phone)
                                    <a href="tel:{{ $agent->phone }}" class="flex items-center gap-2 justify-center text-sm text-neutral-600 dark:text-neutral-400 hover:text-primary transition-colors">
                                        <x-heroicon-o-phone class="w-4 h-4 shrink-0" />
                                        {{ $agent->phone }}
                                    </a>
                                @endif
                                @if($agent->whatsapp)
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $agent->whatsapp) }}" target="_blank"
                                        class="flex items-center gap-2 justify-center text-sm text-neutral-600 dark:text-neutral-400 hover:text-[#25D366] transition-colors">
                                        <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                                        </svg>
                                        WhatsApp
                                    </a>
                                @endif
                                @if($agent->email)
                                    <a href="mailto:{{ $agent->email }}" class="flex items-center gap-2 justify-center text-sm text-neutral-600 dark:text-neutral-400 hover:text-primary transition-colors">
                                        <x-heroicon-o-envelope class="w-4 h-4 shrink-0" />
                                        <span class="truncate max-w-[160px]">{{ $agent->email }}</span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white dark:bg-neutral-800 rounded-2xl border border-neutral-100 dark:border-neutral-700 p-10 text-center">
                    <x-heroicon-o-user-group class="w-10 h-10 text-neutral-300 dark:text-neutral-600 mx-auto mb-3" />
                    <p class="text-neutral-500 dark:text-neutral-400">{{ __('Esta agencia todavía no tiene agentes registrados en la plataforma.') }}</p>
                </div>
            @endif
        </div>
    </section>

    {{-- LATEST PROPERTIES — full-width section --}}
    @if($latestProperties->isNotEmpty())
        <section class="py-14 lg:py-20 bg-white dark:bg-neutral-950 border-t border-neutral-100 dark:border-neutral-800">
            <div class="max-w-7xl mx-auto px-6 lg:px-10">
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-2xl font-extrabold text-neutral-900 dark:text-white flex items-center gap-3">
                        <span class="w-1 h-7 bg-primary rounded-full inline-block"></span>
                        {{ __('Últimos inmuebles publicados') }}
                    </h2>
                    <a href="{{ route('properties.index', ['agency_id' => $agency->id]) }}"
                        class="text-sm font-semibold text-primary hover:underline flex items-center gap-1">
                        {{ __('Ver todos') }} ({{ $agency->properties_count }})
                        <x-heroicon-o-arrow-right class="w-4 h-4" />
                    </a>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($latestProperties as $property)
                        <x-public.property.card :property="$property" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- CTA CONTACT BANNER --}}
    <section class="bg-primary py-14 lg:py-16">
        <div class="max-w-7xl mx-auto px-6 lg:px-10 flex flex-col md:flex-row items-center justify-between gap-6">
            <div>
                <h2 class="text-2xl lg:text-3xl font-extrabold text-white mb-2">{{ __('¿Te interesa alguno de sus inmuebles?') }}</h2>
                <p class="text-white/80">{{ __('Ponte en contacto con :name directamente y sin intermediarios.', ['name' => $agency->name]) }}</p>
            </div>
            <div class="flex flex-wrap gap-3 shrink-0">
                @if($agency->phone)
                    <a href="tel:{{ $agency->phone }}"
                        class="inline-flex items-center gap-2 bg-white text-primary font-bold px-6 py-3.5 rounded-xl hover:bg-neutral-100 transition-colors shadow-lg">
                        <x-heroicon-o-phone class="w-4 h-4" />
                        {{ __('Lamar') }}
                    </a>
                @endif
                @if($agency->email)
                    <a href="mailto:{{ $agency->email }}"
                        class="inline-flex items-center gap-2 border-2 border-white/40 text-white font-bold px-6 py-3.5 rounded-xl hover:bg-white/10 transition-colors">
                        <x-heroicon-o-envelope class="w-4 h-4" />
                        {{ __('Escribir') }}
                    </a>
                @endif
            </div>
        </div>
    </section>

@endsection
