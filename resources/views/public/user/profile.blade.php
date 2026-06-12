@extends('public.user.layout')

@php $pageTitle = __('Mi Cuenta') . ' — NidoReal'; @endphp

@section('user-content')

    {{--  MY PROPERTIES --}}
    <div
        class="bg-white dark:bg-neutral-900 rounded-2xl border border-neutral-200 dark:border-neutral-800 overflow-hidden mb-6">

        <div class="px-6 py-5 border-b border-neutral-100 dark:border-neutral-800 flex items-center justify-between">
            <div>
                <h2 class="text-lg font-bold text-neutral-900 dark:text-white">{{ __('Mis Propiedades') }}</h2>
                <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-0.5">{{ __('Máximo 2 por cuenta personal') }}</p>
            </div>
            @if ($properties->count() < 2)
                <a href="{{ route('user.properties.create') }}"
                    class="flex items-center gap-1.5 text-sm font-bold text-accent hover:text-accent/80 transition-colors">
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor"
                        stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <line x1="12" x2="12" y1="5" y2="19" />
                        <line x1="5" x2="19" y1="12" y2="12" />
                    </svg>
                    {{ __('Añadir') }}
                </a>
            @endif
        </div>

        <div class="p-5">
            @if ($properties->isEmpty())
                <div class="text-center py-8">
                    <svg class="w-10 h-10 text-neutral-200 dark:text-neutral-700 mx-auto mb-3"
                        xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="1.5"
                        viewBox="0 0 24 24">
                        <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                        <polyline points="9 22 9 12 15 12 15 22" />
                    </svg>
                    <p class="text-sm text-neutral-400 dark:text-neutral-500 mb-3">
                        {{ __('Todavía no tienes propiedades.') }}</p>
                    <a href="{{ route('user.properties.create') }}" class="text-sm font-bold text-accent hover:underline">
                        {{ __('Añadir primera propiedad →') }}
                    </a>
                </div>
            @else
                <div class="space-y-3">
                    @foreach ($properties as $property)
                        @php
                            $sc = match ($property->status->value) {
                                'pending' => [
                                    'label' => __('Pendiente'),
                                    'cls' => 'bg-amber-100 dark:bg-amber-500/10 text-amber-700 dark:text-amber-400',
                                ],
                                'published' => [
                                    'label' => __('Publicada'),
                                    'cls' => 'bg-green-100 dark:bg-green-500/10 text-green-700 dark:text-green-400',
                                ],
                                'rejected' => [
                                    'label' => __('Rechazada'),
                                    'cls' => 'bg-red-100 dark:bg-red-500/10 text-red-700 dark:text-red-400',
                                ],
                                default => [
                                    'label' => $property->status->getLabel(),
                                    'cls' => 'bg-neutral-100 dark:bg-neutral-800 text-neutral-500',
                                ],
                            };
                        @endphp
                        <div
                            class="flex items-center gap-4 p-4 border border-neutral-100 dark:border-neutral-800 rounded-xl">
                            {{-- Thumb --}}
                            <div class="w-16 h-12 rounded-lg overflow-hidden bg-neutral-100 dark:bg-neutral-800 shrink-0">
                                @if ($property->hasMedia('photos'))
                                    <img src="{{ $property->getFirstMediaUrl('photos', 'thumb') }}"
                                        alt="{{ $property->title }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg class="w-5 h-5 text-neutral-300 dark:text-neutral-600"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor"
                                            stroke-width="1.5" viewBox="0 0 24 24">
                                            <rect width="18" height="18" x="3" y="3" rx="2" />
                                            <circle cx="9" cy="9" r="2" />
                                            <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21" />
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            {{-- Info --}}
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 flex-wrap mb-0.5">
                                    <span
                                        class="text-[11px] font-bold px-2 py-0.5 rounded-full {{ $sc['cls'] }}">{{ $sc['label'] }}</span>
                                </div>
                                <p class="text-sm font-semibold text-neutral-900 dark:text-white truncate">
                                    {{ $property->title }}</p>
                                <p class="text-xs text-neutral-400 dark:text-neutral-500">
                                    {{ number_format($property->price, 0, ',', '.') }} €</p>

                                @if ($property->rejection_reason)
                                    <p class="text-xs text-red-500 mt-1 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" viewBox="0 0 24 24">
                                            <circle cx="12" cy="12" r="10" />
                                            <line x1="12" x2="12" y1="8" y2="12" />
                                            <line x1="12" x2="12.01" y1="16" y2="16" />
                                        </svg>
                                        {{ $property->rejection_reason }}
                                    </p>
                                @endif
                            </div>

                            {{-- Actions --}}
                            <div class="flex items-center gap-2 shrink-0">
                                <a href="{{ route('user.properties.edit', $property) }}"
                                    class="text-xs font-bold px-3 py-1.5 rounded-lg bg-neutral-100 dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-200 dark:hover:bg-neutral-700 transition-colors">
                                    {{ __('Editar') }}
                                </a>
                                <form method="POST" action="{{ route('user.properties.destroy', $property) }}"
                                    onsubmit="return confirm('{{ __('¿Eliminar esta propiedad?') }}')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="text-xs font-bold px-3 py-1.5 rounded-lg bg-red-50 dark:bg-red-500/10 text-red-500 hover:bg-red-100 dark:hover:bg-red-500/20 transition-colors">
                                        {{ __('Borrar') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4">
                    <a href="{{ route('user.properties.index') }}"
                        class="text-sm font-semibold text-primary hover:underline">
                        {{ __('Ver todas →') }}
                    </a>
                </div>
            @endif
        </div>
    </div>

    {{--  FAVORITES --}}
    <div class="bg-white dark:bg-neutral-900 rounded-2xl border border-neutral-200 dark:border-neutral-800 overflow-hidden">

        <div class="px-6 py-5 border-b border-neutral-100 dark:border-neutral-800 flex items-center justify-between">
            <div>
                <h2 class="text-lg font-bold text-neutral-900 dark:text-white">{{ __('Favoritos') }}</h2>
                <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-0.5">{{ __('Propiedades guardadas') }}</p>
            </div>
            @if ($favorites->total() > 0)
                <a href="{{ route('user.favorites') }}" class="text-sm font-bold text-primary hover:underline">
                    {{ __('Ver todas →') }}
                </a>
            @endif
        </div>

        <div class="p-5">
            @if ($favorites->isEmpty())
                <div class="text-center py-8">
                    <svg class="w-10 h-10 text-neutral-200 dark:text-neutral-700 mx-auto mb-3"
                        xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="1.5"
                        viewBox="0 0 24 24">
                        <path
                            d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z" />
                    </svg>
                    <p class="text-sm text-neutral-400 dark:text-neutral-500">{{ __('No tienes propiedades favoritas.') }}
                    </p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach ($favorites as $property)
                        <div class="flex gap-3 p-3 border border-neutral-100 dark:border-neutral-800 rounded-xl group"
                            x-data="favoriteCard({ url: '{{ route('user.favorites.toggle', $property) }}' })" x-show="!removing"
                            x-transition:leave="transition ease-in duration-300"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
                            <a href="{{ route('properties.show', ['slug' => $property->slug]) }}"
                                class="w-20 h-16 rounded-lg overflow-hidden bg-neutral-100 dark:bg-neutral-800 shrink-0">
                                @if ($property->hasMedia('photos'))
                                    <img src="{{ $property->getFirstMediaUrl('photos', 'thumb') }}"
                                        alt="{{ $property->title }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                @endif
                            </a>
                            <div class="flex-1 min-w-0">
                                <a href="{{ route('properties.show', ['slug' => $property->slug]) }}"
                                    class="text-sm font-semibold text-neutral-900 dark:text-white hover:text-primary transition-colors line-clamp-1">
                                    {{ $property->title }}
                                </a>
                                <p class="text-xs text-neutral-400 dark:text-neutral-500 mt-0.5">{{ $property->city }}</p>
                                <p class="text-sm font-bold text-accent mt-1">
                                    {{ number_format($property->price, 0, ',', '.') }} €</p>
                            </div>
                            <button type="button" :disabled="removing" @click="remove()"
                                class="text-red-400 hover:text-red-500 transition-colors p-1 rounded-lg hover:bg-red-50 dark:hover:bg-red-500/10 cursor-pointer self-start"
                                title="{{ __('Quitar de favoritos') }}">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z" />
                                </svg>
                            </button>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

@endsection
