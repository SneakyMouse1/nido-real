@extends('layouts.public')

@section('title', __('Tarifas para Agencias — NidoReal'))
@section('description', __('Planes flexibles para agencias inmobiliarias en España. Publica tus propiedades en NidoReal y conecta con miles de compradores y arrendatarios.'))

@section('content')

    {{-- HERO --}}
    <div class="relative w-full min-h-[680px] md:min-h-[760px] bg-neutral-800 overflow-hidden flex items-center">
        <img src="{{ asset('images/heroes/tarifas.webp') }}" alt="{{ __('Planes y Tarifas') }}"
            class="absolute inset-0 w-full h-full object-cover pointer-events-none select-none" fetchpriority="high">
        <div class="absolute inset-0 bg-linear-to-b from-neutral-900/10 to-neutral-900/30"></div>

        <div class="relative z-10 w-full max-w-7xl mx-auto px-6 lg:px-10 pt-20 flex items-center min-h-[680px] md:min-h-[760px]">
            <div class="text-white max-w-xl">
                <span class="inline-flex items-center bg-primary text-white text-xs font-bold uppercase tracking-widest px-4 py-2 rounded-lg mb-4 shadow-sm">
                    {{ __('Para Agencias') }}
                </span>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold leading-tight mb-4 text-white">
                    {{ __('Planes y Tarifas') }}
                </h1>
                <p class="text-lg text-white/80">
                    {{ __('Elige el plan que mejor se adapte al tamaño y objetivos de tu agencia. Sin permanencia, sin sorpresas.') }}
                </p>
            </div>
        </div>
    </div>

    {{-- PRICING CARDS --}}
    <section class="py-20 lg:py-28 bg-neutral-50 dark:bg-neutral-900">
        <div class="max-w-7xl mx-auto px-6 lg:px-10">
            <div class="text-center mb-16">
                <p class="text-xs font-bold uppercase tracking-[0.2em] text-primary mb-3">{{ __('Precios transparentes') }}</p>
                <h2 class="text-3xl lg:text-4xl font-extrabold text-neutral-900 dark:text-white mb-4">
                    {{ __('Elige el plan ideal para tu negocio') }}
                </h2>
                <p class="text-lg text-neutral-600 dark:text-neutral-400 max-w-2xl mx-auto">
                    {{ __('Empieza a publicar hoy mismo y conecta con miles de compradores en toda España. Sin costes de alta ni permanencia mínima.') }}
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                {{-- Starter Plan --}}
                <div class="bg-white dark:bg-neutral-800 rounded-3xl p-8 border border-neutral-200 dark:border-neutral-700 shadow-sm flex flex-col items-start relative overflow-hidden transition-transform hover:-translate-y-1">
                    <h3 class="text-2xl font-bold text-neutral-900 dark:text-white mb-2">Starter</h3>
                    <p class="text-neutral-500 dark:text-neutral-400 text-sm mb-6">{{ __('Ideal para agencias independientes que empiezan.') }}</p>
                    <div class="mb-6">
                        <span class="text-4xl font-black text-neutral-900 dark:text-white">€49</span>
                        <span class="text-neutral-500 dark:text-neutral-400">{{ __('/mes') }}</span>
                    </div>
                    <ul class="space-y-4 mb-8 grow w-full">
                        <li class="flex items-center gap-3 text-neutral-700 dark:text-neutral-300">
                            <x-heroicon-s-check-circle class="w-5 h-5 text-primary shrink-0" />
                            {{ __('Hasta 10 propiedades publicadas') }}
                        </li>
                        <li class="flex items-center gap-3 text-neutral-700 dark:text-neutral-300">
                            <x-heroicon-s-check-circle class="w-5 h-5 text-primary shrink-0" />
                            {{ __('Perfil básico de agencia') }}
                        </li>
                        <li class="flex items-center gap-3 text-neutral-700 dark:text-neutral-300">
                            <x-heroicon-s-check-circle class="w-5 h-5 text-primary shrink-0" />
                            {{ __('Fotos ilimitadas por inmueble') }}
                        </li>
                        <li class="flex items-center gap-3 text-neutral-700 dark:text-neutral-300">
                            <x-heroicon-s-check-circle class="w-5 h-5 text-primary shrink-0" />
                            {{ __('Soporte vía email') }}
                        </li>
                    </ul>
                    <a href="{{ route('filament.agency.auth.login') }}" class="w-full text-center bg-neutral-100 hover:bg-neutral-200 dark:bg-neutral-700 dark:hover:bg-neutral-600 text-neutral-900 dark:text-white font-bold py-3 rounded-xl transition-colors">
                        {{ __('Empezar ahora') }}
                    </a>
                </div>

                {{-- Pro Plan (Destacado) --}}
                <div class="bg-primary/5 border-2 border-primary rounded-3xl p-8 shadow-xl flex flex-col items-start relative overflow-hidden transition-transform hover:-translate-y-1">
                    <div class="absolute top-0 right-0 bg-primary text-white text-xs font-bold px-4 py-1.5 rounded-bl-xl uppercase tracking-wider">
                        {{ __('Recomendado') }}
                    </div>
                    <h3 class="text-2xl font-bold text-neutral-900 dark:text-white mb-2">Pro</h3>
                    <p class="text-neutral-500 dark:text-neutral-400 text-sm mb-6">{{ __('Para agencias en crecimiento activo.') }}</p>
                    <div class="mb-6">
                        <span class="text-4xl font-black text-neutral-900 dark:text-white">€149</span>
                        <span class="text-neutral-500 dark:text-neutral-400">{{ __('/mes') }}</span>
                    </div>
                    <ul class="space-y-4 mb-8 grow w-full">
                        <li class="flex items-center gap-3 text-neutral-700 dark:text-neutral-300 font-semibold">
                            <x-heroicon-s-check-circle class="w-5 h-5 text-primary shrink-0" />
                            {{ __('Hasta 50 propiedades publicadas') }}
                        </li>
                        <li class="flex items-center gap-3 text-neutral-700 dark:text-neutral-300">
                            <x-heroicon-s-check-circle class="w-5 h-5 text-primary shrink-0" />
                            {{ __('Mejor posicionamiento en resultados') }}
                        </li>
                        <li class="flex items-center gap-3 text-neutral-700 dark:text-neutral-300">
                            <x-heroicon-s-check-circle class="w-5 h-5 text-primary shrink-0" />
                            {{ __('Perfil destacado de agencia') }}
                        </li>
                        <li class="flex items-center gap-3 text-neutral-700 dark:text-neutral-300">
                            <x-heroicon-s-check-circle class="w-5 h-5 text-primary shrink-0" />
                            {{ __('Estadísticas de visitas') }}
                        </li>
                        <li class="flex items-center gap-3 text-neutral-700 dark:text-neutral-300">
                            <x-heroicon-s-check-circle class="w-5 h-5 text-primary shrink-0" />
                            {{ __('Soporte prioritario 24/7') }}
                        </li>
                    </ul>
                    <a href="{{ route('filament.agency.auth.login') }}" class="w-full text-center bg-primary hover:bg-primary-content text-white font-bold py-3 rounded-xl transition-colors shadow-lg shadow-primary/20">
                        {{ __('Prueba gratuita 30 días') }}
                    </a>
                </div>

                {{-- Unlimited Plan --}}
                <div class="bg-white dark:bg-neutral-800 rounded-3xl p-8 border border-neutral-200 dark:border-neutral-700 shadow-sm flex flex-col items-start relative overflow-hidden transition-transform hover:-translate-y-1">
                    <h3 class="text-2xl font-bold text-neutral-900 dark:text-white mb-2">Unlimited</h3>
                    <p class="text-neutral-500 dark:text-neutral-400 text-sm mb-6">{{ __('Para grandes redes y franquicias inmobiliarias.') }}</p>
                    <div class="mb-6">
                        <span class="text-4xl font-black text-neutral-900 dark:text-white">€399</span>
                        <span class="text-neutral-500 dark:text-neutral-400">{{ __('/mes') }}</span>
                    </div>
                    <ul class="space-y-4 mb-8 grow w-full">
                        <li class="flex items-center gap-3 text-neutral-700 dark:text-neutral-300 font-semibold">
                            <x-heroicon-s-check-circle class="w-5 h-5 text-accent shrink-0" />
                            {{ __('Propiedades ilimitadas') }}
                        </li>
                        <li class="flex items-center gap-3 text-neutral-700 dark:text-neutral-300">
                            <x-heroicon-s-check-circle class="w-5 h-5 text-primary shrink-0" />
                            {{ __('Posición Top en todos los resultados') }}
                        </li>
                        <li class="flex items-center gap-3 text-neutral-700 dark:text-neutral-300">
                            <x-heroicon-s-check-circle class="w-5 h-5 text-primary shrink-0" />
                            {{ __('Importación automática vía XML/API') }}
                        </li>
                        <li class="flex items-center gap-3 text-neutral-700 dark:text-neutral-300">
                            <x-heroicon-s-check-circle class="w-5 h-5 text-primary shrink-0" />
                            {{ __('Gestor de cuenta dedicado (KAM)') }}
                        </li>
                        <li class="flex items-center gap-3 text-neutral-700 dark:text-neutral-300">
                            <x-heroicon-s-check-circle class="w-5 h-5 text-primary shrink-0" />
                            {{ __('SLA garantizado') }}
                        </li>
                    </ul>
                    <a href="{{ route('pages.contacto') }}" class="w-full text-center bg-neutral-900 hover:bg-neutral-800 dark:bg-white dark:hover:bg-neutral-200 dark:text-neutral-900 text-white font-bold py-3 rounded-xl transition-colors">
                        {{ __('Contactar con ventas') }}
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- COMPARISON TABLE --}}
    <section class="py-20 lg:py-24 bg-white dark:bg-neutral-950 border-t border-neutral-100 dark:border-neutral-800">
        <div class="max-w-5xl mx-auto px-6 lg:px-10">
            <div class="text-center mb-12">
                <p class="text-xs font-bold uppercase tracking-[0.2em] text-primary mb-3">{{ __('Comparativa') }}</p>
                <h2 class="text-3xl font-extrabold text-neutral-900 dark:text-white">{{ __('¿Qué incluye cada plan?') }}</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b-2 border-neutral-200 dark:border-neutral-700">
                            <th class="text-left py-4 pr-8 text-neutral-500 dark:text-neutral-400 font-semibold w-1/2">{{ __('Característica') }}</th>
                            <th class="text-center py-4 px-4 text-neutral-900 dark:text-white font-bold">Starter</th>
                            <th class="text-center py-4 px-4 text-primary font-bold">Pro</th>
                            <th class="text-center py-4 px-4 text-neutral-900 dark:text-white font-bold">Unlimited</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-100 dark:divide-neutral-800">
                        @php
                            $features = [
                                [__('Propiedades publicadas'), '10', '50', __('Ilimitadas')],
                                [__('Fotos por inmueble'), __('Ilimitadas'), __('Ilimitadas'), __('Ilimitadas')],
                                [__('Vídeo del inmueble'), '✓', '✓', '✓'],
                                [__('Gestión de planos'), '✗', '✓', '✓'],
                                [__('Perfil de agencia'), __('Básico'), __('Destacado'), __('Premium')],
                                [__('Posicionamiento'), __('Normal'), __('Mejorado'), __('Top')],
                                [__('Estadísticas de visitas'), '✗', '✓', '✓'],
                                [__('Importación XML/API'), '✗', '✗', '✓'],
                                [__('Gestor de cuenta (KAM)'), '✗', '✗', '✓'],
                                [__('Soporte'), __('Email'), __('Prioritario 24/7'), __('SLA garantizado')],
                            ];
                        @endphp
                        @foreach ($features as [$feature, $starter, $pro, $unlimited])
                            <tr>
                                <td class="py-4 pr-8 text-neutral-700 dark:text-neutral-300 font-medium">{{ $feature }}</td>
                                <td class="text-center py-4 px-4 text-neutral-600 dark:text-neutral-400">
                                    @if($starter === '✓') <x-heroicon-s-check-circle class="w-5 h-5 text-primary mx-auto" />
                                    @elseif($starter === '✗') <x-heroicon-o-x-circle class="w-5 h-5 text-neutral-300 dark:text-neutral-600 mx-auto" />
                                    @else {{ $starter }} @endif
                                </td>
                                <td class="text-center py-4 px-4 text-neutral-600 dark:text-neutral-300">
                                    @if($pro === '✓') <x-heroicon-s-check-circle class="w-5 h-5 text-primary mx-auto" />
                                    @elseif($pro === '✗') <x-heroicon-o-x-circle class="w-5 h-5 text-neutral-300 dark:text-neutral-600 mx-auto" />
                                    @else <span class="font-semibold text-primary">{{ $pro }}</span> @endif
                                </td>
                                <td class="text-center py-4 px-4 text-neutral-600 dark:text-neutral-400">
                                    @if($unlimited === '✓') <x-heroicon-s-check-circle class="w-5 h-5 text-primary mx-auto" />
                                    @elseif($unlimited === '✗') <x-heroicon-o-x-circle class="w-5 h-5 text-neutral-300 dark:text-neutral-600 mx-auto" />
                                    @else {{ $unlimited }} @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    {{-- FAQ --}}
    <section class="py-20 lg:py-28 bg-neutral-50 dark:bg-neutral-900 border-t border-neutral-100 dark:border-neutral-800">
        <div class="max-w-3xl mx-auto px-6 lg:px-10">
            <div class="text-center mb-12">
                <p class="text-xs font-bold uppercase tracking-[0.2em] text-primary mb-3">{{ __('Preguntas frecuentes') }}</p>
                <h2 class="text-3xl lg:text-4xl font-extrabold text-neutral-900 dark:text-white">{{ __('Dudas habituales') }}</h2>
            </div>
            <div class="space-y-3" x-data="{ open: null }">
                @foreach ([
                    [__('¿Hay permanencia mínima?'), __('No. Puedes cancelar tu plan en cualquier momento sin penalización. La baja será efectiva al final del período de facturación en curso.')],
                    [__('¿Puedo cambiar de plan más adelante?'), __('Sí, puedes actualizar o reducir tu plan en cualquier momento desde el panel de gestión de tu agencia. Los cambios se aplican al siguiente ciclo de facturación.')],
                    [__('¿Qué medios de pago aceptáis?'), __('Aceptamos tarjeta de crédito y débito (Visa, Mastercard, American Express) y transferencia bancaria para planes anuales.')],
                    [__('¿Puedo publicar inmuebles desde el primer día?'), __('Sí. En cuanto actives tu cuenta y elijas un plan, puedes empezar a publicar de inmediato desde el panel de agencia.')],
                    [__('¿Qué ocurre si supero el límite de inmuebles?'), __('Recibirás una notificación antes de alcanzar el límite y se te ofrecerá la posibilidad de ampliar tu plan. No se publicarán inmuebles adicionales hasta que actualices o liberes espacio.')],
                ] as $i => [$question, $answer])
                    <div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-2xl overflow-hidden">
                        <button @click="open = open === {{ $i }} ? null : {{ $i }}"
                            class="w-full flex items-center justify-between px-6 py-5 text-left gap-4">
                            <span class="font-semibold text-neutral-900 dark:text-white">{{ $question }}</span>
                            <x-heroicon-o-chevron-down class="w-5 h-5 text-neutral-400 shrink-0 transition-transform duration-200"
                                ::class="open === {{ $i }} ? 'rotate-180' : ''" />
                        </button>
                        <div x-show="open === {{ $i }}"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 -translate-y-1"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 -translate-y-1"
                            class="px-6 pb-5 text-neutral-600 dark:text-neutral-400 text-sm leading-relaxed border-t border-neutral-100 dark:border-neutral-700 pt-4">
                            {{ $answer }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA BANNER --}}
    <section class="bg-primary py-16 lg:py-20">
        <div class="max-w-7xl mx-auto px-6 lg:px-10 text-center">
            <h2 class="text-3xl lg:text-4xl font-extrabold text-white mb-4">{{ __('¿Tienes dudas sobre qué plan elegir?') }}</h2>
            <p class="text-white/80 text-lg mb-8 max-w-xl mx-auto">
                {{ __('Nuestro equipo de ventas está disponible para asesorarte sin compromiso y ayudarte a elegir la mejor opción para tu agencia.') }}
            </p>
            <a href="{{ route('pages.contacto') }}"
                class="inline-flex items-center gap-2 bg-white text-primary font-bold px-8 py-4 rounded-xl hover:bg-neutral-100 transition-colors shadow-lg">
                {{ __('Hablar con el equipo') }}
                <svg class="w-4 h-4" fill="none" viewBox="0 0 20 20">
                    <path d="M15.63 5v8.13a.63.63 0 01-1.25 0V6.51L5.44 15.44a.63.63 0 01-.88-.88L13.49 5.63H6.88a.63.63 0 010-1.26H15A.63.63 0 0115.63 5z" fill="currentColor" />
                </svg>
            </a>
        </div>
    </section>

@endsection
