@props(['link'])

<a
    href="{{ $link->href }}"
    @if ($link->opensInNewTab) target="_blank" rel="noopener" @endif
    @if ($link->isCurrent()) aria-current="page" @endif
    {{ $attributes->class(['hover:text-stone-950', 'font-semibold text-stone-950' => $link->isCurrent()]) }}
>{{ $link->title }}</a>
