@extends('public.user.layout')

@php
    $isEdit = !is_null($property);
    $pageTitle = ($isEdit ? __('Editar Propiedad') : __('Nueva Propiedad')) . ' — NidoReal';
    $formRoute = $isEdit ? route('user.properties.update', $property) : route('user.properties.store');

    // Helper to get old/model value.
    $val = fn(string $field, $default = '') => old(
        $field,
        (function () use ($field, $default, $property) {
            $raw = $property?->{$field} ?? $default;
            return $raw instanceof \BackedEnum ? $raw->value : $raw;
        })(),
    );
@endphp

@section('user-content')

    <div class="bg-white dark:bg-neutral-900 rounded-2xl border border-neutral-200 dark:border-neutral-800 overflow-hidden">

        {{-- Header --}}
        <div class="px-6 py-5 border-b border-neutral-100 dark:border-neutral-800 flex items-center gap-3">
            <a href="{{ route('user.properties.index') }}" class="text-neutral-400 hover:text-primary transition-colors">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <path d="m15 18-6-6 6-6" />
                </svg>
            </a>
            <div>
                <h1 class="text-xl font-bold text-neutral-900 dark:text-white">
                    {{ $isEdit ? __('Editar Propiedad') : __('Nueva Propiedad') }}
                </h1>
                <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-0.5">
                    {{ __('Se enviará a revisión antes de publicarse') }}
                </p>
            </div>
        </div>

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div
                class="mx-6 mt-6 p-4 rounded-xl bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 text-red-600 dark:text-red-400 text-sm">
                <ul class="list-disc pl-4 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ $formRoute }}" enctype="multipart/form-data" class="p-6 space-y-8">
            @csrf
            @if ($isEdit)
                @method('PUT')
            @endif

            {{-- ═══ SECTION: Basic info ══════════════════════════════ --}}
            <div>
                <h2 class="text-sm font-bold uppercase tracking-widest text-neutral-400 dark:text-neutral-500 mb-4">
                    {{ __('Información básica') }}
                </h2>
                <div class="space-y-4">

                    {{-- Title --}}
                    <div>
                        <label for="title" class="block text-sm font-bold text-neutral-900 dark:text-white mb-1.5">
                            {{ __('Título del anuncio') }} <span class="text-red-500">*</span>
                        </label>
                        <input id="title" name="title" type="text" required value="{{ $val('title') }}"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors"
                            placeholder="{{ __('Piso luminoso en el centro de Madrid') }}">
                    </div>

                    {{-- Type + Deal --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="property_type_id"
                                class="block text-sm font-bold text-neutral-900 dark:text-white mb-1.5">
                                {{ __('Tipo de inmueble') }} <span class="text-red-500">*</span>
                            </label>
                            <select id="property_type_id" name="property_type_id" required
                                class="w-full px-3.5 py-2.5 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors">
                                <option value="">{{ __('Seleccionar...') }}</option>
                                @foreach ($propertyTypes as $type)
                                    <option value="{{ $type->id }}" @selected($val('property_type_id') == $type->id)>
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="deal_type" class="block text-sm font-bold text-neutral-900 dark:text-white mb-1.5">
                                {{ __('Tipo de operación') }} <span class="text-red-500">*</span>
                            </label>
                            <select id="deal_type" name="deal_type" required
                                class="w-full px-3.5 py-2.5 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors">
                                <option value="sale" @selected($val('deal_type', $property?->deal_type?->value) === 'sale')>{{ __('Venta') }}</option>
                                <option value="rent" @selected($val('deal_type', $property?->deal_type?->value) === 'rent')>{{ __('Alquiler') }}</option>
                            </select>
                        </div>
                    </div>

                    {{-- Description --}}
                    <div>
                        <label for="description" class="block text-sm font-bold text-neutral-900 dark:text-white mb-1.5">
                            {{ __('Descripción') }}
                        </label>
                        <textarea id="description" name="description" rows="5"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors resize-y"
                            placeholder="{{ __('Describe la propiedad: características destacadas, estado, entorno...') }}">{{ $val('description') }}</textarea>
                    </div>
                </div>
            </div>

            <hr class="border-neutral-100 dark:border-neutral-800">

            {{-- SECTION: Price & Characteristics --}}
            <div>
                <h2 class="text-sm font-bold uppercase tracking-widest text-neutral-400 dark:text-neutral-500 mb-4">
                    {{ __('Precio y características') }}
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

                    <div>
                        <label for="price" class="block text-sm font-bold text-neutral-900 dark:text-white mb-1.5">
                            {{ __('Precio (€)') }} <span class="text-red-500">*</span>
                        </label>
                        <input id="price" name="price" type="number" required min="1"
                            value="{{ $val('price') }}"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors">
                    </div>

                    <div>
                        <label for="area_total" class="block text-sm font-bold text-neutral-900 dark:text-white mb-1.5">
                            {{ __('Superficie total (m²)') }} <span class="text-red-500">*</span>
                        </label>
                        <input id="area_total" name="area_total" type="number" required min="1"
                            value="{{ $val('area_total') }}"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors">
                    </div>

                    <div>
                        <label for="area_useful" class="block text-sm font-bold text-neutral-900 dark:text-white mb-1.5">
                            {{ __('Superficie útil (m²)') }}
                        </label>
                        <input id="area_useful" name="area_useful" type="number" min="1"
                            value="{{ $val('area_useful') }}"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors">
                    </div>

                    <div>
                        <label for="bedrooms" class="block text-sm font-bold text-neutral-900 dark:text-white mb-1.5">
                            {{ __('Habitaciones') }}
                        </label>
                        <input id="bedrooms" name="bedrooms" type="number" min="0"
                            value="{{ $val('bedrooms', 0) }}"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors">
                    </div>

                    <div>
                        <label for="bathrooms" class="block text-sm font-bold text-neutral-900 dark:text-white mb-1.5">
                            {{ __('Baños') }}
                        </label>
                        <input id="bathrooms" name="bathrooms" type="number" min="0"
                            value="{{ $val('bathrooms', 0) }}"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors">
                    </div>

                    <div>
                        <label for="toilets" class="block text-sm font-bold text-neutral-900 dark:text-white mb-1.5">
                            {{ __('Aseos') }}
                        </label>
                        <input id="toilets" name="toilets" type="number" min="0"
                            value="{{ $val('toilets', 0) }}"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors">
                    </div>

                    <div>
                        <label for="floor_number" class="block text-sm font-bold text-neutral-900 dark:text-white mb-1.5">
                            {{ __('Planta') }}
                        </label>
                        <input id="floor_number" name="floor_number" type="text" value="{{ $val('floor_number') }}"
                            placeholder="{{ __('Ej. Bajo, 1, Ático') }}"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors">
                    </div>

                    <div>
                        <label for="total_floors" class="block text-sm font-bold text-neutral-900 dark:text-white mb-1.5">
                            {{ __('Plantas del edificio') }}
                        </label>
                        <input id="total_floors" name="total_floors" type="number" min="1"
                            value="{{ $val('total_floors') }}"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors">
                    </div>

                    <div>
                        <label for="year_built" class="block text-sm font-bold text-neutral-900 dark:text-white mb-1.5">
                            {{ __('Año de construcción') }}
                        </label>
                        <input id="year_built" name="year_built" type="number" min="1800"
                            max="{{ date('Y') }}" value="{{ $val('year_built') }}"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors">
                    </div>

                    <div>
                        <label for="community_fees"
                            class="block text-sm font-bold text-neutral-900 dark:text-white mb-1.5">
                            {{ __('Gastos de comunidad (€/mes)') }}
                        </label>
                        <input id="community_fees" name="community_fees" type="number" min="0" step="0.01"
                            value="{{ $val('community_fees') }}"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors">
                    </div>

                    <div>
                        <label for="ibi_tax" class="block text-sm font-bold text-neutral-900 dark:text-white mb-1.5">
                            {{ __('IBI anual (€/año)') }}
                        </label>
                        <input id="ibi_tax" name="ibi_tax" type="number" min="0" step="0.01"
                            value="{{ $val('ibi_tax') }}"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors">
                    </div>
                </div>

                {{-- Booleans --}}
                <div class="flex flex-wrap gap-5 mt-4">
                    <label class="flex items-center gap-2 cursor-pointer select-none">
                        <input type="checkbox" name="has_garage" value="1" @checked($val('has_garage'))
                            class="rounded border-neutral-300 dark:border-neutral-600 text-primary focus:ring-primary">
                        <span
                            class="text-sm font-semibold text-neutral-700 dark:text-neutral-300">{{ __('Garaje incluido') }}</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer select-none">
                        <input type="checkbox" name="has_storage" value="1" @checked($val('has_storage'))
                            class="rounded border-neutral-300 dark:border-neutral-600 text-primary focus:ring-primary">
                        <span
                            class="text-sm font-semibold text-neutral-700 dark:text-neutral-300">{{ __('Trastero') }}</span>
                    </label>
                </div>
            </div>

            <hr class="border-neutral-100 dark:border-neutral-800">

            {{-- SECTION: Features --}}
            <div>
                <h2 class="text-sm font-bold uppercase tracking-widest text-neutral-400 dark:text-neutral-500 mb-4">
                    {{ __('Comodidades y características') }}
                </h2>
                <div class="space-y-6">
                    @foreach ($features as $category => $categoryFeatures)
                        <div>
                            <h3
                                class="text-xs font-bold uppercase text-neutral-400 dark:text-neutral-500 mb-3 border-b border-neutral-100 dark:border-neutral-800/50 pb-1">
                                {{ \App\Enums\FeatureCategory::from($category)->label(app()->getLocale()) }}
                            </h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                                @foreach ($categoryFeatures as $feature)
                                    <label class="flex items-center gap-2.5 cursor-pointer select-none group">
                                        <input type="checkbox" name="features[]" value="{{ $feature->id }}"
                                            @checked(in_array($feature->id, old('features', $isEdit ? $property->features->pluck('id')->toArray() : [])))
                                            class="rounded border-neutral-300 dark:border-neutral-600 text-primary focus:ring-primary">
                                        <span
                                            class="text-sm text-neutral-700 dark:text-neutral-300 group-hover:text-neutral-900 dark:group-hover:text-white transition-colors">
                                            {{ $feature->name }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <hr class="border-neutral-100 dark:border-neutral-800">

            {{-- SECTION: Photos --}}
            <div x-data="{
                files: [],
                addFiles(e) {
                    const selectedFiles = Array.from(e.target.files);
                    const existingCount = {{ $isEdit ? $property->getMedia('photos')->count() : 0 }};
                    const deletedCount = Array.from(document.querySelectorAll('input[name=\'delete_photos[]\']:checked')).length;
                    const remainingLimit = 10 - (existingCount - deletedCount);
            
                    if (selectedFiles.length > remainingLimit) {
                        alert('{{ __('Puedes subir un máximo de 10 fotografías en total.') }}');
                        e.target.value = '';
                        return;
                    }
            
                    this.files = selectedFiles.map(file => ({
                        name: file.name,
                        url: URL.createObjectURL(file)
                    }));
                }
            }">
                <h2 class="text-sm font-bold uppercase tracking-widest text-neutral-400 dark:text-neutral-500 mb-4">
                    {{ __('Fotografías') }}
                </h2>

                {{-- Existing Photos --}}
                @if ($isEdit && $property->getMedia('photos')->count() > 0)
                    <div class="mb-6">
                        <p class="text-xs font-bold text-neutral-500 dark:text-neutral-400 mb-3">
                            {{ __('Imágenes actuales (marca las que deseas eliminar):') }}
                        </p>
                        <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-5 gap-4">
                            @foreach ($property->getMedia('photos') as $media)
                                <div x-data="{ checked: false }"
                                    class="relative group rounded-xl overflow-hidden border border-neutral-200 dark:border-neutral-800 aspect-[3/2] transition-all"
                                    :class="checked ? 'opacity-40 border-red-500 ring-2 ring-red-500' : ''">
                                    <img src="{{ $media->getUrl('thumb') }}" alt="Photo"
                                        class="w-full h-full object-cover">
                                    <div
                                        class="absolute inset-0 bg-neutral-950/60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                        <label class="flex items-center gap-1.5 text-white cursor-pointer select-none">
                                            <input type="checkbox" name="delete_photos[]" value="{{ $media->id }}"
                                                @change="checked = $el.checked"
                                                class="rounded text-red-600 focus:ring-red-500 border-white/50">
                                            <span class="text-xs font-bold">{{ __('Eliminar') }}</span>
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Upload Area --}}
                <div class="flex justify-center items-center w-full">
                    <label
                        class="flex flex-col justify-center items-center w-full h-32 bg-neutral-50 dark:bg-neutral-900 rounded-2xl border-2 border-dashed border-neutral-200 dark:border-neutral-800 hover:bg-neutral-100/50 dark:hover:bg-neutral-850/50 cursor-pointer transition-colors">
                        <div class="flex flex-col justify-center items-center pt-5 pb-6">
                            <svg class="w-8 h-8 text-neutral-400 mb-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                                </path>
                            </svg>
                            <p class="mb-1 text-sm font-bold text-neutral-700 dark:text-neutral-300">
                                {{ __('Añadir fotos') }}
                            </p>
                            <p class="text-xs text-neutral-500 dark:text-neutral-400">
                                {{ __('Formatos: JPG, PNG, WEBP (máx. 10 fotos, 5MB por archivo)') }}
                            </p>
                        </div>
                        <input type="file" name="photos[]" multiple accept="image/jpeg,image/png,image/webp"
                            class="hidden" @change="addFiles">
                    </label>
                </div>

                {{-- Local Preview --}}
                <template x-if="files.length > 0">
                    <div class="mt-6">
                        <p class="text-xs font-bold text-neutral-500 dark:text-neutral-400 mb-3">
                            {{ __('Nuevas fotos seleccionadas para subir:') }}
                        </p>
                        <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-5 gap-4">
                            <template x-for="(file, index) in files" :key="index">
                                <div
                                    class="relative rounded-xl overflow-hidden border border-neutral-200 dark:border-neutral-800 aspect-[3/2]">
                                    <img :src="file.url" class="w-full h-full object-cover">
                                    <div class="absolute bottom-0 inset-x-0 bg-neutral-950/70 py-1 px-2">
                                        <p class="text-[10px] text-white truncate font-semibold" x-text="file.name"></p>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>
            </div>

            <hr class="border-neutral-100 dark:border-neutral-800">

            {{-- SECTION: Location --}}
            <div>
                <h2 class="text-sm font-bold uppercase tracking-widest text-neutral-400 dark:text-neutral-500 mb-4">
                    {{ __('Ubicación') }}
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                    <div class="sm:col-span-2">
                        <label for="address_line" class="block text-sm font-bold text-neutral-900 dark:text-white mb-1.5">
                            {{ __('Dirección') }}
                        </label>
                        <input id="address_line" name="address_line" type="text" value="{{ $val('address_line') }}"
                            placeholder="{{ __('Calle, número, piso...') }}"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors">
                    </div>

                    <div>
                        <label for="city" class="block text-sm font-bold text-neutral-900 dark:text-white mb-1.5">
                            {{ __('Ciudad') }} <span class="text-red-500">*</span>
                        </label>
                        <input id="city" name="city" type="text" required value="{{ $val('city') }}"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors">
                    </div>

                    <div>
                        <label for="province" class="block text-sm font-bold text-neutral-900 dark:text-white mb-1.5">
                            {{ __('Provincia') }} <span class="text-red-500">*</span>
                        </label>
                        <input id="province" name="province" type="text" required value="{{ $val('province') }}"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors">
                    </div>

                    <div>
                        <label for="zip_code" class="block text-sm font-bold text-neutral-900 dark:text-white mb-1.5">
                            {{ __('Código postal') }}
                        </label>
                        <input id="zip_code" name="zip_code" type="text" maxlength="10"
                            value="{{ $val('zip_code') }}"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors">
                    </div>

                    <div>
                        <label for="neighborhood" class="block text-sm font-bold text-neutral-900 dark:text-white mb-1.5">
                            {{ __('Barrio / Urbanización') }}
                        </label>
                        <input id="neighborhood" name="neighborhood" type="text" value="{{ $val('neighborhood') }}"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors">
                    </div>

                    <div class="flex items-center gap-2 pt-2">
                        <label class="flex items-center gap-2 cursor-pointer select-none">
                            <input type="checkbox" name="hide_exact_address" value="1" @checked($val('hide_exact_address'))
                                class="rounded border-neutral-300 dark:border-neutral-600 text-primary focus:ring-primary">
                            <span
                                class="text-sm font-semibold text-neutral-700 dark:text-neutral-300">{{ __('Ocultar dirección exacta') }}</span>
                        </label>
                    </div>
                </div>
            </div>

            <hr class="border-neutral-100 dark:border-neutral-800">

            {{-- SECTION: Extra (optional) --}}
            <div>
                <h2 class="text-sm font-bold uppercase tracking-widest text-neutral-400 dark:text-neutral-500 mb-4">
                    {{ __('Información adicional (opcional)') }}
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                    <div>
                        <label for="energy_certificate"
                            class="block text-sm font-bold text-neutral-900 dark:text-white mb-1.5">
                            {{ __('Certificado energético') }}
                        </label>
                        <select id="energy_certificate" name="energy_certificate"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors">
                            <option value="">{{ __('No indicado') }}</option>
                            @foreach (\App\Enums\EnergyCertificate::cases() as $case)
                                <option value="{{ $case->value }}" @selected($val('energy_certificate') === $case->value)>
                                    {{ $case->getLabel() }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="orientation" class="block text-sm font-bold text-neutral-900 dark:text-white mb-1.5">
                            {{ __('Orientación') }}
                        </label>
                        <select id="orientation" name="orientation"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors">
                            <option value="">{{ __('No indicada') }}</option>
                            @foreach (\App\Enums\Orientation::cases() as $case)
                                <option value="{{ $case->value }}" @selected($val('orientation') === $case->value)>
                                    {{ $case->getLabel() }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="video_url" class="block text-sm font-bold text-neutral-900 dark:text-white mb-1.5">
                            {{ __('URL de vídeo (YouTube, Vimeo...)') }}
                        </label>
                        <input id="video_url" name="video_url" type="url" value="{{ $val('video_url') }}"
                            placeholder="https://youtube.com/watch?v=..."
                            class="w-full px-3.5 py-2.5 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-900 dark:text-white text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors">
                    </div>
                </div>
            </div>

            {{-- Notice --}}
            <div
                class="flex items-start gap-3 p-4 rounded-xl bg-blue-50 dark:bg-blue-500/10 border border-blue-100 dark:border-blue-500/20 text-sm text-blue-700 dark:text-blue-400">
                <svg class="w-5 h-5 shrink-0 mt-0.5" xmlns="http://www.w3.org/2000/svg" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10" />
                    <path d="M12 16v-4" />
                    <path d="M12 8h.01" />
                </svg>
                <span>{{ __('Tu propiedad será revisada por nuestro equipo antes de aparecer en el sitio.') }}</span>
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-between pt-2 border-t border-neutral-100 dark:border-neutral-800">
                <a href="{{ route('user.properties.index') }}"
                    class="text-sm font-semibold text-neutral-500 hover:text-neutral-700 dark:hover:text-neutral-300 transition-colors">
                    {{ __('Cancelar') }}
                </a>
                <button type="submit"
                    class="bg-accent hover:bg-accent/90 text-white font-bold px-6 py-2.5 rounded-xl text-sm transition-colors">
                    {{ $isEdit ? __('Guardar cambios') : __('Enviar para revisión') }}
                </button>
            </div>
        </form>
    </div>

@endsection
