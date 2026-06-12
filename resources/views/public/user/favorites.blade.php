@extends('public.user.layout')

@php $pageTitle = __('Favoritos') . ' — NidoReal'; @endphp

@section('user-content')

    <div class="bg-white dark:bg-neutral-900 rounded-2xl border border-neutral-200 dark:border-neutral-800 overflow-hidden">

        <div class="px-6 py-5 border-b border-neutral-100 dark:border-neutral-800 flex items-center justify-between">
            <div>
                <h1 class="text-xl font-bold text-neutral-900 dark:text-white">{{ __('Favoritos') }}</h1>
                <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-0.5">{{ __('Propiedades que has guardado') }}</p>
            </div>
            <span
                class="px-3 py-1 rounded-full bg-neutral-100 dark:bg-neutral-800 text-xs font-bold text-neutral-600 dark:text-neutral-300">
                {{ $favorites->total() }}
            </span>
        </div>

        <div class="p-6">
            @if ($favorites->isEmpty())
                <div class="text-center py-16">
                    <svg class="w-12 h-12 text-neutral-300 dark:text-neutral-700 mx-auto mb-4"
                        xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="1.5"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                    </svg>
                    <p class="text-neutral-500 dark:text-neutral-400 text-sm">
                        {{ __('Aún no tienes propiedades favoritas.') }}</p>
                    <a href="{{ route('properties.index') }}"
                        class="inline-block mt-4 text-sm font-bold text-primary hover:underline">
                        {{ __('Explorar propiedades') }}
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-5" id="favorites-grid">
                    @foreach ($favorites as $property)
                        {{-- Logic lives in resources/js/components/favoriteCard.js --}}
                        <div class="group border border-neutral-100 dark:border-neutral-800 rounded-2xl overflow-hidden hover:shadow-md transition-shadow"
                            x-data="favoriteCard({ url: '{{ route('user.favorites.toggle', $property) }}' })" x-show="!removing" x-transition:leave="transition ease-in duration-300"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">

                            {{-- Image --}}
                            <a href="{{ route('properties.show', ['slug' => $property->slug]) }}"
                                class="block aspect-4/3 overflow-hidden bg-neutral-100 dark:bg-neutral-800">
                                @if ($property->hasMedia('photos'))
                                    <img src="{{ $property->getFirstMediaUrl('photos', 'thumb') }}"
                                        alt="{{ $property->title }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg class="w-10 h-10 text-neutral-300 dark:text-neutral-600"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor"
                                            stroke-width="1.5" viewBox="0 0 24 24">
                                            <rect width="18" height="18" x="3" y="3" rx="2" ry="2" />
                                            <circle cx="9" cy="9" r="2" />
                                            <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21" />
                                        </svg>
                                    </div>
                                @endif
                            </a>

                            {{-- Info --}}
                            <div class="p-4">
                                <p class="text-xs text-neutral-400 dark:text-neutral-500 mb-1">{{ $property->city }},
                                    {{ $property->province }}</p>
                                <a href="{{ route('properties.show', ['slug' => $property->slug]) }}"
                                    class="text-sm font-bold text-neutral-900 dark:text-white hover:text-primary transition-colors line-clamp-1">
                                    {{ $property->title }}
                                </a>
                                <p class="text-base font-bold text-accent mt-1">
                                    {{ number_format($property->price, 0, ',', '.') }} €
                                </p>

                                <button type="button" :disabled="removing" @click="remove()"
                                    class="mt-3 text-xs text-red-500 hover:text-red-600 font-semibold transition-colors flex items-center gap-1 cursor-pointer">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z" />
                                    </svg>
                                    <span
                                        x-text="removing ? '{{ __('Quitando...') }}' : '{{ __('Quitar de favoritos') }}'"></span>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $favorites->links() }}
                </div>
            @endif
        </div>

    </div>

@endsection
