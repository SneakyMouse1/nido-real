@props(['features'])

@if ($features && $features->isNotEmpty())
    <section class="mb-8">
        <h2 class="text-xl font-bold text-neutral-900 dark:text-white mb-4">{{ __('Utilidad de la vivienda') }}</h2>
        <div
            class="grid grid-cols-1 sm:grid-cols-2 gap-y-3 gap-x-6 bg-neutral-50 dark:bg-neutral-800/50 border border-neutral-100 dark:border-neutral-800 rounded-2xl p-5 sm:p-6 shadow-sm">
            @foreach ($features as $feature)
                <div class="flex items-center gap-2.5 font-medium text-neutral-700 dark:text-neutral-300">
                    @if ($feature->icon)
                        @svg($feature->icon, 'w-6 h-6 text-primary shrink-0')
                    @else
                        <svg class="w-6 h-6 text-primary shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    @endif
                    {{ $feature->name }}
                </div>
            @endforeach
        </div>
    </section>
@endif
