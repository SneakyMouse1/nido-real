{{--
    Public documents component.
    Shows only documents with is_public = true (custom_property set in Filament admin).
    Props:
        $documents — Spatie MediaCollection (from $property->getMedia('documents'))
--}}
@props(['documents'])

@php
    // Filter to only public documents
    $publicDocs = $documents
        ? $documents->filter(fn ($media) => (bool) $media->getCustomProperty('is_public', false))
        : collect();
@endphp

@if ($publicDocs->isNotEmpty())
    <section class="mb-8">
        <h2 class="text-xl font-bold text-neutral-900 dark:text-white mb-4">
            {{ __('properties.documents') }}
        </h2>

        <div class="flex flex-col gap-2">
            @foreach ($publicDocs as $doc)
                @php
                    $docTitle = $doc->getCustomProperty('title') ?: $doc->file_name;
                    $docUrl   = $doc->getUrl();
                @endphp

                <a
                    href="{{ $docUrl }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    download="{{ $doc->file_name }}"
                    class="group flex items-center justify-between gap-4 px-4 py-3.5
                           border border-neutral-200 dark:border-neutral-800 rounded-xl
                           bg-neutral-50 dark:bg-neutral-900
                           hover:border-primary/40 hover:bg-primary/5 dark:hover:bg-primary/10
                           transition-colors"
                >
                    <div class="flex items-center gap-3 min-w-0">
                        {{-- PDF icon --}}
                        <span class="shrink-0 w-9 h-9 flex items-center justify-center
                                     rounded-lg bg-neutral-200 dark:bg-neutral-800
                                     text-neutral-500 dark:text-neutral-400
                                     group-hover:bg-primary/10 group-hover:text-primary transition-colors">
                            <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5
                                         A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25
                                         m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25
                                         c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25
                                         a9 9 0 0 0-9-9Z" />
                            </svg>
                        </span>

                        {{-- Document title --}}
                        <span class="text-sm font-medium text-neutral-800 dark:text-neutral-200
                                     group-hover:text-primary transition-colors truncate">
                            {{ $docTitle }}
                        </span>
                    </div>

                    {{-- Download arrow --}}
                    <span class="shrink-0 text-neutral-400 dark:text-neutral-600
                                 group-hover:text-primary transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75
                                     V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                        </svg>
                    </span>
                </a>
            @endforeach
        </div>
    </section>
@endif
