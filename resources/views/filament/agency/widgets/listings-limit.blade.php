@php
    $data = $this->getData();
    $isUnlimited = $data['isUnlimited'] ?? false;
    $percentage = $data['percentage'] ?? 0;

    $color = match(true) {
        $percentage >= 100 => '#ef4444', // red
        $percentage >= 90  => '#f97316', // orange
        $percentage >= 70  => '#eab308', // yellow
        default            => '#22c55e', // green
    };
@endphp

<x-filament-widgets::widget>
    <x-filament::section>
        @if($isUnlimited)
            <div style="display:flex; justify-content:space-between; align-items:center;">
                <span style="font-size:13px; color:#9ca3af;">
                    {{ __('cabinet.listings_limit_title') }}
                </span>
                <span style="font-size:12px; font-weight:700; color:#22c55e; background:#22c55e20; padding:4px 10px; border-radius:9999px;">
                    Plan Ilimitado ✓
                </span>
            </div>
        @else
            {{-- Title and counter --}}
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                <span style="font-size:13px; color:#9ca3af;">
                    {{ __('cabinet.listings_limit_title') }}
                </span>
                <span style="font-size:13px; font-weight:700; color:{{ $color }};">
                    {{ $data['used'] }} / {{ $data['limit'] }}
                    <span style="font-weight:400; color:#9ca3af;">({{ $percentage }}%)</span>
                </span>
            </div>

            {{-- Progress bar --}}
            <div style="width:100%; background:#1f2937; border-radius:9999px; height:8px; overflow:hidden;">
                <div style="width:{{ $percentage }}%; background:{{ $color }}; height:8px; border-radius:9999px; transition:width 0.5s ease;"></div>
            </div>

            {{-- Status --}}
            <div style="margin-top:10px;">
                @if($percentage >= 100)
                    <div style="display:flex; align-items:center; justify-content:space-between; gap:6px; font-size:12px; color:{{ $color }};">
                        <span style="display:flex; align-items:center; gap:4px;">
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            {{ __('cabinet.limit_reached') }}
                        </span>
                        <a href="{{ route('billing.plans') }}"
                           style="font-size:11px; font-weight:bold; color:#fff; background-color:#ef4444; padding:4px 10px; border-radius:6px; text-decoration:none; transition:opacity 0.2s;"
                           onmouseover="this.style.opacity='0.8'"
                           onmouseout="this.style.opacity='1'">
                            Actualizar plan &rarr;
                        </a>
                    </div>
                @elseif($percentage >= 90)
                    <p style="font-size:12px; color:{{ $color }};">
                        ⚠️ {{ __('cabinet.limit_almost_reached') }}
                    </p>
                @elseif($percentage >= 70)
                    <p style="font-size:12px; color:{{ $color }};">
                        ⚠️ Estás al {{ $percentage }}% de tu plan
                    </p>
                @else
                    <p style="font-size:12px; color:{{ $color }};">
                        ✓ {{ __('cabinet.listings_available', ['count' => $data['limit'] - $data['used']]) }}
                    </p>
                @endif
            </div>
        @endif
    </x-filament::section>
</x-filament-widgets::widget>
