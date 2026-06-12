@props(['description'])

@if ($description)
    <section class="mb-8">
        <h2 class="text-xl font-bold text-neutral-900 dark:text-white mb-4">{{ __('Descripción') }}</h2>
        <div class="prose prose-neutral dark:prose-invert max-w-none text-sm leading-relaxed text-neutral-600 dark:text-neutral-300">
            {!! $description !!}
        </div>
    </section>
@endif
