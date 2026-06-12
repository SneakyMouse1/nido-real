@props(['videoUrl'])

@if ($videoUrl)
    <section class="mb-8">
        <h2 class="text-xl font-bold text-neutral-900 dark:text-white mb-4">{{ __('Vídeo') }}</h2>
        <div class="relative aspect-video rounded-xl overflow-hidden bg-neutral-900 shadow-md">
            @php
                // Convert YouTube watch URL to embed
                $url = preg_replace(
                    '/youtube\.com\/watch\?v=([^&]+)/',
                    'youtube.com/embed/$1',
                    $videoUrl,
                );
                $url = preg_replace('/youtu\.be\/([^?]+)/', 'youtube.com/embed/$1', $url);
            @endphp
            <iframe src="{{ $url }}" class="absolute inset-0 w-full h-full" frameborder="0"
                allow="autoplay; encrypted-media; picture-in-picture" allowfullscreen>
            </iframe>
        </div>
    </section>
@endif
