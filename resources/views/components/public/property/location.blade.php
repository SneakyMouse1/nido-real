{{-- Props: $property (App\Models\Property) --}}
@props(['property'])

<section class="mb-10">
    <h2 class="text-xl font-bold text-neutral-900 dark:text-white mb-4">{{ __('Dirección') }}</h2>

    @if (!$property->hide_exact_address && $property->address_line)
        <p class="text-sm font-medium text-neutral-600 dark:text-neutral-400 mb-3 flex items-center gap-1.5">
            <svg class="w-4 h-4 text-primary shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
            </svg>
            {{ $property->address_line }}, {{ $property->city }}, {{ $property->province }}
        </p>
    @endif

    @if ($property->latitude && $property->longitude)
        {{-- data-* attributes are read by initPropertyMap() in app.js --}}
        <div id="property-map"
            class="h-[320px] w-full rounded-2xl overflow-hidden shadow-sm border border-neutral-200 dark:border-neutral-700"
            data-lat="{{ $property->latitude }}"
            data-lng="{{ $property->longitude }}"
            data-label="{{ e($property->hide_exact_address ? $property->city : ($property->address_line ?: $property->city)) }}">
        </div>
    @else
        <div class="h-[320px] w-full bg-neutral-100 dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-2xl overflow-hidden relative shadow-sm flex items-center justify-center">
            <div class="text-center text-neutral-500 dark:text-neutral-400">
                <svg class="w-10 h-10 mx-auto mb-2 opacity-40" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                </svg>
                <p class="text-sm font-medium">{{ $property->address_line ?: $property->city }}</p>
            </div>
        </div>
    @endif
</section>
