@extends('layouts.public')

@section('title', __('Aviso Legal — NidoReal'))
@section('description', __('Aviso legal de NidoReal: información sobre el titular del sitio, condiciones de uso y responsabilidades.'))

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
                    {{ __('Aviso Legal') }}
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
                En cumplimiento de la Ley 34/2002, de 11 de julio, de Servicios de la Sociedad de la Información y Comercio Electrónico (LSSI-CE), se pone a disposición de los usuarios la siguiente información sobre el titular del sitio web.
            </p>

            {{-- Sections --}}
            <div class="space-y-12">

                <div>
                    <h2 class="text-xs font-bold uppercase tracking-[0.15em] text-primary mb-3">01</h2>
                    <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-5">Datos identificativos del titular</h3>
                    <div class="rounded-xl border border-neutral-100 dark:border-neutral-800 overflow-hidden">
                        @foreach([
                            ['Denominación social', 'NidoReal S.L.'],
                            ['CIF', 'B-12345678'],
                            ['Domicilio', 'Calle Gran Vía, 1, 28013 Madrid, España'],
                            ['Correo electrónico', 'legal@nidoreal.es'],
                            ['Registro Mercantil', 'Madrid, Tomo 12345, Folio 67, Hoja M-123456'],
                        ] as [$key, $val])
                            <div class="flex flex-col sm:flex-row sm:items-center px-5 py-3.5 border-b border-neutral-100 dark:border-neutral-800 last:border-0 gap-1 bg-white dark:bg-neutral-900 odd:bg-neutral-50 dark:odd:bg-neutral-900/50">
                                <span class="sm:w-48 shrink-0 text-xs font-bold uppercase tracking-wider text-neutral-400 dark:text-neutral-500">{{ $key }}</span>
                                <span class="text-sm text-neutral-700 dark:text-neutral-300">{{ $val }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div>
                    <h2 class="text-xs font-bold uppercase tracking-[0.15em] text-primary mb-3">02</h2>
                    <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-4">Objeto y ámbito de aplicación</h3>
                    <p class="text-neutral-600 dark:text-neutral-400 leading-relaxed">
                        El presente aviso legal regula el uso del sitio web <strong class="font-semibold text-neutral-800 dark:text-neutral-200">nidoreal.es</strong>, del que es titular NidoReal S.L. La utilización del sitio web implica la aceptación plena y sin reservas de todas las disposiciones incluidas en este aviso legal.
                    </p>
                </div>

                <div>
                    <h2 class="text-xs font-bold uppercase tracking-[0.15em] text-primary mb-3">03</h2>
                    <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-4">Condiciones de uso</h3>
                    <p class="text-neutral-600 dark:text-neutral-400 leading-relaxed mb-4">
                        El usuario se compromete a hacer un uso correcto del sitio web, de conformidad con la ley y las buenas costumbres. Queda expresamente prohibido:
                    </p>
                    <ul class="space-y-2.5">
                        @foreach([
                            'Reproducir, distribuir o modificar los contenidos sin autorización expresa.',
                            'Utilizar el sitio web con fines ilícitos o contrarios a estos términos.',
                            'Introducir o difundir contenidos falsos, engañosos o que vulneren derechos de terceros.',
                            'Realizar cualquier acción que pueda dañar, inutilizar o sobrecargar el sitio web.',
                        ] as $item)
                            <li class="flex items-start gap-3 text-neutral-600 dark:text-neutral-400">
                                <span class="mt-1.5 w-1.5 h-1.5 rounded-full bg-primary shrink-0"></span>
                                {{ $item }}
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div>
                    <h2 class="text-xs font-bold uppercase tracking-[0.15em] text-primary mb-3">04</h2>
                    <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-4">Propiedad intelectual e industrial</h3>
                    <p class="text-neutral-600 dark:text-neutral-400 leading-relaxed">
                        Todos los contenidos del sitio web —incluyendo textos, fotografías, gráficos, logotipos, iconos, código fuente y diseño— son propiedad de NidoReal S.L. o de sus proveedores, y están protegidos por las leyes españolas e internacionales de propiedad intelectual. Queda prohibida su reproducción total o parcial sin autorización previa y por escrito.
                    </p>
                </div>

                <div>
                    <h2 class="text-xs font-bold uppercase tracking-[0.15em] text-primary mb-3">05</h2>
                    <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-4">Responsabilidad</h3>
                    <p class="text-neutral-600 dark:text-neutral-400 leading-relaxed">
                        NidoReal S.L. no se hace responsable de los daños y perjuicios que pudieran derivarse de la utilización del sitio web, incluyendo errores u omisiones en los contenidos, la falta de disponibilidad del sitio web o la transmisión de virus o programas maliciosos, a pesar de haber adoptado todas las medidas tecnológicas necesarias para evitarlo.
                    </p>
                </div>

                <div>
                    <h2 class="text-xs font-bold uppercase tracking-[0.15em] text-primary mb-3">06</h2>
                    <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-4">Hipervínculos y sitios web de terceros</h3>
                    <p class="text-neutral-600 dark:text-neutral-400 leading-relaxed">
                        El sitio web puede contener enlaces a páginas de terceros. NidoReal S.L. no asume ninguna responsabilidad por el contenido, informaciones o servicios que figuren en los sitios de terceros, que tendrán exclusivamente carácter informativo.
                    </p>
                </div>

                <div>
                    <h2 class="text-xs font-bold uppercase tracking-[0.15em] text-primary mb-3">07</h2>
                    <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-4">Legislación aplicable y jurisdicción</h3>
                    <p class="text-neutral-600 dark:text-neutral-400 leading-relaxed">
                        Las relaciones entre NidoReal S.L. y el usuario se rigen por la normativa española vigente, siendo competentes para resolver cualquier controversia los Juzgados y Tribunales de Madrid, salvo que la normativa aplicable establezca otro fuero imperativo.
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
                    <a href="{{ route('pages.cookies') }}" class="text-sm font-semibold text-neutral-500 dark:text-neutral-400 hover:text-primary transition-colors">
                        {{ __('Política de cookies') }}
                    </a>
                </div>
            </div>

        </div>
    </div>

@endsection
