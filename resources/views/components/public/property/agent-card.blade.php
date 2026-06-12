@props(['property', 'sticky' => false])

@php
    $agent = $property->user;
    if (!$agent && !$property->agency) {
        return;
    }

    // Resolve contact_preferences from the property owner (user) or fall back to showing all
    $prefs = $agent?->contact_preferences ?? null;
    // null means no preference set yet → show everything (backwards-compat)
    $showEmail = $prefs === null || in_array('email', $prefs);
    $showPhone = $prefs === null || in_array('phone', $prefs);
    $showWhatsapp = $prefs === null || in_array('whatsapp', $prefs);

    // Fallbacks
    $agentName = $agent ? $agent->name : ($property->agency ? $property->agency->name : __('Agente'));
    $agentPhone =
        $showPhone || $showWhatsapp
            ? ($agent && $agent->phone
                ? $agent->phone
                : ($property->agency
                    ? $property->agency->phone
                    : ''))
            : '';
    $agentEmail = $showEmail
        ? ($agent && $agent->email
            ? $agent->email
            : ($property->agency
                ? $property->agency->email
                : ''))
        : '';

    // WhatsApp
    $whatsappRaw = $agent?->whatsapp ?: $agentPhone;
    $whatsappNumber = preg_replace('/[^0-9]/', '', $whatsappRaw);

    $agentAvatar = $agent && $agent->avatar_path ? Storage::url($agent->avatar_path) : null;

    // Agency Address
    $addressParts = array_filter([
        $property->agency?->address,
        $property->agency?->zip_code,
        $property->agency?->city ?? $property->agency?->province,
    ]);
    $fullAddress = implode(', ', $addressParts);
    $mapUrl = 'https://www.google.com/maps/search/?api=1&query=' . urlencode($fullAddress);
@endphp


<div
    class="bg-white dark:bg-neutral-900 border border-neutral-100 dark:border-neutral-800 rounded-2xl shadow-sm p-6 mb-6 {{ $sticky ? 'lg:sticky lg:top-24' : '' }}">
    <h3 class="text-xl lg:text-2xl font-bold text-neutral-900 dark:text-white mb-6">{{ __('Contactar con el vendedor') }}
    </h3>

    {{-- Personal Info --}}
    <div class="flex items-center gap-5 mb-8">
        <div
            class="w-24 h-24 rounded-full bg-neutral-200 dark:bg-neutral-800 flex items-center justify-center overflow-hidden shrink-0 shadow-sm border border-neutral-100 dark:border-neutral-700">
            @if ($agentAvatar)
                <img src="{{ $agentAvatar }}" alt="{{ $agentName }}" class="w-full h-full object-cover">
            @else
                <span
                    class="text-3xl font-bold text-neutral-400 dark:text-neutral-500">{{ strtoupper(substr($agentName, 0, 1)) }}</span>
            @endif
        </div>
        <div class="flex flex-col">
            <div class="text-lg font-bold text-neutral-900 dark:text-white mb-1">{{ $agentName }}</div>
            @if ($property->agency)
                <a href="{{ route('agencies.show', $property->agency->slug) }}"
                    class="text-sm font-medium text-neutral-500 dark:text-neutral-400 mb-1 hover:text-primary transition-colors underline decoration-2 underline-offset-4">{{ $property->agency->name }}</a>
            @endif
            @if ($agentPhone && $showPhone)
                <div class="text-sm text-neutral-500 dark:text-neutral-400 mb-0.5">
                    {{ $agentPhone }}
                </div>
            @endif

            @if ($agentEmail && $showEmail)
                <div class="text-sm text-neutral-500 dark:text-neutral-400">
                    {{ $agentEmail }}
                </div>
            @endif
        </div>
    </div>

    {{-- Location Info --}}
    @if ($fullAddress)
        <div class="flex items-start gap-4 mb-8">
            <div
                class="w-12 h-12 rounded-full border border-neutral-200 dark:border-neutral-700 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-neutral-900 dark:text-white" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                </svg>
            </div>
            <div class="flex flex-col pt-0.5">
                <div
                    class="text-base text-neutral-800 dark:text-neutral-200 font-medium mb-1 line-clamp-2 leading-tight">
                    {{ $fullAddress }}
                </div>
                <a href="{{ $mapUrl }}" target="_blank" rel="noopener noreferrer"
                    class="text-base font-bold text-neutral-900 dark:text-white hover:text-primary transition-colors underline decoration-2 underline-offset-4">
                    {{ __('Cómo llegar') }}
                </a>
            </div>
        </div>
    @endif

    {{-- Action Buttons --}}
    <div class="space-y-3">
        @if ($showPhone && $agentPhone)
            <a href="tel:{{ $agentPhone }}"
                class="flex items-center justify-center w-full bg-accent hover:bg-accent/90 text-white font-semibold text-base py-3.5 rounded-xl transition-colors shadow-sm gap-2">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                </svg>
                {{ __('Llamar por teléfono') }}
            </a>
        @endif

        @if ($showWhatsapp && $whatsappNumber)
            <a href="https://wa.me/{{ $whatsappNumber }}" target="_blank" rel="noopener noreferrer"
                class="flex items-center justify-center w-full bg-primary hover:bg-primary/90 text-white font-semibold text-base py-3.5 rounded-xl transition-colors shadow-sm gap-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                </svg>
                {{ __('Escribir en WhatsApp') }}
            </a>
        @endif
    </div>
</div>
