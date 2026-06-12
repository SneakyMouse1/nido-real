@extends('layouts.public')

@section('title', __('Contacto — NidoReal'))
@section('description',
    __('Contacta con el equipo de NidoReal. Estamos disponibles para resolver todas tus dudas sobre
    inmuebles, agencias y el funcionamiento de la plataforma.'))

@section('content')

    {{-- HERO --}}
    <div class="relative w-full min-h-[680px] md:min-h-[760px] bg-neutral-800 overflow-hidden flex items-center">
        <img src="{{ asset('images/heroes/contacto.webp') }}" alt="{{ __('Contacto') }}"
            class="absolute inset-0 w-full h-full object-cover pointer-events-none select-none" fetchpriority="high">
        <div class="absolute inset-0 bg-linear-to-b from-neutral-900/10 to-neutral-900/60"></div>

        <div
            class="relative z-10 w-full max-w-7xl mx-auto px-6 lg:px-10 pt-20 flex items-center min-h-[680px] md:min-h-[760px]">
            <div class="text-white max-w-xl">
                <span
                    class="inline-flex items-center bg-primary text-white text-xs font-bold uppercase tracking-widest px-4 py-2 rounded-lg mb-4 shadow-sm">
                    {{ __('Estamos aquí para ti') }}
                </span>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold leading-tight mb-4 text-white">
                    {{ __('Contacto') }}
                </h1>
                <p class="text-lg text-white/80">
                    {{ __('¿Tienes alguna pregunta sobre un inmueble, una agencia o la plataforma? Escríbenos y te responderemos lo antes posible.') }}
                </p>
            </div>
        </div>
    </div>

    {{-- CONTACT CHANNELS --}}
    <section class="py-14 bg-white dark:bg-neutral-950 border-b border-neutral-100 dark:border-neutral-800">
        <div class="max-w-7xl mx-auto px-6 lg:px-10">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ([['heroicon-o-phone', __('Llámanos'), '+34 900 123 456', __('Lun–Vie, 9:00–18:00 h'), 'tel:+34900123456'], ['heroicon-o-envelope', __('Escríbenos'), 'hola@nidoreal.com', __('Respuesta en menos de 24 h'), 'mailto:hola@nidoreal.com'], ['heroicon-o-clock', __('Horario de atención'), __('Lun–Vie 9:00–18:00'), __('Soporte email siempre disponible'), null]] as [$icon, $title, $value, $sub, $href])
                    <div
                        class="bg-neutral-50 dark:bg-neutral-900 border border-neutral-100 dark:border-neutral-800 rounded-2xl p-7 flex items-start gap-5">
                        <div
                            class="w-12 h-12 bg-primary/10 dark:bg-primary/20 rounded-xl flex items-center justify-center shrink-0">
                            <x-dynamic-component :component="$icon" class="w-6 h-6 text-primary" />
                        </div>
                        <div>
                            <p class="text-xs font-bold uppercase tracking-widest text-neutral-400 mb-1">{{ $title }}
                            </p>
                            @if ($href)
                                <a href="{{ $href }}"
                                    class="text-lg font-bold text-neutral-900 dark:text-white hover:text-primary transition-colors">{{ $value }}</a>
                            @else
                                <p class="text-lg font-bold text-neutral-900 dark:text-white">{{ $value }}</p>
                            @endif
                            <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-0.5">{{ $sub }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CONTACT FORM --}}
    <section class="py-20 lg:py-28 bg-neutral-50 dark:bg-neutral-900">
        <div class="max-w-7xl mx-auto px-6 lg:px-10">
            <div
                class="bg-white dark:bg-neutral-800 rounded-3xl shadow-2xl overflow-hidden grid grid-cols-1 lg:grid-cols-2">

                {{-- LEFT: Info --}}
                <div class="p-10 lg:p-16 flex flex-col justify-center bg-neutral-900 dark:bg-neutral-950">
                    <p class="text-xs font-bold uppercase tracking-[0.2em] text-primary mb-4">
                        {{ __('Formulario de contacto') }}</p>
                    <h2 class="text-3xl lg:text-4xl font-extrabold text-white mb-4 leading-tight">
                        {{ __('¿En qué podemos ayudarte?') }}
                    </h2>
                    <p class="text-neutral-400 text-lg mb-10 leading-relaxed">
                        {{ __('Completa el formulario y un miembro de nuestro equipo se pondrá en contacto contigo sin compromiso.') }}
                    </p>

                    {{-- Trust points --}}
                    <div class="space-y-5">
                        @foreach ([['heroicon-o-shield-check', __('Tus datos están protegidos'), __('Cumplimos con el RGPD y la LOPD-GDD.')], ['heroicon-o-bolt', __('Respuesta rápida'), __('Tiempo medio de respuesta inferior a 4 horas en horario laboral.')], ['heroicon-o-user-group', __('Equipo humano'), __('Siempre hablarás con una persona real, no con un bot.')]] as [$icon, $title, $desc])
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 bg-primary/10 rounded-xl flex items-center justify-center shrink-0">
                                    <x-dynamic-component :component="$icon" class="w-5 h-5 text-primary" />
                                </div>
                                <div>
                                    <p class="font-bold text-white text-sm mb-0.5">{{ $title }}</p>
                                    <p class="text-neutral-400 text-sm">{{ $desc }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- RIGHT: Form --}}
                <div class="p-10 lg:p-16" x-data="{ sent: false }">
                    <form action="#" method="POST" class="space-y-5" @submit.prevent="sent = true">
                        @csrf
                        <div x-show="!sent">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label
                                        class="block text-sm font-semibold text-neutral-800 dark:text-neutral-200 mb-1.5">{{ __('Nombre *') }}</label>
                                    <input type="text" name="name" required placeholder="{{ __('Tu nombre') }}"
                                        class="w-full px-4 py-3 bg-white dark:bg-neutral-700 border border-neutral-200 dark:border-neutral-600 rounded-xl text-sm text-neutral-900 dark:text-white outline-none focus:border-primary transition-colors placeholder-neutral-400">
                                </div>
                                <div>
                                    <label
                                        class="block text-sm font-semibold text-neutral-800 dark:text-neutral-200 mb-1.5">{{ __('Apellidos') }}</label>
                                    <input type="text" name="last_name" placeholder="{{ __('Tus apellidos') }}"
                                        class="w-full px-4 py-3 bg-white dark:bg-neutral-700 border border-neutral-200 dark:border-neutral-600 rounded-xl text-sm text-neutral-900 dark:text-white outline-none focus:border-primary transition-colors placeholder-neutral-400">
                                </div>
                            </div>
                            <div>
                                <label
                                    class="block text-sm font-semibold text-neutral-800 dark:text-neutral-200 mb-1.5">{{ __('Teléfono *') }}</label>
                                <input type="tel" name="phone" required placeholder="+34 600 000 000"
                                    class="w-full px-4 py-3 bg-white dark:bg-neutral-700 border border-neutral-200 dark:border-neutral-600 rounded-xl text-sm text-neutral-900 dark:text-white outline-none focus:border-primary transition-colors placeholder-neutral-400">
                            </div>
                            <div>
                                <label
                                    class="block text-sm font-semibold text-neutral-800 dark:text-neutral-200 mb-1.5">{{ __('Correo electrónico') }}</label>
                                <input type="email" name="email" placeholder="tu@correo.es"
                                    class="w-full px-4 py-3 bg-white dark:bg-neutral-700 border border-neutral-200 dark:border-neutral-600 rounded-xl text-sm text-neutral-900 dark:text-white outline-none focus:border-primary transition-colors placeholder-neutral-400">
                            </div>
                            <div>
                                <label
                                    class="block text-sm font-semibold text-neutral-800 dark:text-neutral-200 mb-1.5">{{ __('Motivo de la consulta *') }}</label>
                                <select name="subject" required
                                    class="w-full px-4 py-3 bg-white dark:bg-neutral-700 border border-neutral-200 dark:border-neutral-600 rounded-xl text-sm text-neutral-900 dark:text-white outline-none focus:border-primary transition-colors">
                                    <option value="">{{ __('Selecciona un asunto...') }}</option>
                                    <option value="buy">{{ __('Quiero comprar una propiedad') }}</option>
                                    <option value="rent">{{ __('Quiero alquilar una propiedad') }}</option>
                                    <option value="sell">{{ __('Quiero vender mi propiedad') }}</option>
                                    <option value="agency">{{ __('Información para agencias') }}</option>
                                    <option value="support">{{ __('Soporte técnico') }}</option>
                                    <option value="other">{{ __('Otras consultas') }}</option>
                                </select>
                            </div>
                            <div>
                                <label
                                    class="block text-sm font-semibold text-neutral-800 dark:text-neutral-200 mb-1.5">{{ __('Mensaje') }}</label>
                                <textarea name="message" rows="4" placeholder="{{ __('Cuéntanos en qué podemos ayudarte...') }}"
                                    class="w-full px-4 py-3 bg-white dark:bg-neutral-700 border border-neutral-200 dark:border-neutral-600 rounded-xl text-sm text-neutral-900 dark:text-white outline-none focus:border-primary transition-colors placeholder-neutral-400 resize-none"></textarea>
                            </div>
                            <p class="text-xs text-neutral-400 leading-relaxed">
                                {{ __('Al enviar confirmas que aceptas nuestra') }} <a href="#"
                                    class="text-primary hover:underline">{{ __('Política de Privacidad') }}</a>.
                            </p>
                            <button type="submit"
                                class="w-full bg-accent hover:bg-accent/90 text-white font-bold py-4 rounded-xl transition-colors">
                                {{ __('Enviar mensaje') }}
                            </button>
                        </div>

                        {{-- Success state --}}
                        <div x-show="sent" x-cloak class="py-12 text-center">
                            <div
                                class="w-16 h-16 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                                <x-heroicon-s-check-circle class="w-8 h-8 text-green-600 dark:text-green-400" />
                            </div>
                            <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-2">
                                {{ __('¡Mensaje enviado!') }}</h3>
                            <p class="text-neutral-600 dark:text-neutral-400 text-sm">
                                {{ __('Gracias por contactarnos. Te responderemos lo antes posible.') }}</p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    {{-- MINI FAQ --}}
    <section class="py-16 lg:py-20 bg-neutral-100 dark:bg-neutral-800 border-t-4 border-primary">
        <div class="max-w-4xl mx-auto px-6 lg:px-10">
            <div class="text-center mb-10">
                <h2 class="text-2xl font-extrabold text-neutral-900 dark:text-white">{{ __('Respuestas rápidas') }}</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ([[__('¿Necesito registrarme para contactar con una agencia?'), __('No. Puedes escribir o llamar directamente al agente desde la ficha de cada propiedad sin registrarte.')], [__('¿NidoReal cobra comisiones al comprador?'), __('No. NidoReal es un portal de búsqueda gratuito para compradores y arrendatarios. Las comisiones las gestiona la agencia.')], [__('¿Cómo puedo publicar mi agencia en NidoReal?'), __('Regístrate en el panel de agencia, elige un plan y empieza a publicar de inmediato. Consulta nuestros planes en la página de tarifas.')]] as [$q, $a])
                    <div
                        class="bg-neutral-50 dark:bg-neutral-900 border border-neutral-100 dark:border-neutral-800 rounded-2xl p-6">
                        <p class="font-bold text-neutral-900 dark:text-white mb-2 text-sm">{{ $q }}</p>
                        <p class="text-neutral-600 dark:text-neutral-400 text-sm leading-relaxed">{{ $a }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

@endsection
