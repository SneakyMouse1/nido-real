{{-- resources/views/components/public/icon.blade.php --}}
{{--
    Usage:
    <x-public.icon src="{{ asset('images/icons/bed.svg') }}" class="w-5 h-5" />

    Renders as <span> with mask-image — color comes from CSS
--}}
@props(['src', 'class' => 'w-5 h-5', 'alt' => ''])

<span role="{{ $alt ? 'img' : 'presentation' }}" aria-label="{{ $alt }}"
    {{ $attributes->merge(['class' => "icon-primary shrink-0 $class"]) }}
    style="-webkit-mask-image: url('{{ $src }}'); mask-image: url('{{ $src }}');"></span>
