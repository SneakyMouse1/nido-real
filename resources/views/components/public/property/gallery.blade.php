{{-- resources/views/components/public/property/gallery.blade.php --}}
{{-- Props: $property (App\Models\Property), $photos (MediaLibrary collection) --}}
@props(['property', 'photos'])

<section x-data="propertyGallery({{ $photos->count() }})" @keydown.escape.window="videoOpen = false"
    class="relative bg-neutral-100 dark:bg-neutral-900 h-[55vh] md:h-[60vh] lg:h-[65vh]">

    @if ($photos->count())

        {{-- ── SWIPER CONTAINER ─────────────────────────────── --}}
        <div class="swiper property-gallery-swiper w-full h-full" x-ref="swiperContainer">
            <div class="swiper-wrapper">
                @foreach ($photos as $i => $photo)
                    <div class="swiper-slide">
                        <img src="{{ $photo->getUrl('large') }}" alt="{{ $property->title }} — foto {{ $i + 1 }}"
                            data-fancybox="property-gallery" data-src="{{ $photo->getUrl('large') }}"
                            data-caption="{{ $property->title }} — {{ $i + 1 }} / {{ $photos->count() }}"
                            class="w-full h-full object-cover" @if ($i > 0) loading="lazy" @endif>
                    </div>
                @endforeach
            </div>

            {{-- Swiper nav --}}
            <div class="swiper-button-prev property-gallery-prev" x-ref="prevBtn"></div>
            <div class="swiper-button-next property-gallery-next" x-ref="nextBtn"></div>

            {{-- Dots --}}
            <div class="swiper-pagination property-gallery-pagination" x-ref="pagination"></div>
        </div>

        {{-- PEEK OVERLAYS --}}
        <div class="hidden lg:block absolute left-0 top-0 h-full w-[8%] pointer-events-none z-10"
            style="background: linear-gradient(to right, rgba(10,10,10,0.40), transparent);"></div>
        <div class="hidden lg:block absolute right-0 top-0 h-full w-[8%] pointer-events-none z-10"
            style="background: linear-gradient(to left, rgba(10,10,10,0.40), transparent);"></div>

        {{-- BOTTOM GRADIENT --}}
        <div
            class="absolute inset-0 bg-gradient-to-t from-neutral-900/65 via-transparent to-transparent pointer-events-none z-10">
        </div>

        {{-- BOTTOM BAR: buttons + counter --}}
        <div
            class="absolute bottom-0 left-0 right-0 z-20 px-4 pb-5 flex items-center justify-between lg:justify-center">

            <div class="flex items-center gap-2">
                @if ($property->video_url)
                    <button @click="videoOpen = true"
                        class="flex items-center gap-2 bg-neutral-900/80 hover:bg-neutral-800 text-white text-sm font-semibold px-4 py-2.5 rounded-md transition-colors duration-200 cursor-pointer">
                        <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M8 5v14l11-7z" />
                        </svg>
                        <span class="hidden sm:inline">{{ __('Video') }}</span>
                    </button>
                @endif
                @if ($photos->count() > 1)
                    <button @click="$dispatch('open-lightbox')"
                        class="flex items-center gap-2 bg-neutral-900/80 hover:bg-neutral-800 text-white text-sm font-semibold px-4 py-2.5 rounded-md transition-colors duration-200 cursor-pointer">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M6 8a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span class="hidden sm:inline">{{ __('Ver todas las fotos') }}</span>
                    </button>
                @endif
            </div>

            {{-- Counter — desktop only --}}
            <div id="gallery-counter" x-ref="counter"
                class="hidden lg:flex items-center bg-neutral-900/60 text-white text-xs font-semibold px-3 py-1.5 rounded-full lg:absolute lg:right-4">
                1 / {{ $photos->count() }}
            </div>
        </div>
    @else
        {{-- Placeholder when no photos --}}
        <div class="absolute inset-0 flex items-center justify-center">
            <svg class="w-20 h-20 text-neutral-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                stroke-width="1">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M6 8a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
        </div>

    @endif

    {{-- VIDEO MODAL --}}
    @if ($property->video_url)
        <div x-show="videoOpen" x-transition:enter="transition duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 bg-neutral-950/90 backdrop-blur-sm flex items-center justify-center p-4"
            @click.self="videoOpen = false" style="display: none;">
            <div class="relative w-full max-w-4xl aspect-video bg-neutral-900 rounded-2xl overflow-hidden shadow-2xl">
                <template x-if="videoOpen">
                    <iframe src="{{ $property->embed_video_url }}" class="w-full h-full" frameborder="0"
                        allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                </template>
                <button @click="videoOpen = false"
                    class="absolute top-3 right-3 w-9 h-9 bg-neutral-900/80 hover:bg-neutral-800 rounded-full flex items-center justify-center text-white transition-colors cursor-pointer"
                    aria-label="{{ __('Cerrar video') }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    @endif

</section>



<style>
    /* Override Fancybox default zoom cursor — swiper handles its own grab cursor */
    .property-gallery-swiper [data-fancybox] {
        cursor: inherit;
    }

    /* ── Nav arrows: hidden on mobile, styled on desktop ── */
    .property-gallery-prev,
    .property-gallery-next {
        display: none;
    }

    @media (min-width: 1024px) {

        .property-gallery-prev,
        .property-gallery-next {
            display: flex;
            width: 52px;
            height: 52px;
            border-radius: 10px;
            background: #C75B39;
            color: white;
            transition: background 0.2s, transform 0.15s;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.15);
        }

        .property-gallery-prev svg,
        .property-gallery-next svg {
            width: 32px;
            height: 32px;
        }

        .property-gallery-prev:hover,
        .property-gallery-next:hover {
            background: #B84E30;
            transform: scale(1.1);
        }

        .property-gallery-prev::after,
        .property-gallery-next::after {
            font-size: 16px;
            font-weight: 800;
        }

        .property-gallery-prev {
            left: 80px !important;
            right: auto !important;
        }

        .property-gallery-next {
            right: 80px !important;
            left: auto !important;
        }
    }

    /* ── Dots: mobile only, above bottom bar ── */
    .property-gallery-pagination {
        bottom: 56px !important;
    }

    @media (min-width: 1024px) {
        .property-gallery-pagination {
            display: none !important;
        }
    }

    .property-gallery-pagination .swiper-pagination-bullet {
        background: rgba(255, 255, 255, 0.45);
        opacity: 1;
        width: 8px;
        height: 8px;
        transition: all 0.25s;
    }

    .property-gallery-pagination .swiper-pagination-bullet-active {
        background: white;
        width: 20px;
        border-radius: 4px;
    }
</style>
