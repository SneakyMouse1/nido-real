@extends('layouts.public')

@section('title', __('Política de Privacidad — NidoReal'))
@section('description', __('Lee nuestra política de privacidad y conoce cómo protegemos tus datos personales en
    NidoReal.'))

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
                    {{ __('Política de Privacidad') }}
                </h1>
                <p class="text-sm text-neutral-500 dark:text-neutral-400">
                    {{ __('Última actualización') }}: <time datetime="2025-05-01">1 de mayo de 2025</time>
                </p>
            </div>
        </div>

        {{-- Content --}}
        <div class="max-w-3xl mx-auto px-6 lg:px-10 py-14 lg:py-20">

            {{-- Lead --}}
            <p
                class="text-lg text-neutral-600 dark:text-neutral-400 leading-relaxed mb-14 pb-10 border-b border-neutral-100 dark:border-neutral-800">
                En NidoReal nos comprometemos a proteger y respetar tu privacidad. Esta política explica cómo recopilamos,
                usamos y protegemos tu información personal cuando utilizas nuestra plataforma.
            </p>

            {{-- Sections --}}
            <div class="space-y-12">

                <div>
                    <h2 class="text-xs font-bold uppercase tracking-[0.15em] text-primary mb-3">01</h2>
                    <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-4">Responsable del tratamiento</h3>
                    <p class="text-neutral-600 dark:text-neutral-400 leading-relaxed">
                        NidoReal S.L., con domicilio en Calle Gran Vía, 1, 28013 Madrid, España, es el responsable del
                        tratamiento de los datos personales recogidos a través de este sitio web.
                    </p>
                </div>

                <div>
                    <h2 class="text-xs font-bold uppercase tracking-[0.15em] text-primary mb-3">02</h2>
                    <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-4">Datos que recopilamos</h3>
                    <p class="text-neutral-600 dark:text-neutral-400 leading-relaxed mb-4">
                        Podemos recopilar los siguientes tipos de información personal:
                    </p>
                    <ul class="space-y-2.5">
                        @foreach (['Nombre y apellidos', 'Dirección de correo electrónico', 'Número de teléfono', 'Datos de navegación y uso de la plataforma', 'Información sobre propiedades de interés'] as $item)
                            <li class="flex items-start gap-3 text-neutral-600 dark:text-neutral-400">
                                <span class="mt-1.5 w-1.5 h-1.5 rounded-full bg-primary shrink-0"></span>
                                {{ $item }}
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div>
                    <h2 class="text-xs font-bold uppercase tracking-[0.15em] text-primary mb-3">03</h2>
                    <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-4">Finalidad del tratamiento</h3>
                    <p class="text-neutral-600 dark:text-neutral-400 leading-relaxed mb-4">
                        Los datos recopilados se utilizan para los siguientes fines:
                    </p>
                    <ul class="space-y-2.5">
                        @foreach (['Gestión de tu cuenta de usuario', 'Prestación de los servicios de búsqueda y publicación de inmuebles', 'Comunicación de novedades y actualizaciones (previo consentimiento)', 'Mejora de la experiencia de usuario y análisis estadístico', 'Cumplimiento de obligaciones legales'] as $item)
                            <li class="flex items-start gap-3 text-neutral-600 dark:text-neutral-400">
                                <span class="mt-1.5 w-1.5 h-1.5 rounded-full bg-primary shrink-0"></span>
                                {{ $item }}
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div>
                    <h2 class="text-xs font-bold uppercase tracking-[0.15em] text-primary mb-3">04</h2>
                    <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-4">Base jurídica del tratamiento</h3>
                    <p class="text-neutral-600 dark:text-neutral-400 leading-relaxed">
                        El tratamiento de tus datos se basa en el consentimiento expreso que nos otorgas al registrarte, en
                        la ejecución del contrato de servicios y en el cumplimiento de las obligaciones legales que nos
                        resultan de aplicación conforme al RGPD y la LOPDGDD.
                    </p>
                </div>

                <div>
                    <h2 class="text-xs font-bold uppercase tracking-[0.15em] text-primary mb-3">05</h2>
                    <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-4">Conservación de los datos</h3>
                    <p class="text-neutral-600 dark:text-neutral-400 leading-relaxed">
                        Conservaremos tus datos personales mientras mantengas una cuenta activa en NidoReal o mientras sean
                        necesarios para la prestación de los servicios. Una vez que solicites la eliminación de tu cuenta,
                        procederemos a eliminar o anonimizar tus datos en un plazo máximo de 30 días, salvo que debamos
                        conservarlos por obligación legal.
                    </p>
                </div>

                <div>
                    <h2 class="text-xs font-bold uppercase tracking-[0.15em] text-primary mb-3">06</h2>
                    <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-5">Tus derechos</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @foreach ([['Acceso', 'Conoce qué datos personales tratamos sobre ti.'], ['Rectificación', 'Corrige datos inexactos o incompletos.'], ['Supresión', 'Solicita la eliminación de tus datos.'], ['Oposición', 'Oponte al tratamiento de tus datos.'], ['Portabilidad', 'Recibe tus datos en formato estructurado.'], ['Limitación', 'Solicita la restricción del tratamiento.']] as [$right, $desc])
                            <div
                                class="rounded-xl border border-neutral-100 dark:border-neutral-800 p-4 bg-neutral-50 dark:bg-neutral-900">
                                <p class="text-sm font-bold text-neutral-900 dark:text-white mb-1">{{ $right }}</p>
                                <p class="text-sm text-neutral-500 dark:text-neutral-400">{{ $desc }}</p>
                            </div>
                        @endforeach
                    </div>
                    <p class="mt-5 text-sm text-neutral-600 dark:text-neutral-400 leading-relaxed">
                        Para ejercer tus derechos, escríbenos a <a href="mailto:privacidad@nidoreal.es"
                            class="text-primary hover:underline font-medium">privacidad@nidoreal.es</a>. También puedes
                        presentar una reclamación ante la Agencia Española de Protección de Datos (AEPD).
                    </p>
                </div>

                <div>
                    <h2 class="text-xs font-bold uppercase tracking-[0.15em] text-primary mb-3">07</h2>
                    <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-4">Comunicación a terceros</h3>
                    <p class="text-neutral-600 dark:text-neutral-400 leading-relaxed">
                        NidoReal no cede ni vende tus datos personales a terceros, salvo que sea necesario para la
                        prestación del servicio (por ejemplo, pasarelas de pago o proveedores de alojamiento) o cuando
                        exista una obligación legal.
                    </p>
                </div>

                <div>
                    <h2 class="text-xs font-bold uppercase tracking-[0.15em] text-primary mb-3">08</h2>
                    <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-4">Seguridad</h3>
                    <p class="text-neutral-600 dark:text-neutral-400 leading-relaxed">
                        Aplicamos medidas técnicas y organizativas adecuadas para proteger tus datos personales frente a
                        accesos no autorizados, pérdidas o destrucción, conforme a los estándares del sector.
                    </p>
                </div>

                <div>
                    <h2 class="text-xs font-bold uppercase tracking-[0.15em] text-primary mb-3">09</h2>
                    <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-4">Contacto</h3>
                    <p class="text-neutral-600 dark:text-neutral-400 leading-relaxed">
                        Si tienes alguna pregunta sobre esta política o sobre el tratamiento de tus datos, contacta con
                        nosotros en <a href="mailto:privacidad@nidoreal.es"
                            class="text-primary hover:underline font-medium">privacidad@nidoreal.es</a>.
                    </p>
                </div>

            </div>

            {{-- Footer nav --}}
            <div class="mt-16 pt-10 border-t border-neutral-200 dark:border-neutral-800">
                <div class="flex flex-wrap items-center gap-6">
                    <a href="{{ route('home') }}"
                        class="inline-flex items-center gap-1.5 text-sm font-semibold text-neutral-500 dark:text-neutral-400 hover:text-primary transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5m7-7l-7 7 7 7" />
                        </svg>
                        {{ __('Inicio') }}
                    </a>
                    <a href="{{ route('pages.aviso-legal') }}"
                        class="text-sm font-semibold text-neutral-500 dark:text-neutral-400 hover:text-primary transition-colors">
                        {{ __('Aviso legal') }}
                    </a>
                    <a href="{{ route('pages.cookies') }}"
                        class="text-sm font-semibold text-neutral-500 dark:text-neutral-400 hover:text-primary transition-colors">
                        {{ __('Política de cookies') }}
                    </a>
                </div>
            </div>

        </div>
    </div>

@endsection
