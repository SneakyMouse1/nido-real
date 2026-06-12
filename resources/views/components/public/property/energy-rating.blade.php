@props(['certificate'])

@php
    /**
     * Display an EU energy certificate rating scale (A–G + Pending/Exempt).
     * The active certificate is highlighted with full opacity, a bright ring and a label.
     * All others are dimmed.
     */

    // Ratings in scale order (A = best, G = worst)
    $ratings = [
        ['key' => 'A', 'label' => 'A', 'color' => '#00A651', 'width' => '55%'],
        ['key' => 'B', 'label' => 'B', 'color' => '#4CAF50', 'width' => '62%'],
        ['key' => 'C', 'label' => 'C', 'color' => '#8BC34A', 'width' => '69%'],
        ['key' => 'D', 'label' => 'D', 'color' => '#FFEB3B', 'width' => '76%', 'dark' => true],
        ['key' => 'E', 'label' => 'E', 'color' => '#FF9800', 'width' => '83%'],
        ['key' => 'F', 'label' => 'F', 'color' => '#FF5722', 'width' => '91%'],
        ['key' => 'G', 'label' => 'G', 'color' => '#F44336', 'width' => '100%'],
    ];

    // Normalize current certificate value
    $activeKey = $certificate instanceof \App\Enums\EnergyCertificate ? $certificate->value : (string) $certificate;

    // Non-scale statuses (Pending / Exempt)
    $nonScale = in_array($activeKey, ['pending', 'exempt']);
    $badgeText = match ($activeKey) {
        'pending' => __('En trámite'),
        'exempt' => __('Exento'),
        default => null,
    };
@endphp

@if (!$certificate)
    {{-- Nothing to render --}}
@else
    <section class="mb-8">
        <h2 class="text-xl font-bold text-neutral-900 dark:text-white mb-4">
            {{ __('Certificado Energético') }}
        </h2>

        <div
            class="bg-white dark:bg-neutral-900 border border-neutral-100 dark:border-neutral-800 rounded-2xl shadow-sm p-6">

            @if ($nonScale)
                {{-- Pending / Exempt badge --}}
                <div class="flex items-center gap-3">
                    <span
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-neutral-100 dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300 font-semibold text-sm border border-neutral-200 dark:border-neutral-700">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 110 20A10 10 0 0112 2z" />
                        </svg>
                        {{ $badgeText }}
                    </span>
                </div>
            @else
                {{-- Rating scale --}}
                <div class="space-y-1.5">
                    @foreach ($ratings as $rating)
                        @php
                            $isActive = $rating['key'] === $activeKey;
                            $isDarkText = $rating['dark'] ?? false;
                            $textColor = $isDarkText ? '#333' : '#fff';
                        @endphp

                        <div class="flex items-center gap-3">
                            {{-- Arrow bar --}}
                            <div style="
                                    width: {{ $rating['width'] }};
                                    background-color: {{ $rating['color'] }};
                                    opacity: {{ $isActive ? '1' : '0.25' }};
                                    clip-path: polygon(0 0, calc(100% - 14px) 0, 100% 50%, calc(100% - 14px) 100%, 0 100%);
                                    transition: opacity 0.2s;
                                    box-shadow: -4px 4px 0px 0px rgba(0,0,0,0.8);
                                "
                                class="h-9 flex items-center px-4 shrink-0">
                                <span
                                    style="color: {{ $textColor }}; font-size: 1rem; font-weight: 800; line-height: 1;">{{ $rating['label'] }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Legend --}}
                <p class="mt-4 text-xs text-neutral-400 dark:text-neutral-500 flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 110 20A10 10 0 0112 2z" />
                    </svg>
                    {{ __('Clasificación energética oficial según normativa EU') }}
                </p>
            @endif
        </div>
    </section>
@endif
