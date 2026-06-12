{{-- resources/views/components/public/footer.blade.php --}}
<footer class="bg-neutral-900 dark:bg-neutral-950 text-white">
    <div class="max-w-[1840px] mx-auto px-6 lg:px-10 py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 pb-12 border-b border-white/10">

            {{-- Brand --}}
            <div>
                <a href="{{ route('home') }}" class="inline-block mb-5">
                    <x-public.logo class="h-[38px] w-auto brightness-0 invert" />
                </a>
                <p class="text-white/50 text-sm leading-relaxed max-w-xs">
                    {{ __('Tu plataforma inmobiliaria de confianza en España. Conectamos compradores, vendedores y agencias.') }}
                </p>
                {{-- Newsletter --}}
                <div class="mt-6">
                    <p class="text-sm font-semibold text-white/70 mb-3">{{ __('Suscríbase a nuestro boletín') }}</p>
                    <div class="flex bg-white/10 rounded-full overflow-hidden">
                        <input type="email" placeholder="{{ __('Introduzca su email') }}"
                            class="flex-1 bg-transparent px-5 py-2.5 text-sm text-white placeholder-white/30 outline-none">
                        <button
                            class="w-10 h-10 m-0.5 bg-accent rounded-full flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 20 20">
                                <path
                                    d="M15.63 5v8.13a.63.63 0 01-1.25 0V6.51L5.44 15.44a.63.63 0 01-.88-.88L13.49 5.63H6.88a.63.63 0 010-1.26H15A.63.63 0 0115.63 5z"
                                    fill="white" />
                            </svg>
                        </button>
                    </div>
                    <p class="text-xs text-white/30 mt-3 leading-relaxed">
                        {{ __('Al hacer clic en «Suscribirse», acepta los Términos del servicio y la Política de privacidad.') }}
                    </p>
                </div>
            </div>

            {{-- Empresa --}}
            <div>
                <h4 class="text-xs font-bold uppercase tracking-widest text-white/40 mb-5">{{ __('Empresa') }}</h4>
                <ul class="space-y-3">
                    @foreach ([
                        __('Sobre nosotros') => route('pages.nosotros'),
                        __('Agencias') => route('agencies.index'),
                        __('Blog') => '#',
                        __('Tarifas') => route('pages.tarifas'),
                        __('Contacto') => route('pages.contacto'),
                    ] as $label => $url)
                        <li>
                            <a href="{{ $url }}"
                                class="text-sm text-white/60 hover:text-white transition-colors">
                                {{ $label }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Propiedades --}}
            <div>
                <h4 class="text-xs font-bold uppercase tracking-widest text-white/40 mb-5">{{ __('Propiedades') }}</h4>
                <ul class="space-y-3">
                    @foreach ([
                        __('Pisos en venta') => route('properties.index', ['deal_type' => 'sale']),
                        __('Casas en venta') => route('properties.index', ['deal_type' => 'sale']),
                        __('Pisos en alquiler') => route('properties.index', ['deal_type' => 'rent']),
                        __('Villas') => '#',
                        __('Locales') => '#',
                    ] as $label => $url)
                        <li>
                            <a href="{{ $url }}"
                                class="text-sm text-white/60 hover:text-white transition-colors">
                                {{ $label }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Legal --}}
            <div>
                <h4 class="text-xs font-bold uppercase tracking-widest text-white/40 mb-5">{{ __('Legal') }}</h4>
                <ul class="space-y-3">
                    @foreach ([
                        __('Política de privacidad') => route('pages.privacidad'),
                        __('Aviso legal')            => route('pages.aviso-legal'),
                        __('Política de cookies')    => route('pages.cookies'),
                        __('FAQ')                    => route('pages.faq'),
                    ] as $label => $url)
                        <li>
                            <a href="{{ $url }}" class="text-sm text-white/60 hover:text-white transition-colors">
                                {{ $label }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        {{-- Bottom --}}
        <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p class="text-sm text-white/40">
                <span class="text-white/60 mr-1">©{{ date('Y') }}</span>
                {{ __('Nido Real. Todos derechos reservados') }}
            </p>
            <div class="flex items-center gap-5">
                <a href="#" class="text-white/40 hover:text-white transition-colors" aria-label="Facebook">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12 2.25C6.62 2.25 2.25 6.62 2.25 12S6.62 21.75 12 21.75 21.75 17.38 21.75 12 17.38 2.25 12 2.25zm.75 17.97V14.25H15a.75.75 0 000-1.5h-2.25v-2.25A1.5 1.5 0 0114.25 9h1.5a.75.75 0 000-1.5h-1.5a3 3 0 00-3 3v2.25H9a.75.75 0 000 1.5h2.25v5.97a9.75 9.75 0 110-19.44v.02a9.75 9.75 0 010 19.44v-.02z" />
                    </svg>
                </a>
                <a href="#" class="text-white/40 hover:text-white transition-colors" aria-label="Instagram">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12 7.5a4.5 4.5 0 100 9 4.5 4.5 0 000-9zM12 15a3 3 0 110-6 3 3 0 010 6zm4.5-9.75a1.125 1.125 0 100 2.25 1.125 1.125 0 000-2.25zM16.5 2.25h-9A5.25 5.25 0 002.25 7.5v9A5.25 5.25 0 007.5 21.75h9a5.25 5.25 0 005.25-5.25v-9A5.25 5.25 0 0016.5 2.25zm3.75 14.25a3.75 3.75 0 01-3.75 3.75h-9a3.75 3.75 0 01-3.75-3.75v-9A3.75 3.75 0 017.5 3.75h9a3.75 3.75 0 013.75 3.75v9z" />
                    </svg>
                </a>
                <a href="#" class="text-white/40 hover:text-white transition-colors" aria-label="YouTube">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M21.97 6.52a2.76 2.76 0 00-1.94-1.95C18.25 4.5 12 4.5 12 4.5s-6.25 0-8.03.07A2.76 2.76 0 002.03 6.52 28.9 28.9 0 001.5 12a28.9 28.9 0 00.53 5.48 2.76 2.76 0 001.94 1.95C5.75 19.5 12 19.5 12 19.5s6.25 0 8.03-.07a2.76 2.76 0 001.94-1.95A28.9 28.9 0 0022.5 12a28.9 28.9 0 00-.53-5.48zM10.13 15.09V8.91L15.75 12l-5.62 3.09z" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</footer>
