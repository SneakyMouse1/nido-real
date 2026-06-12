@extends('layouts.public')

@section('title', __('Política de Cookies — NidoReal'))
@section('description', __('Información sobre el uso de cookies en NidoReal: qué cookies usamos, para qué y cómo gestionarlas.'))

@section('navbar')
    <x-public.navbar :floating="false" />
@endsection

@section('content')

    <div class="bg-white dark:bg-neutral-950 min-h-screen">

        {{-- Page Header --}}
        <div class="border-b border-neutral-200 dark:border-neutral-800 bg-neutral-50 dark:bg-neutral-900">
            <div class="max-w-3xl mx-auto px-6 lg:px-10 py-12">
                <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-widest text-primary mb-4">
                    <a href="{{ route('home') }}" class="hover:underline">NidoReal</a>
                    <span class="text-neutral-400">/</span>
                    <span class="text-neutral-500 dark:text-neutral-400">{{ __('Legal') }}</span>
                </div>
                <h1 class="text-3xl md:text-4xl font-extrabold text-neutral-900 dark:text-white mb-3">
                    {{ __('Política de Cookies') }}
                </h1>
                <p class="text-sm text-neutral-500 dark:text-neutral-400">
                    {{ __('Última actualización') }}: <time datetime="2025-05-01">1 de mayo de 2025</time>
                </p>
            </div>
        </div>

        {{-- Content --}}
        <div class="max-w-3xl mx-auto px-6 lg:px-10 py-14 lg:py-20">

            {{-- Lead --}}
            <p class="text-lg text-neutral-600 dark:text-neutral-400 leading-relaxed mb-14 pb-10 border-b border-neutral-100 dark:border-neutral-800">
                NidoReal utiliza cookies y tecnologías similares para mejorar tu experiencia de usuario, analizar el tráfico y personalizar el contenido. A continuación te explicamos qué son las cookies, qué tipos utilizamos y cómo puedes gestionarlas.
            </p>

            {{-- Sections --}}
            <div class="space-y-12">

                <div>
                    <h2 class="text-xs font-bold uppercase tracking-[0.15em] text-primary mb-3">01</h2>
                    <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-4">¿Qué son las cookies?</h3>
                    <p class="text-neutral-600 dark:text-neutral-400 leading-relaxed">
                        Las cookies son pequeños archivos de texto que los sitios web almacenan en tu dispositivo cuando los visitas. Permiten que el sitio web recuerde tus preferencias y acciones a lo largo del tiempo, lo que facilita una experiencia más personalizada y eficiente.
                    </p>
                </div>

                <div>
                    <h2 class="text-xs font-bold uppercase tracking-[0.15em] text-primary mb-3">02</h2>
                    <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-6">Tipos de cookies que utilizamos</h3>

                    {{-- Técnicas --}}
                    <div class="mb-8">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="px-2.5 py-1 rounded-md bg-green-100 dark:bg-green-900/40 text-green-700 dark:text-green-400 text-xs font-bold uppercase tracking-wider">
                                {{ __('Técnicas') }}
                            </span>
                            <span class="text-xs text-neutral-400 dark:text-neutral-500">{{ __('Siempre activas') }}</span>
                        </div>
                        <p class="text-sm text-neutral-600 dark:text-neutral-400 leading-relaxed mb-4">
                            Son imprescindibles para el correcto funcionamiento del sitio web. Sin ellas, no se podría navegar ni utilizar sus funcionalidades básicas. No requieren tu consentimiento.
                        </p>
                        <div class="rounded-xl border border-neutral-100 dark:border-neutral-800 overflow-hidden">
                            <div class="grid grid-cols-3 px-4 py-2.5 bg-neutral-50 dark:bg-neutral-800/60 border-b border-neutral-100 dark:border-neutral-700">
                                <span class="text-xs font-bold uppercase tracking-wider text-neutral-400">Cookie</span>
                                <span class="text-xs font-bold uppercase tracking-wider text-neutral-400">Finalidad</span>
                                <span class="text-xs font-bold uppercase tracking-wider text-neutral-400">Duración</span>
                            </div>
                            @foreach([
                                ['nidoreal_session', 'Mantiene la sesión del usuario activa', 'Sesión'],
                                ['XSRF-TOKEN', 'Protección contra ataques CSRF', 'Sesión'],
                                ['theme', 'Guarda la preferencia de tema (claro/oscuro)', '1 año'],
                            ] as [$name, $purpose, $duration])
                                <div class="grid grid-cols-3 px-4 py-3 border-b border-neutral-100 dark:border-neutral-800 last:border-0 bg-white dark:bg-neutral-900">
                                    <code class="text-xs font-mono text-primary self-center">{{ $name }}</code>
                                    <span class="text-xs text-neutral-600 dark:text-neutral-400 self-center pr-4">{{ $purpose }}</span>
                                    <span class="text-xs text-neutral-500 dark:text-neutral-500 self-center">{{ $duration }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Analíticas --}}
                    <div>
                        <div class="flex items-center gap-3 mb-4">
                            <span class="px-2.5 py-1 rounded-md bg-blue-100 dark:bg-blue-900/40 text-blue-700 dark:text-blue-400 text-xs font-bold uppercase tracking-wider">
                                {{ __('Analíticas') }}
                            </span>
                            <span class="text-xs text-neutral-400 dark:text-neutral-500">{{ __('Requieren consentimiento') }}</span>
                        </div>
                        <p class="text-sm text-neutral-600 dark:text-neutral-400 leading-relaxed mb-4">
                            Nos permiten conocer cómo los usuarios interactúan con el sitio web de forma agregada y anónima, para mejorar el servicio.
                        </p>
                        <div class="rounded-xl border border-neutral-100 dark:border-neutral-800 overflow-hidden">
                            <div class="grid grid-cols-4 px-4 py-2.5 bg-neutral-50 dark:bg-neutral-800/60 border-b border-neutral-100 dark:border-neutral-700">
                                <span class="text-xs font-bold uppercase tracking-wider text-neutral-400">Cookie</span>
                                <span class="text-xs font-bold uppercase tracking-wider text-neutral-400">Proveedor</span>
                                <span class="text-xs font-bold uppercase tracking-wider text-neutral-400">Finalidad</span>
                                <span class="text-xs font-bold uppercase tracking-wider text-neutral-400">Duración</span>
                            </div>
                            @foreach([
                                ['_ga', 'Google Analytics', 'Distingue usuarios únicos', '2 años'],
                                ['_gid', 'Google Analytics', 'Distingue usuarios', '24 horas'],
                            ] as [$name, $provider, $purpose, $duration])
                                <div class="grid grid-cols-4 px-4 py-3 border-b border-neutral-100 dark:border-neutral-800 last:border-0 bg-white dark:bg-neutral-900">
                                    <code class="text-xs font-mono text-primary self-center">{{ $name }}</code>
                                    <span class="text-xs text-neutral-600 dark:text-neutral-400 self-center">{{ $provider }}</span>
                                    <span class="text-xs text-neutral-600 dark:text-neutral-400 self-center pr-2">{{ $purpose }}</span>
                                    <span class="text-xs text-neutral-500 dark:text-neutral-500 self-center">{{ $duration }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div>
                    <h2 class="text-xs font-bold uppercase tracking-[0.15em] text-primary mb-3">03</h2>
                    <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-4">Cómo gestionar las cookies</h3>
                    <p class="text-neutral-600 dark:text-neutral-400 leading-relaxed mb-5">
                        Puedes configurar tu navegador para rechazar todas las cookies o para que te avise cuando se envíe una. Ten en cuenta que si deshabilitas las cookies técnicas, algunas partes del sitio podrían no funcionar correctamente.
                    </p>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                        @foreach([
                            ['Chrome', 'https://support.google.com/chrome/answer/95647'],
                            ['Firefox', 'https://support.mozilla.org/es/kb/habilitar-y-deshabilitar-cookies'],
                            ['Safari', 'https://support.apple.com/es-es/guide/safari/sfri11471/mac'],
                            ['Edge', 'https://support.microsoft.com/es-es/windows/eliminar-y-administrar-cookies'],
                        ] as [$browser, $url])
                            <a href="{{ $url }}" target="_blank" rel="noopener"
                                class="flex items-center justify-center gap-2 rounded-xl border border-neutral-200 dark:border-neutral-800 px-4 py-3
                                       text-sm font-semibold text-neutral-700 dark:text-neutral-300 hover:text-primary hover:border-primary
                                       dark:hover:border-primary transition-colors bg-white dark:bg-neutral-900">
                                {{ $browser }}
                                <svg class="w-3.5 h-3.5 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                </svg>
                            </a>
                        @endforeach
                    </div>
                </div>

                <div>
                    <h2 class="text-xs font-bold uppercase tracking-[0.15em] text-primary mb-3">04</h2>
                    <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-4">Consentimiento</h3>
                    <p class="text-neutral-600 dark:text-neutral-400 leading-relaxed">
                        Al continuar navegando por nuestro sitio web, aceptas el uso de cookies conforme a esta política. Puedes retirar tu consentimiento en cualquier momento borrando las cookies almacenadas en tu navegador.
                    </p>
                </div>

                <div>
                    <h2 class="text-xs font-bold uppercase tracking-[0.15em] text-primary mb-3">05</h2>
                    <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-4">Contacto</h3>
                    <p class="text-neutral-600 dark:text-neutral-400 leading-relaxed">
                        Si tienes preguntas sobre nuestro uso de cookies, puedes contactarnos en <a href="mailto:privacidad@nidoreal.es" class="text-primary hover:underline font-medium">privacidad@nidoreal.es</a>.
                    </p>
                </div>

            </div>

            {{-- Footer nav --}}
            <div class="mt-16 pt-10 border-t border-neutral-200 dark:border-neutral-800">
                <div class="flex flex-wrap items-center gap-6">
                    <a href="{{ route('home') }}"
                        class="inline-flex items-center gap-1.5 text-sm font-semibold text-neutral-500 dark:text-neutral-400 hover:text-primary transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5m7-7l-7 7 7 7"/>
                        </svg>
                        {{ __('Inicio') }}
                    </a>
                    <a href="{{ route('pages.privacidad') }}" class="text-sm font-semibold text-neutral-500 dark:text-neutral-400 hover:text-primary transition-colors">
                        {{ __('Privacidad') }}
                    </a>
                    <a href="{{ route('pages.aviso-legal') }}" class="text-sm font-semibold text-neutral-500 dark:text-neutral-400 hover:text-primary transition-colors">
                        {{ __('Aviso legal') }}
                    </a>
                </div>
            </div>

        </div>
    </div>

@endsection
