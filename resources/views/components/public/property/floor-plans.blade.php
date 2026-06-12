{{--
    Floor Plans accordion component.
    Props:
        $floorPlans — Spatie MediaCollection (from $property->getMedia('floor_plans'))
--}}
@props(['floorPlans'])

@if ($floorPlans && $floorPlans->isNotEmpty())
    <section class="mb-8">
        <h2 class="text-xl font-bold text-neutral-900 dark:text-white mb-4">{{ __('properties.floor_plans') }}</h2>

        <div class="flex flex-col gap-2">
            @foreach ($floorPlans as $i => $plan)
                @php
                    // Resolve title for the current locale, fallback to es, then generic
                    $rawTitle = is_object($plan) && method_exists($plan, 'getCustomProperty')
                        ? ($plan->getCustomProperty('title_' . app()->getLocale())
                            ?: $plan->getCustomProperty('title_es')
                            ?: (__('properties.floor_plan') . ' ' . ($i + 1)))
                        : ($plan['title_' . app()->getLocale()]
                            ?? $plan['title_es']
                            ?? (__('properties.floor_plan') . ' ' . ($i + 1)));

                    // Always start with uppercase letter
                    $title = ucfirst($rawTitle);

                    // Resolve URL: Spatie media object or raw path
                    $url = is_object($plan) && method_exists($plan, 'getUrl')
                        ? $plan->getUrl()
                        : ($plan['file'] ?? '');

                    if ($url && !Str::startsWith($url, 'http')) {
                        $url = Storage::url($url);
                    }
                @endphp

                {{-- Accordion item — first one open by default --}}
                <div x-data="{ open: {{ $i === 0 ? 'true' : 'false' }} }"
                     class="border border-neutral-200 dark:border-neutral-800 rounded-xl overflow-hidden">

                    {{-- Accordion header --}}
                    <button
                        @click="open = !open"
                        class="w-full flex items-center justify-between px-4 py-3.5 text-sm font-semibold text-left transition-colors"
                        :class="open
                            ? 'bg-primary/5 dark:bg-primary/10 text-primary'
                            : 'bg-neutral-50 dark:bg-neutral-900 text-neutral-700 dark:text-neutral-200 hover:bg-neutral-100 dark:hover:bg-neutral-800/60'"
                    >
                        <span class="flex items-center gap-2.5">
                            {{-- Blueprint icon --}}
                            <svg class="w-4 h-4 shrink-0 opacity-70" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M9 20H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3
                                         M9 12h.01M13 12h.01M17 12h.01M9 16h.01
                                         M13 20h6m-3-3v6" />
                            </svg>
                            {{ $title }}
                        </span>

                        {{-- Chevron rotates when open --}}
                        <svg class="w-4 h-4 shrink-0 transition-transform duration-200"
                             :class="{ 'rotate-180': open }"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    {{-- Accordion body with image --}}
                    <div
                        x-show="open"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 -translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 -translate-y-1"
                        class="border-t border-neutral-200 dark:border-neutral-800"
                    >
                        @if ($url)
                            <div class="bg-neutral-100 dark:bg-neutral-950 flex items-center justify-center p-6"
                                 style="min-height: 320px;">
                                <img
                                    src="{{ $url }}"
                                    alt="{{ $title }}"
                                    loading="lazy"
                                    class="max-w-full max-h-[480px] object-contain mix-blend-multiply dark:mix-blend-normal"
                                >
                            </div>
                        @else
                            <div class="flex items-center justify-center py-12 text-neutral-400 dark:text-neutral-600 text-sm">
                                {{ __('properties.no_image') }}
                            </div>
                        @endif
                    </div>

                </div>
            @endforeach
        </div>
    </section>
@endif
