@extends('public.user.layout')

@php $pageTitle = __('Mis Propiedades') . ' — NidoReal'; @endphp

@section('user-content')

    <div class="bg-white dark:bg-neutral-900 rounded-2xl border border-neutral-200 dark:border-neutral-800 overflow-hidden">

        <div class="px-6 py-5 border-b border-neutral-100 dark:border-neutral-800 flex items-center justify-between">
            <div>
                <h1 class="text-xl font-bold text-neutral-900 dark:text-white">{{ __('Mis Propiedades') }}</h1>
                <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-0.5">{{ __('Máximo 2 propiedades por cuenta personal') }}</p>
            </div>
            @if ($properties->count() < 2)
                <a href="{{ route('user.properties.create') }}"
                    class="flex items-center gap-2 bg-accent hover:bg-accent/90 text-white font-bold text-sm px-4 py-2.5 rounded-xl transition-colors">
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><line x1="12" x2="12" y1="5" y2="19"/><line x1="5" x2="19" y1="12" y2="12"/></svg>
                    {{ __('Añadir propiedad') }}
                </a>
            @else
                <span class="text-xs font-semibold text-neutral-400 dark:text-neutral-500 px-3 py-1.5 rounded-xl bg-neutral-100 dark:bg-neutral-800">
                    {{ __('Límite alcanzado') }}
                </span>
            @endif
        </div>

        <div class="p-6">
            @if ($properties->isEmpty())
                <div class="text-center py-16">
                    <svg class="w-12 h-12 text-neutral-300 dark:text-neutral-700 mx-auto mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                    <p class="text-neutral-500 dark:text-neutral-400 text-sm mb-4">{{ __('Todavía no has publicado ninguna propiedad.') }}</p>
                    <a href="{{ route('user.properties.create') }}"
                        class="inline-flex items-center gap-2 bg-accent hover:bg-accent/90 text-white font-bold text-sm px-5 py-2.5 rounded-xl transition-colors">
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><line x1="12" x2="12" y1="5" y2="19"/><line x1="5" x2="19" y1="12" y2="12"/></svg>
                        {{ __('Añadir primera propiedad') }}
                    </a>
                </div>
            @else
                <div class="space-y-4">
                    @foreach ($properties as $property)
                        @php
                            $statusConfig = match ($property->status->value) {
                                'pending'   => ['label' => __('Pendiente de revisión'), 'color' => 'bg-amber-100 dark:bg-amber-500/10 text-amber-700 dark:text-amber-400'],
                                'published' => ['label' => __('Publicada'),             'color' => 'bg-green-100 dark:bg-green-500/10 text-green-700 dark:text-green-400'],
                                'rejected'  => ['label' => __('Rechazada'),             'color' => 'bg-red-100 dark:bg-red-500/10 text-red-700 dark:text-red-400'],
                                'draft'     => ['label' => __('Borrador'),              'color' => 'bg-neutral-100 dark:bg-neutral-800 text-neutral-500 dark:text-neutral-400'],
                                default     => ['label' => $property->status->getLabel(), 'color' => 'bg-neutral-100 dark:bg-neutral-800 text-neutral-500 dark:text-neutral-400'],
                            };
                        @endphp

                        <div class="border border-neutral-100 dark:border-neutral-800 rounded-2xl p-5 flex flex-col sm:flex-row gap-4">
                            {{-- Thumbnail --}}
                            <div class="w-full sm:w-32 h-24 rounded-xl overflow-hidden bg-neutral-100 dark:bg-neutral-800 shrink-0">
                                @if ($property->hasMedia('photos'))
                                    <img src="{{ $property->getFirstMediaUrl('photos', 'thumb') }}"
                                        alt="{{ $property->title }}"
                                        class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg class="w-7 h-7 text-neutral-300 dark:text-neutral-600" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><rect width="18" height="18" x="3" y="3" rx="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
                                    </div>
                                @endif
                            </div>

                            {{-- Info --}}
                            <div class="flex-1 min-w-0">
                                <div class="flex flex-wrap items-start gap-2 mb-1">
                                    <span class="text-xs font-bold px-2.5 py-1 rounded-full {{ $statusConfig['color'] }}">
                                        {{ $statusConfig['label'] }}
                                    </span>
                                </div>

                                <h3 class="text-sm font-bold text-neutral-900 dark:text-white truncate">{{ $property->title }}</h3>
                                <p class="text-xs text-neutral-400 dark:text-neutral-500 mt-0.5">{{ $property->city }}, {{ $property->province }}</p>
                                <p class="text-sm font-bold text-accent mt-1">{{ number_format($property->price, 0, ',', '.') }} €</p>

                                {{-- Rejection reason box --}}
                                @if ($property->rejection_reason)
                                    <div class="mt-3 flex items-start gap-2 p-3 rounded-xl bg-red-50 dark:bg-red-500/10 border border-red-100 dark:border-red-500/20">
                                        <svg class="w-4 h-4 text-red-500 shrink-0 mt-0.5" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                                        <div>
                                            <p class="text-xs font-bold text-red-600 dark:text-red-400 mb-0.5">{{ __('Motivo del rechazo:') }}</p>
                                            <p class="text-xs text-red-600 dark:text-red-400">{{ $property->rejection_reason }}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            {{-- Actions --}}
                            <div class="flex sm:flex-col gap-2 sm:items-end justify-end">
                                <a href="{{ route('user.properties.edit', $property) }}"
                                    class="text-xs font-bold text-neutral-700 dark:text-neutral-300 bg-neutral-100 dark:bg-neutral-800 hover:bg-neutral-200 dark:hover:bg-neutral-700 px-3 py-2 rounded-lg transition-colors">
                                    {{ __('Editar') }}
                                </a>
                                <form method="POST" action="{{ route('user.properties.destroy', $property) }}"
                                    onsubmit="return confirm('{{ __('¿Estás seguro de que deseas eliminar esta propiedad?') }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-xs font-bold text-red-500 bg-red-50 dark:bg-red-500/10 hover:bg-red-100 dark:hover:bg-red-500/20 px-3 py-2 rounded-lg transition-colors">
                                        {{ __('Eliminar') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

@endsection
