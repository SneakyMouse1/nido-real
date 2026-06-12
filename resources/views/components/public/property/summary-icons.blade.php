@props(['property'])

@php
    $items = [];

    // ID
    if ($property->property_code) {
        $items[] = [
            'label' => __('ID'),
            'value' => $property->property_code,
            'icon' =>
                '<path stroke-linecap="round" stroke-linejoin="round" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />',
        ];
    }

    // Tipo
    if ($property->propertyType) {
        $items[] = [
            'label' => __('Tipo'),
            'value' => $property->propertyType->name,
            'icon' =>
                '<path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />',
        ];
    }

    // Dormitorios
    if ($property->bedrooms) {
        $items[] = [
            'label' => __('Dormitorios'),
            'value' => $property->bedrooms,
            'icon' =>
                '<path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 11V9a2 2 0 012-2h14a2 2 0 012 2v2M3 11h18M3 11v8m18-8v8M8 21v-2m8 2v-2" />',
        ];
    }

    // Baños
    if ($property->bathrooms) {
        $items[] = [
            'label' => __('Baños'),
            'value' => $property->bathrooms,
            'icon' =>
                '<path stroke-linecap="round" stroke-linejoin="round" d="M12 2v2M8 4V2M16 4V2m-9 6h10a2 2 0 012 2v10a2 2 0 01-2 2H7a2 2 0 01-2-2V10a2 2 0 012-2h10" />',
        ];
    }

    // Sup. Total
    if ($property->area_total) {
        $items[] = [
            'label' => __('Sup. total'),
            'value' => $property->area_total . ' m²',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M4 4h16v16H4V4zm4 4h8v8H8V8z" />',
        ];
    }

    // Sup. Útil
    if ($property->area_useful) {
        $items[] = [
            'label' => __('Sup. útil'),
            'value' => $property->area_useful . ' m²',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 4h6m-6 0v16m6-16v16M4 9v6m16-6v6M4 9H2m18 0h2M4 15H2m18 0h2" />',
        ];
    }

    // Planta
    if ($property->floor_number !== null && $property->floor_number !== '') {
        $items[] = [
            'label' => __('Planta'),
            'value' => is_string($property->floor_number) ? __($property->floor_number) : $property->floor_number,
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M3 6h18M3 14h18M3 18h18" />',
        ];
    }

    // Año
    if ($property->year_built) {
        $items[] = [
            'label' => __('Año'),
            'value' => $property->year_built,
            'icon' =>
                '<path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />',
        ];
    }

    // Garaje
    if ($property->has_garage) {
        $items[] = [
            'label' => __('Garaje'),
            'value' => __('Incluido'),
            'icon' =>
                '<path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8H8m4-4v8m-4 8h8M5.5 16h13l-1.5-8h-10l-1.5 8z" />',
        ];
    }

    // Trastero
    if ($property->has_storage) {
        $items[] = [
            'label' => __('Trastero'),
            'value' => __('Incluido'),
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M20 7H4a2 2 0 00-2 2v10a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2zm-9 9v-4m4 4v-4" />',
        ];
    }

    // Gastos de comunidad
    if ($property->community_fees) {
        $items[] = [
            'label' => __('Comunidad'),
            'value' => number_format($property->community_fees, 0, ',', '.') . ' €' . __('/mes'),
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z" />',
        ];
    }

    // Certificado energético
    if ($property->energy_certificate) {
        $items[] = [
            'label' => __('Energía'),
            'value' => method_exists($property->energy_certificate, 'getLabel')
                ? $property->energy_certificate->getLabel()
                : $property->energy_certificate->value,
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />',
        ];
    }

    // Orientación
    if ($property->orientation) {
        $items[] = [
            'label' => __('Orientación'),
            'value' => method_exists($property->orientation, 'getLabel')
                ? $property->orientation->getLabel()
                : $property->orientation->value,
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />',
        ];
    }
@endphp


@if (count($items) > 0)
    <section class="mb-8">
        <h2 class="text-xl font-bold text-neutral-900 dark:text-white mb-4">{{ __('Resumen') }}</h2>
        <div
            class="grid grid-cols-2 md:grid-cols-4 gap-4 bg-neutral-50 dark:bg-neutral-800/50 border border-neutral-100 dark:border-neutral-800 rounded-2xl p-5 sm:p-6 shadow-sm">
            @foreach ($items as $item)
                <div class="group flex items-center gap-3 p-3 rounded-xl transition-colors cursor-default">

                    <div
                        class="w-12 h-12 shrink-0 flex items-center justify-center border border-neutral-200 dark:border-neutral-800 rounded-lg text-primary bg-white dark:bg-neutral-900 transition-colors group-hover:bg-primary group-hover:text-white group-hover:border-primary">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            {!! $item['icon'] !!}
                        </svg>
                    </div>

                    <div class="flex flex-col">
                        <span
                            class="text-sm text-neutral-500 dark:text-neutral-400 font-medium pb-0.5">{{ $item['label'] }}:
                        </span>
                        <span class="text-base font-bold text-neutral-900 dark:text-white truncate"
                            title="{{ $item['value'] }}">
                            {{ $item['value'] }}
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endif
