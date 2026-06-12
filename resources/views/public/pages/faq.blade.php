@extends('layouts.public')

@section('title', __('Preguntas Frecuentes — NidoReal'))
@section('description',
    __('Resolvemos tus dudas sobre cómo comprar, alquilar o publicar propiedades en NidoReal. Todo
    lo que necesitas saber sobre nuestra plataforma.'))

@section('navbar')
    <x-public.navbar :floating="false" />
@endsection

@section('content')

    @php
        $categories = [
            [
                'icon' =>
                    '<path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>',
                'label' => 'Búsqueda y propiedades',
                'items' => [
                    [
                        'q' => '¿Cómo puedo buscar propiedades en NidoReal?',
                        'a' =>
                            'Puedes buscar propiedades usando la barra de búsqueda en la página de inicio o accediendo directamente a la sección "Inmuebles". Filtra por ciudad, tipo de operación (compra o alquiler), precio, número de habitaciones, superficie y más. Nuestros filtros avanzados te ayudan a encontrar exactamente lo que buscas.',
                    ],
                    [
                        'q' => '¿Puedo guardar propiedades en favoritos?',
                        'a' =>
                            'Sí. Crea una cuenta gratuita y haz clic en el icono de corazón en cualquier propiedad para añadirla a tu lista de favoritos. Accede a tus favoritos en cualquier momento desde tu perfil de usuario en la sección "Mi cuenta".',
                    ],
                    [
                        'q' => '¿Las propiedades publicadas están verificadas?',
                        'a' =>
                            'Todas las propiedades publicadas en NidoReal son revisadas por nuestro equipo antes de ser aprobadas. Trabajamos únicamente con agencias inmobiliarias registradas y verificadas, lo que garantiza la veracidad de la información publicada. Si encuentras algún anuncio sospechoso, puedes reportarlo directamente desde la página de la propiedad.',
                    ],
                ],
            ],
            [
                'icon' =>
                    '<path stroke-linecap="round" stroke-linejoin="round" d="M3 12l9-9 9 9M5 10v9a1 1 0 001 1h4v-5h4v5h4a1 1 0 001-1v-9"/>',
                'label' => 'Publicación de anuncios',
                'items' => [
                    [
                        'q' => '¿Cómo puedo publicar mi propiedad en NidoReal?',
                        'a' =>
                            'Para publicar una propiedad necesitas registrarte como propietario o agencia. Una vez verificada tu cuenta, accede a tu panel de control y haz clic en "Nueva propiedad". Completa todos los campos, sube fotos de calidad y envía el anuncio para revisión. Nuestro equipo lo aprobará en un plazo de 24-48 horas laborables.',
                    ],
                    [
                        'q' => '¿Cuántas fotos puedo subir por propiedad?',
                        'a' =>
                            'El número de fotos depende del plan contratado. El plan Starter permite hasta 10 fotos, el plan Pro hasta 30, y el plan Unlimited no tiene límite. Recomendamos subir al menos 8 fotos de calidad que muestren todas las estancias del inmueble, ya que los anuncios con más fotos reciben hasta un 70% más de visitas.',
                    ],
                    [
                        'q' => '¿Puedo editar mi anuncio después de publicarlo?',
                        'a' =>
                            'Sí, puedes editar tu anuncio en cualquier momento desde el panel de control. Cambios menores como precio o descripción se aplican de inmediato. Si modificas información estructural (superficie, habitaciones, dirección), el anuncio pasará por una nueva revisión antes de volver a publicarse.',
                    ],
                ],
            ],
            [
                'icon' =>
                    '<path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>',
                'label' => 'Agencias y profesionales',
                'items' => [
                    [
                        'q' => '¿Cómo puede unirse mi agencia a NidoReal?',
                        'a' =>
                            'Puedes solicitar el alta de tu agencia a través del formulario de contacto o registrándote directamente como agencia. Nuestro equipo revisará la documentación (licencia de actividad, datos fiscales) y activará tu cuenta en un plazo de 2-3 días laborables. A partir de entonces podrás añadir a tu equipo de agentes y comenzar a publicar propiedades.',
                    ],
                    [
                        'q' => '¿Qué planes y tarifas ofrece NidoReal para agencias?',
                        'a' =>
                            'Ofrecemos tres planes: Starter (hasta 10 propiedades activas), Pro (hasta 50 propiedades) y Unlimited (sin límite de propiedades). Cada plan incluye diferentes niveles de visibilidad, estadísticas y soporte. Consulta la página de Tarifas para ver los precios actualizados y comparar las características de cada plan.',
                    ],
                    [
                        'q' => '¿Puedo gestionar varios agentes bajo una misma cuenta de agencia?',
                        'a' =>
                            'Sí. El panel de agencia permite añadir múltiples agentes a tu equipo. Cada agente tiene su propio acceso y puede gestionar las propiedades que le sean asignadas. El administrador de la agencia mantiene el control total y puede ver la actividad de todos los miembros del equipo.',
                    ],
                ],
            ],
            [
                'icon' =>
                    '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/>',
                'label' => 'Cuenta y seguridad',
                'items' => [
                    [
                        'q' => '¿Es gratuito registrarse en NidoReal?',
                        'a' =>
                            'El registro como usuario es completamente gratuito. Puedes explorar propiedades, guardar favoritos y contactar con agencias sin ningún coste. La publicación de propiedades y el acceso al panel de agencia están sujetos a los planes de suscripción disponibles en la página de Tarifas.',
                    ],
                    [
                        'q' => '¿Cómo puedo recuperar mi contraseña?',
                        'a' =>
                            'En la página de inicio de sesión, haz clic en "¿Olvidaste tu contraseña?". Introduce tu correo electrónico y recibirás un enlace para restablecerla en pocos minutos. Si no recibes el correo, revisa la carpeta de spam o contacta con nuestro soporte en ayuda@nidoreal.es.',
                    ],
                    [
                        'q' => '¿Cómo puedo eliminar mi cuenta?',
                        'a' =>
                            'Puedes eliminar tu cuenta desde la sección "Ajustes" de tu perfil. La eliminación es permanente e irrecuperable. Antes de proceder, asegúrate de descargar cualquier información que necesites conservar. Si tienes propiedades activas, estas también serán eliminadas o desactivadas. El proceso puede tardar hasta 30 días en completarse conforme a nuestra política de privacidad.',
                    ],
                ],
            ],
        ];
    @endphp

    <div class="bg-white dark:bg-neutral-950 min-h-screen">

        {{-- Page Header --}}
        <div class="border-b border-neutral-200 dark:border-neutral-800 bg-neutral-50 dark:bg-neutral-900">
            <div class="max-w-4xl mx-auto px-6 lg:px-10 py-12">
                <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-widest text-primary mb-4">
                    <a href="{{ route('home') }}" class="hover:underline">NidoReal</a>
                    <span class="text-neutral-400">/</span>
                    <span class="text-neutral-500 dark:text-neutral-400">FAQ</span>
                </div>
                <h1 class="text-3xl md:text-4xl font-extrabold text-neutral-900 dark:text-white mb-3">
                    {{ __('Preguntas frecuentes') }}
                </h1>
                <p class="text-base text-neutral-500 dark:text-neutral-400 max-w-xl">
                    {{ __('Todo lo que necesitas saber sobre NidoReal. ¿No encuentras respuesta? Escríbenos.') }}
                </p>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-6 lg:px-10 py-14 lg:py-20">


            {{-- FAQ Categories: 2-column grid --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-10">
                @foreach ($categories as $i => $cat)
                    <div id="cat-{{ $i }}" class="flex flex-col">

                        {{-- Category heading --}}
                        <div class="flex items-center gap-3 mb-5 pb-1">
                            <div
                                class="w-9 h-9 rounded-xl bg-primary/10 dark:bg-primary/15 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                    stroke-width="2">
                                    {!! $cat['icon'] !!}
                                </svg>
                            </div>
                            <h2 class="text-base font-bold text-neutral-900 dark:text-white">{{ $cat['label'] }}</h2>
                        </div>

                        {{-- Accordion items --}}
                        <div
                            class="rounded-2xl border border-neutral-200 dark:border-neutral-800 overflow-hidden divide-y divide-neutral-200 dark:divide-neutral-800">
                            @foreach ($cat['items'] as $j => $item)
                                <div x-data="{ open: false }" class="bg-white dark:bg-neutral-900">
                                    <button @click="open = !open" :aria-expanded="open"
                                        class="w-full flex items-center justify-between gap-4 px-6 py-5 text-left
                                               hover:bg-neutral-50 dark:hover:bg-neutral-800/60
                                               transition-colors group">
                                        <span :class="open ? 'text-primary' : 'text-neutral-900 dark:text-white'"
                                            class="text-sm font-bold leading-snug transition-colors">
                                            {{ $item['q'] }}
                                        </span>
                                        <span
                                            :class="open ? 'bg-primary/10 text-primary' : 'bg-neutral-100 dark:bg-neutral-800 text-neutral-400'"
                                            class="shrink-0 w-7 h-7 rounded-full flex items-center justify-center transition-all duration-200">
                                            <svg x-show="!open" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                            </svg>
                                            <svg x-show="open" style="display:none" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 12h16" />
                                            </svg>
                                        </span>
                                    </button>
                                    <div x-show="open" x-transition:enter="transition ease-out duration-200"
                                        x-transition:enter-start="opacity-0 -translate-y-1"
                                        x-transition:enter-end="opacity-100 translate-y-0"
                                        x-transition:leave="transition ease-in duration-150"
                                        x-transition:leave-start="opacity-100 translate-y-0"
                                        x-transition:leave-end="opacity-0 -translate-y-1" style="display: none;">
                                        <div class="px-6 pb-6 pt-0">
                                            <div class="pl-0 border-l-2 border-primary/30 pl-4">
                                                <p class="text-sm text-neutral-600 dark:text-neutral-400 leading-relaxed">
                                                    {{ $item['a'] }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                @endforeach
            </div>

            {{-- CTA block --}}
            <div
                class="max-w-4xl mx-auto mt-16 rounded-2xl bg-neutral-50 dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 p-8 flex flex-col sm:flex-row items-center gap-6">
                <div
                    class="w-12 h-12 rounded-xl bg-primary/10 dark:bg-primary/15 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                </div>
                <div class="text-center sm:text-left">
                    <p class="text-base font-bold text-neutral-900 dark:text-white mb-1">
                        {{ __('¿No encuentras lo que buscas?') }}
                    </p>
                    <p class="text-sm text-neutral-500 dark:text-neutral-400">
                        {{ __('Nuestro equipo está disponible para ayudarte con cualquier consulta.') }}
                    </p>
                </div>
                <a href="{{ route('pages.contacto') }}"
                    class="btn-primary shrink-0 sm:ml-auto px-6 py-3 font-semibold text-sm whitespace-nowrap">
                    {{ __('Contactar') }}
                </a>
            </div>

        </div>
    </div>

@endsection
